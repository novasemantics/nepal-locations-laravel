<?php

use NovaSemantics\NepalLocations\Models\City;
use NovaSemantics\NepalLocations\Models\District;
use NovaSemantics\NepalLocations\Models\Province;

// Test fetching a district
test('districts can be fetched', function () {
    $district = District::factory()->create();

    $fetchedDistrict = District::find($district->id);

    expect($fetchedDistrict)
        ->toBeInstanceOf(District::class)
        ->and($fetchedDistrict->id)->toBe($district->id);
});

// Test creating a district
test('districts can be created', function () {
    $districtData = [
        'name' => 'Test District',
        'name_np' => 'परीक्षण जिल्ला',
        'lat' => 28.3949,
        'lng' => 84.1240,
        'area' => 5000.5,
        'population' => 1000000,
        'province_id' => Province::factory()->create()->id,
    ];

    $district = District::create($districtData);

    expect($district)
        ->toBeInstanceOf(District::class)
        ->and($district->name)->toBe($districtData['name'])
        ->and($district->name_np)->toBe($districtData['name_np'])
        ->and($district->lat)->toBe($districtData['lat'])
        ->and($district->lng)->toBe($districtData['lng'])
        ->and($district->area)->toBe($districtData['area'])
        ->and($district->population)->toBe($districtData['population']);
});

test('districts can fetch cities', function () {
    $district = District::factory()->create();
    $city = City::factory()->create(['district_id' => $district->id]);

    $fetchedCities = $district->cities;

    expect($fetchedCities)
        ->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)
        ->and($fetchedCities->count())->toBe(1)
        ->and($fetchedCities->first()->id)->toBe($city->id);
});
