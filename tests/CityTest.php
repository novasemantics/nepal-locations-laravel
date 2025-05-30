<?php

use NovaSemantics\NepalLocations\Enums\CityType;
use NovaSemantics\NepalLocations\Models\City;

test('cities can be fetched', function () {
    $city = City::factory()->create();

    $fetchedCity = City::find($city->id);

    expect($fetchedCity)
        ->toBeInstanceOf(City::class)
        ->and($fetchedCity->id)->toBe($city->id);
});

test('cities can be created', function () {
    $cityData = [
        'name' => 'Test City',
        'name_np' => 'परीक्षण शहर',
        'type' => CityType::Metropolitan,
        'province_id' => 1,
        'district_id' => 1,
        'lat' => 27.7172,
        'lng' => 85.324,
        'population' => 500000,
        'wards' => 10,
        'area' => 100.5,
    ];

    $city = City::create($cityData);

    expect($city)
        ->toBeInstanceOf(City::class)
        ->and($city->name)->toBe($cityData['name'])
        ->and($city->name_np)->toBe($cityData['name_np'])
        ->and($city->type)->toBe($cityData['type'])
        ->and($city->province_id)->toBe($cityData['province_id'])
        ->and($city->district_id)->toBe($cityData['district_id'])
        ->and($city->lat)->toBe($cityData['lat'])
        ->and($city->lng)->toBe($cityData['lng'])
        ->and($city->population)->toBe($cityData['population'])
        ->and($city->wards)->toBe($cityData['wards'])
        ->and($city->area)->toBe($cityData['area']);
});

test('cities can be updated', function () {
    $city = City::factory()->create();

    $updatedData = [
        'name' => 'Updated City',
        'name_np' => 'अपडेट गरिएको शहर',
        'type' => CityType::SubMetropolitan,
        'province_id' => 2,
        'district_id' => 2,
        'lat' => 28.3949,
        'lng' => 84.1240,
        'population' => 600000,
        'wards' => 12,
        'area' => 150.75,
    ];

    $city->update($updatedData);

    expect($city)
        ->toBeInstanceOf(City::class)
        ->and($city->name)->toBe($updatedData['name'])
        ->and($city->name_np)->toBe($updatedData['name_np'])
        ->and($city->type)->toBe($updatedData['type'])
        ->and($city->province_id)->toBe($updatedData['province_id'])
        ->and($city->district_id)->toBe($updatedData['district_id'])
        ->and($city->lat)->toBe($updatedData['lat'])
        ->and($city->lng)->toBe($updatedData['lng'])
        ->and($city->population)->toBe($updatedData['population'])
        ->and($city->wards)->toBe($updatedData['wards'])
        ->and($city->area)->toBe($updatedData['area']);
});

test('cities can get related province details', function () {
    $city = City::factory()->create();
    $province = $city->province;

    expect($province)
        ->toBeInstanceOf(NovaSemantics\NepalLocations\Models\Province::class)
        ->and($province->id)->toBe($city->province_id);
});
