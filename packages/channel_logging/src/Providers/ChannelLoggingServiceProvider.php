<?php

namespace Packages\ChannelLogging\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ChannelLoggingServiceProvider extends ServiceProvider
{
    private $modulePath = __DIR__ . '/../../';
    private $moduleName = 'ChannelLogging';

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->mergeConfigFrom( $this->modulePath .'configs/channel_logging.php', $this->moduleName . '::channel_logging');
    }

    public function boot()
    {
        // boot views
        if (File::exists($this->modulePath . "resources/views")) {
            $this->loadViewsFrom($this->modulePath . "resources/views", $this->moduleName);
        }
    }
}
