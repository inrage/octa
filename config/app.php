<?php

use Illuminate\Support\Facades\Facade;
use Roots\Acorn\ServiceProvider;

return [
    'name' => env('APP_NAME', 'Octa'),
    'env' => defined('WP_ENV') ? WP_ENV : env('WP_ENV', 'production'),
    'debug' => WP_DEBUG && WP_DEBUG_DISPLAY,

    'url' => env('APP_URL', home_url()),
    'frontend_url' => env('WP_HMR_URL', home_url()),
    'asset_url' => env('ASSET_URL'),

    'timezone' => env('APP_TIMEZONE') ?: 'UTC',
    'locale' => env('APP_LOCALE', get_locale()),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    'providers' => ServiceProvider::defaultProviders()->merge([
    ])->merge([
        // Application Service Providers...
        // App\Providers\AppServiceProvider::class,
    ])->merge([
        // Added Service Providers (Do not remove this line)...
    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
    ])->toArray(),
];
