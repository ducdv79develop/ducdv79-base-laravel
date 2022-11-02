<?php

namespace Packages\Vietnamzone\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Packages\Vietnamzone\Console\MigrateCommand;
use Packages\Vietnamzone\Console\MigrateImportDataCommand;

class VietnamZoneServiceProvider extends ServiceProvider
{
    private $modulePath = __DIR__ . '/../../';
    private $moduleName = 'Vietnamzone';
    private $namespace = 'Packages\Vietnamzone\Http\Controllers';

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        // register configs
        $this->mergeConfigFrom( $this->modulePath .'configs/vietnamzone.php', $this->moduleName . "::config");
    }

    public function boot()
    {
        // boot route
        if (File::exists($this->modulePath."routes/api.php")) {
            $this->loadRoutesFrom($this->modulePath."routes/api.php");
            $this->mapApiRoutes();
        }
        // boot command
        $this->registerCommands();
    }

    /**
     * Map middleware web by routes
     */
    public function mapApiRoutes()
    {
        $version = config('Vietnamzone::config.version');
        Route::middleware('api')
            ->prefix("api/$version/")
            ->namespace($this->namespace)
            ->group($this->modulePath . 'routes/api.php');
    }

    /**
     * Register commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands([
            MigrateCommand::class,
            MigrateImportDataCommand::class,
        ]);
    }
}
