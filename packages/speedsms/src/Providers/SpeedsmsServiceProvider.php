<?php

namespace Packages\Speedsms\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SpeedsmsServiceProvider extends ServiceProvider
{
    private $modulePath = __DIR__ . '/../../';
    private $moduleName = 'Speedsms';
    private $namespace = 'Packages\Speedsms\Http\Controllers';

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        // register configs
        $this->mergeConfigFrom( $this->modulePath .'configs/speedsms.php', $this->moduleName . '::speedsms');
    }

    public function boot()
    {
        // boot all helpers
        if (File::exists($this->modulePath . "helpers")) {
            $helper_dir = File::allFiles($this->modulePath . "helpers");
            foreach ($helper_dir as $key => $value) {
                $file = $value->getPathName();
                require_once $file;
            }
        }

        // boot route
        if (File::exists($this->modulePath."routes/apis.php")) {
            $this->loadRoutesFrom($this->modulePath."routes/apis.php");
            $this->mapApiRoutes();
        }
    }

    /**
     * Map middleware web by routes
     */
    public function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->group($this->modulePath . 'routes/apis.php');
    }
}
