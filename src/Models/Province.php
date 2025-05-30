<?php

namespace NovaSemantics\NepalLocations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents a province in Nepal with its attributes and relationships.
 *
 * @property int $id
 * @property string $name
 * @property string $name_np
 * @property float $lat
 * @property float $lng
 * @property float $area
 * @property int $population
 * @property District[] $districts
 * @property City[] $cities
 */
class Province extends Model
{
    use HasFactory;

    public function getTable(): string
    {
        return config('nepal-locations-laravel.table_prefix').'provinces';
    }

    protected $fillable = [
        'id',
        'name',
        'name_np',
        'lat',
        'lng',
        'area',
        'population',
        'additional_info',
    ];

    public $timestamps = false;

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'area' => 'float',
        'population' => 'integer',
    ];

    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'province_id', 'id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'province_id', 'id');
    }
}
