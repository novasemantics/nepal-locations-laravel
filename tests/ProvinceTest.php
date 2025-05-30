<?php

use NovaSemantics\NepalLocations\Models\City;
use NovaSemantics\NepalLocations\Models\District;
use NovaSemantics\NepalLocations\Models\Province;

test('provinces can be fetched', function () {
    $province = Province::factory()->create();

    $fetchedProvince = Province::find($province->id);

    expect($fetchedProvince)
        ->toBeInstanceOf(Province::class)
        ->and($fetchedProvince->id)->toBe($province->id);
});

test('provinces can be created', function () {
    $provinceData = [
        'name' => 'Test Province',
        'name_np' => 'परीक्षण प्रदेश',
        'lat' => 28.3949,
        'lng' => 84.1240,
        'area' => 50000.21,
        'population' => 1000000,
    ];

    $province = Province::create($provinceData);

    expect($province)
        ->toBeInstanceOf(Province::class)
        ->and($province->name)->toBe($provinceData['name'])
        ->and($province->name_np)->toBe($provinceData['name_np'])
        ->and($province->lat)->toBe($provinceData['lat'])
        ->and($province->lng)->toBe($provinceData['lng'])
        ->and($province->area)->toBe($provinceData['area'])
        ->and($province->population)->toBe($provinceData['population']);
});

test('provinces can be updated', function () {
    $province = Province::factory()->create();

    $updatedData = [
        'name' => 'Updated Province',
        'name_np' => 'अपडेट गरिएको प्रदेश',
        'lat' => 29.1234,
        'lng' => 85.5678,
        'area' => 60000.22,
        'population' => 2000000,
    ];

    $province->update($updatedData);

    expect($province)
        ->toBeInstanceOf(Province::class)
        ->and($province->name)->toBe($updatedData['name'])
        ->and($province->name_np)->toBe($updatedData['name_np'])
        ->and($province->lat)->toBe($updatedData['lat'])
        ->and($province->lng)->toBe($updatedData['lng'])
        ->and($province->area)->toBe($updatedData['area'])
        ->and($province->population)->toBe($updatedData['population']);
});

test('provinces can have districts and cities', function () {
    $province = Province::factory()->create();

    $districtCount = 5;
    $cityCount = 10;

    District::factory($districtCount)->create([
        'province_id' => $province->id,
    ]);

    City::factory($cityCount)->create([
        'province_id' => $province->id,
    ]);

    expect($province->districts)
        ->toHaveCount($districtCount)
        ->and($province->cities)
        ->toHaveCount($cityCount);
});
