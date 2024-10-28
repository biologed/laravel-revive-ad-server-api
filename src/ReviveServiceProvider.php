<?php

namespace Biologed\Revive;

use Illuminate\Support\ServiceProvider;

class ReviveServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/config/revive.php' => config_path('revive.php'),
        ]);
    }
    public function register(): void
    {
    }
}
