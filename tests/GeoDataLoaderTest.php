<?php

use NovaSemantics\NepalLocations\Services\GeoDataLoader;

it('loads all province data', function () {
    $loader = new GeoDataLoader;
    $provinces = $loader->loadProvinces();

    expect($provinces)
        ->toBeArray()
        ->and($provinces)
        ->each
        ->toHaveKeys([
            'id', 'name', 'name_np', 'lat', 'lng', 'area', 'population',
        ]);
});

it('loads all districts and cities', function () {
    $loader = new GeoDataLoader;

    expect($loader->loadDistricts())
        ->toBeArray()
        ->and($loader->loadCities())
        ->toBeArray();
});
