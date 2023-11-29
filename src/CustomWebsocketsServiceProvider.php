<?php

namespace NoahWilderom\CustomWebsockets;

use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\ServiceProvider;

class CustomWebsocketsServiceProvider extends ServiceProvider
{
    public function boot(BroadcastManager $broadcastManager): void
    {
        $this->offerPublishing();

        $this->registerDriver($broadcastManager);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/custom-websockets.php',
            'custom-websockts'
        );
    }

    protected function offerPublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (! function_exists('config_path')) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/custom-websockets.php' => config_path('custom-websockets.php'),
        ], 'custom-websockets-config');
    }

    protected function registerDriver(BroadcastManager $broadcastManager): void
    {
        $broadcastManager->extend('custom-broadcaster', fn ($app, array $config) => new CustomBroadcaster($config));
    }
}
