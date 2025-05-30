<?php

namespace NovaSemantics\NepalLocations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use NovaSemantics\NepalLocations\Enums\CityType;

/**
 * Represents a city in Nepal with its attributes and relationships.
 *
 * @property int $id
 * @property string $name
 * @property string $name_np
 * @property CityType $type
 * @property int $province_id
 * @property int $district_id
 * @property float $lat
 * @property float $lng
 * @property int $population
 * @property int $wards
 * @property float $area
 */
class City extends Model
{
    use HasFactory;

    public function getTable(): string
    {
        return config('nepal-locations-laravel.table_prefix').'cities';
    }

    protected $fillable = [
        'id',
        'name',
        'name_np',
        'type',
        'province_id',
        'district_id',
        'lat',
        'lng',
        'population',
        'wards',
        'area',
        'additional_info',
    ];

    public $timestamps = false;

    protected $casts = [
        'type' => CityType::class,
        'lat' => 'float',
        'lng' => 'float',
        'area' => 'float',
        'wards' => 'integer',
        'population' => 'integer',
        'additional_info' => 'array',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
