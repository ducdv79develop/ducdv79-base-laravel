<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        try {
            $models = array_map('basename', File::directories('../app/Repositories'));
        } catch (Exception $exception) {
            $models = [];
        }
        foreach ($models as $model) {
             $this->app->bind("App\Repositories\\{$model}\\{$model}Repository",
                 "App\Repositories\\{$model}\\{$model}Eloquent");
        }
    }
}
