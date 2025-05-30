<?php

namespace NovaSemantics\NepalLocations\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NovaSemantics\NepalLocations\Models\District;
use NovaSemantics\NepalLocations\Models\Province;

class DistrictFactory extends Factory
{
    protected $model = District::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'name_np' => $this->faker->unique()->word(),
            'lat' => $this->faker->latitude(26.347, 30.447),
            'lng' => $this->faker->longitude(80.058, 88.201),
            'area' => $this->faker->numberBetween(1000, 50000),
            'population' => $this->faker->numberBetween(1000000, 10000000),
            'province_id' => Province::factory(),
        ];
    }
}
