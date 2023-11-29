# Custom websockets driver

## Config

config/broadcasting.php
```php
    //

    'custom' => [
        'driver' => 'custom-broadcaster',
        'app_secret' => env('WEBSOCKETS_APP_SECRET'),
        'app_id' => env('WEBSOCKETS_APP_ID'),
        'host' => env('WEBSOCKETS_HOST'),
        'port' => env('WEBSOCKETS_PORT', 4001),
        'scheme' => env('WEBSOCKETS_SCHEME', 'ws'),
    ],
```
