<?php

use NovaSemantics\NepalLocations\Commands\ImportGeoData;
use NovaSemantics\NepalLocations\Models\City;
use NovaSemantics\NepalLocations\Models\District;
use NovaSemantics\NepalLocations\Models\Province;

use function Pest\Laravel\artisan;

it('imports all geo data when --clean option is used', function () {
    // Run command with --clean option
    artisan(ImportGeoData::class, ['--clean' => true])
        ->expectsOutput('Resetting provinces table...')
        ->expectsOutput('Resetting districts table...')
        ->expectsOutput('Resetting cities table...')
        ->expectsOutput('Importing provinces...')
        ->expectsOutput('Importing districts...')
        ->expectsOutput('Importing cities...')
        ->expectsOutput('Import completed successfully!')
        ->assertExitCode(0);

    expect(Province::count())->not->toBe(0)
        ->and(District::count())->not->toBe(0)
        ->and(City::count())->not->toBe(0);
});
