<?php

namespace NovaSemantics\NepalLocations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents a district in Nepal with its attributes and relationships.
 *
 * @property int $id
 * @property string $name
 * @property string $name_np
 * @property int $province_id
 * @property float $lat
 * @property float $lng
 * @property float $area
 * @property int $population
 * @property Province $province
 * @property City[] $cities
 */
class District extends Model
{
    use HasFactory;

    public function getTable(): string
    {
        return config('nepal-locations-laravel.table_prefix').'districts';
    }

    protected $fillable = [
        'id',
        'name',
        'name_np',
        'province_id',
        'lat',
        'lng',
        'area',
        'population',
        'is_capital',
        'additional_info',
    ];

    public $timestamps = false;

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'area' => 'float',
        'population' => 'integer',
        'is_capital' => 'boolean',
        'additional_info' => 'array',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'district_id', 'id');
    }
}
