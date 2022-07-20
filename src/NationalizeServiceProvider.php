<?php

declare(strict_types=1);

namespace Faicchia\Nationalize;

use Illuminate\Support\ServiceProvider;

class NationalizeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nationalize.php', 'nationalize');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/nationalize.php' => config_path('nationalize.php'),
            ], 'nationalize');
        }
    }
}
