<?php

namespace NovaSemantics\NepalLocations\Services;

class GeoDataLoader
{
    public function loadProvinces(): array
    {
        return $this->loadJson('provinces');
    }

    public function loadDistricts(): array
    {
        return $this->loadJson('districts');
    }

    public function loadCities(): array
    {
        return $this->loadJson('cities');
    }

    protected function loadJson(string $file): array
    {
        $path = __DIR__.'/../../resources/data/'.$file.'.json';

        return json_decode(file_get_contents($path), true);
    }
}
