# Nepal Locations (Laravel Package)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/novasemantics/nepal-locations-laravel.svg?style=flat-square)](https://packagist.org/packages/novasemantics/nepal-locations-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/novasemantics/nepal-locations-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/novasemantics/nepal-locations-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/novasemantics/nepal-locations-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/novasemantics/nepal-locations-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/novasemantics/nepal-locations-laravel.svg?style=flat-square)](https://packagist.org/packages/novasemantics/nepal-locations-laravel)

---

NepalLocations is a Laravel package providing **Nepal’s geographical data** — provinces, districts, cities, and their
hierarchical relationships. It offers a structured way to access and manipulate this data using Laravel's powerful query
builder API.

---

## Features

- Eloquent models: `Province`, `District`, `City`
- Collision free table names with configurable prefixes
- Enum support for `CityType`
- One-command import with:
    - Full or partial import options
    - Smart update/merge of existing data
    - Selective field overriding
- JSON-driven immutable source data
- Useful relationships:
    - `Province → Districts & Cities`
    - `District → Cities`

---

## Installation

Require the package via Composer:

```bash
composer require novasemantics/nepal-locations-laravel
```

You can install the package's assets and configuration file using the following artisan command:

```bash
php artisan nepal-locations-laravel:install
```

- The installation command will publish the package's configuration file to `config/nepal-locations-laravel.php`.
- It will also publish the migration files to `database/migrations/`.
- Then you will be asked to run the migrations to create the necessary database tables.
- Finally, you will be prompted to run the import command to populate the database with initial data.

---

## How to Get Updated Data

The package is maintained with the latest geographical data of Nepal. To get the most recent data, you
can update the package using Composer:

```bash
composer update novasemantics/nepal-locations-laravel
```

Then you can manually run the import command to refresh the data in your database:

```bash
php artisan import:geo-data
```

Fresh Import option will be provided to overwrite existing data with the latest from the package, if
you have been using the data in foreign keys or relationships, you can choose to update only the fields you need
without affecting the existing relationships. As the ID's for geo tables are immutable, you can safely update
without worrying about breaking changes.

## ⚙️ Models Overview

### Province

The `Province` model represents Nepal's administrative provinces. It contains information about the province's name,
area, population, and its districts.

### District

The `District` model represents the districts within a province. It includes details such as the district's name, area,
population, and the province it belongs to.

### City

The `City` model represents cities within a district. It includes the city's name, type (e.g., Metropolitan,
Sub-Metropolitan), area, population, and the district it belongs to.

### Data Structure

| Field               | Type    | Description                                         | Models         |
|---------------------|---------|-----------------------------------------------------|----------------|
| `id`                | Integer | Unique identifier                                   | All            |
| `name`              | String  | English name of the location                        | All            |
| `name_np`           | String  | Nepali name of the location                         | All            |
| `lat`               | Float   | Latitude                                            | All            |
| `lng`               | Float   | Longitude                                           | All            |
| `area`              | Float   | Area in square kilometers                           | All            |
| `population`        | Integer | Population count                                    | All            |
| `type`              | Enum    | Type of city (e.g., Metropolitan, Sub-Metropolitan) | City           |
| `wards`             | Integer | Number of administrative wards                      | City           |
| `province_id`       | Integer | Foreign key to Province                             | District, City |
| `district_id`       | Integer | Foreign key to District                             | City           |
| `additional_fields` | Array   | Additional fields like website,phone                | All            |

---

## 📥 Importing Geo Data

Use the following artisan command:

```bash
php artisan import:geo-data
```

### What it does:

- Interactive CLI to:
    - Choose which data types to import (`provinces`, `districts`, `cities`)
    - Perform **fresh import** or **update** mode
    - Select specific fields to override on update
    - Confirm before execution

### Example:

```
php artisan import:geo-data
```

> You’ll be prompted with interactive options for a safe and flexible import experience.

---

## 💡 Example Usage

### Get all districts of Province ID 3

```php
use NovaSemantics\NepalLocations\Models\Province;

$province = Province::find(3);
$districts = $province->districts;

// Or directly get cities of the province
$cities = $province->cities;
```

### Get all cities of a district

```php
use NovaSemantics\NepalLocations\Models\District;

$district = District::find(12);
$cities = $district->cities;
```

### Get all metropolitan cities

```php
use NovaSemantics\NepalLocations\Enums\CityType;
use NovaSemantics\NepalLocations\Models\City;

$cities = City::where('type', CityType::Metropolitan)->get();
```

---

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
