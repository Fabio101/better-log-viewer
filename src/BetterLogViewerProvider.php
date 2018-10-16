<?php

namespace Arukompas\BetterLogViewer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BetterLogViewerProvider extends ServiceProvider
{
    protected $namespace = 'Arukompas\BetterLogViewer\Http\Controllers';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/arukompas/better-log-viewer'),
            __DIR__.'/../fonts' => public_path('fonts'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/config/better-log-viewer.php' => config_path('better-log-viewer.php'),
        ], 'config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'better-log-viewer');

        $this->mergeConfigFrom(
            __DIR__.'/config/better-log-viewer.php', 'better-log-viewer'
        );
    }

    protected function mapWebRoutes()
    {
        Route::group([
            'prefix' => config('better-log-viewer.route_path', 'log-viewer'),
            'middleware' => config('better-log-viewer.middleware', ''),
            'namespace' => $this->namespace,
        ], function () {
            require __DIR__.'/routes/web.php';
        });
    }

    protected function mapApiRoutes()
    {
        Route::group([
            'prefix' => str_finish(config('better-log-viewer.route_path'), '/') . 'api',
            'middleware' => config('better-log-viewer.api_middleware', ''),
            'namespace' => $this->namespace . '\Api',
        ], function () {
            require __DIR__.'/routes/api.php';
        });
    }
}
