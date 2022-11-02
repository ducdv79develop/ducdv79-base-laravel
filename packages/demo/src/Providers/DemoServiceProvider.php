<?php

namespace Packages\Demo\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DemoServiceProvider extends ServiceProvider
{
    private $modulePath = __DIR__ . '/../../';
    private $moduleName = 'Demo';
    private $namespace = 'Packages\Demo\Http\Controllers';

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $models = array(
        );
        foreach ($models as $model) {
            $this->app->bind("Packages\\Demo\\Repositories\\{$model}\\{$model}Repository",
                "Packages\\Demo\\Repositories\\{$model}\\{$model}Eloquent");
        }
        // register configs
        $this->mergeConfigFrom( $this->modulePath .'configs/demo.php', $this->moduleName . '::demo');
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

        // boot migration
        if (File::exists($this->modulePath . "migrations")) {
            $this->loadMigrationsFrom($this->modulePath . "migrations");
        }

        // boot views
        if (File::exists($this->modulePath . "resources/views")) {
            $this->loadViewsFrom($this->modulePath . "resources/views", $this->moduleName);
        }

        // boot languages
        if (File::exists($this->modulePath . "resources/lang")) {
            $this->loadTranslationsFrom($this->modulePath . "resources/lang", $this->moduleName);
            $this->loadJSONTranslationsFrom($this->modulePath . 'resources/lang');
        }

        // boot route
        if (File::exists($this->modulePath."routes/routes.php")) {
            $this->loadRoutesFrom($this->modulePath."routes/routes.php");
            $this->mapWebRoutes();
        }
    }

    /**
     * Map middleware web by routes
     */
    public function mapWebRoutes()
    {
        Route::middleware('web')->namespace($this->namespace)->group($this->modulePath . 'routes/routes.php');
    }
}
