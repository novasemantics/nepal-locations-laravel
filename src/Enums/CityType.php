<?php

namespace NovaSemantics\NepalLocations\Enums;

enum CityType: string
{
    case Municipality = 'Municipality';
    case RuralMunicipality = 'Rural Municipality';
    case SubMetropolitan = 'Sub-Metropolitan';
    case Metropolitan = 'Metropolitan';

    public function inNepali(): string
    {
        return match ($this) {
            self::Municipality => 'नगरपालिका',
            self::RuralMunicipality => 'गाउँपालिका',
            self::SubMetropolitan => 'उप-महानगरपालिका',
            self::Metropolitan => 'महानगरपालिका',
        };
    }
}
