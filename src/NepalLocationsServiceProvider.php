<?php

namespace NovaSemantics\NepalLocations;

use NovaSemantics\NepalLocations\Commands\ImportGeoData;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NepalLocationsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('nepal-locations-laravel')
            ->hasConfigFile()
            ->hasCommand(ImportGeoData::class)
            ->hasMigration('create_nepal_geodata_table')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('novasemantics/nepal-locations-laravel')
                    ->endWith(function (InstallCommand $command) {
                        $runImport = $command->confirm('Would you like to run the geo data import now?', true);

                        if (! $runImport) {
                            $command->info('Skipping geo data import.');
                            $command->info('You can run the import later using:');
                            $command->comment('php artisan import:geo-data');
                            $command->newLine();

                            return;
                        }

                        $command->info('Running geo data import...');

                        $command->call('import:geo-data', [
                            '--clean' => true,
                        ]);

                        $command->newLine();
                    });
            });
    }
}
