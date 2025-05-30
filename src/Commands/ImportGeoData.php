<?php

namespace NovaSemantics\NepalLocations\Commands;

use Exception;
use Illuminate\Console\Command;
use NovaSemantics\NepalLocations\Models\City;
use NovaSemantics\NepalLocations\Models\District;
use NovaSemantics\NepalLocations\Models\Province;
use NovaSemantics\NepalLocations\Services\GeoDataLoader;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\table;

class ImportGeoData extends Command
{
    public $signature = 'import:geo-data {--clean : Perform a clean import, truncating existing tables}';

    public $description = 'This command imports geographical data for Nepal, including provinces, districts, and cities.';

    private array $dataTypes = [
        'provinces' => 'Provinces',
        'districts' => 'Districts',
        'cities' => 'Cities',
    ];

    private array $fieldOptions = [
        'name' => 'Name',
        'name_np' => 'Name (Nepali)',
        'lat' => 'Latitude',
        'lng' => 'Longitude',
        'area' => 'Area',
        'population' => 'Population',
        'wards' => 'Wards (only for cities)',
    ];

    public function __construct(protected GeoDataLoader $dataLoader)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $isCleanOption = $this->option('clean');
        $types = $this->getDataTypes();
        $fields = [];

        // Handle clean import option
        $cleanImport = $isCleanOption || $this->confirmCleanImport();

        if ($cleanImport) {
            $this->cleanAndTruncateTables($types);
        } else {
            $fields = $this->selectFieldsToUpdate();
        }

        // Show import confirmation
        $this->displaySelectedOptions($types);

        if (! $this->confirmImport()) {
            $this->info('Import cancelled.');

            return 0;
        }

        // Process the import
        $this->processImport($types, $fields);

        return 0;
    }

    private function getDataTypes(): array
    {
        if ($this->option('clean')) {
            return array_keys($this->dataTypes);
        }

        return multiselect(
            'Select the type of data to import:',
            $this->dataTypes,
            array_keys($this->dataTypes)
        );
    }

    private function confirmCleanImport(): bool
    {
        return confirm(
            'Do you do a fresh import? This will delete all existing data in the selected tables. '.
            "If you choose 'No', existing records will be updated with new data.",
            true
        );
    }

    private function selectFieldsToUpdate(): array
    {
        $fields = multiselect(
            'Select fields to override for existing records (leave empty for all fields):',
            $this->fieldOptions
        );

        $this->newLine();
        $this->info('You have selected the following fields for import:');
        table(['Fields'], $fields ? array_map(fn ($field) => [$field], $fields) : [['All fields']]);

        return $fields;
    }

    private function displaySelectedOptions(array $types): void
    {
        $this->info('You have selected the following data types for import:');
        $this->newLine();
        table(['Data Types'], array_map(fn ($type) => [$type], $types));
    }

    private function confirmImport(): bool
    {
        if ($this->option('clean')) {
            return true;
        }

        return confirm('Are you sure you want to proceed with the import?');
    }

    private function processImport(array $types, array $fields): void
    {
        if (in_array('provinces', $types)) {
            $this->importProvinces($fields);
        }

        if (in_array('districts', $types)) {
            $this->importDistricts($fields);
        }

        if (in_array('cities', $types)) {
            $this->importCities($fields);
        }

        $this->info('Import completed successfully!');
    }

    protected function importProvinces(array $fields = []): void
    {
        $this->info('Importing provinces...');
        $provinces = $this->dataLoader->loadProvinces();

        foreach ($provinces as $province) {
            $data = $this->prepareImportData($province, $fields);
            Province::updateOrCreate(['id' => $province['id']], $data);
        }
    }

    protected function importDistricts(array $fields = []): void
    {
        $this->info('Importing districts...');
        $districts = $this->dataLoader->loadDistricts();

        foreach ($districts as $district) {
            $data = $this->prepareImportData($district, $fields);
            District::updateOrCreate(['id' => $district['id']], $data);
        }
    }

    protected function importCities(array $fields = []): void
    {
        $this->info('Importing cities...');
        $cities = $this->dataLoader->loadCities();

        foreach ($cities as $city) {
            $data = $this->prepareImportData($city, $fields);
            City::updateOrCreate(['id' => $city['id']], $data);
        }
    }

    private function prepareImportData(array $item, array $fields = []): array
    {
        if (empty($fields)) {
            return $item;
        }

        $data = array_intersect_key($item, array_flip($fields));

        return empty($data) ? $item : $data;
    }

    private function cleanAndTruncateTables(array $types): void
    {
        try {
            if (in_array('provinces', $types)) {
                $this->warn('Resetting provinces table...');
                Province::truncate();
            }

            if (in_array('districts', $types)) {
                $this->warn('Resetting districts table...');
                District::truncate();
            }

            if (in_array('cities', $types)) {
                $this->warn('Resetting cities table...');
                City::truncate();
            }
        } catch (Exception) {
            $this->error('An error occurred while truncating the tables.');
        }

        $this->newLine();
    }
}
