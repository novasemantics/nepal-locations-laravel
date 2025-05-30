# Changelog

All notable changes to `nepal-locations-laravel` will be documented in this file.

## v1.0.0 - 2025-05-30

- Complete geographical data for Nepal's 7 provinces, 77 districts, and 753 municipalities
- Three eloquent models with relationships: Province, District, and City
- City type categorization using CityType enum (Metropolitan, Sub-Metropolitan, Municipality, Rural Municipality)
- Installable via Composer with `novasemantics/nepal-geodata`
- Interactive command `php artisan nepal-geodata:install` with guided setup
- Flexible data import system with `php artisan import:geo-data`
- Table name prefix configuration to prevent collisions
- Comprehensive model relationships for traversing geographic hierarchies
- Accurate geographic data including coordinates, area and population statistics
- Support for PHP 8.2+
- Laravel 11+ compatibility
