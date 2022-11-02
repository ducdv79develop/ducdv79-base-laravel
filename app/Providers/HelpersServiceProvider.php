<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Create Sortable Link Blade
         */
        Blade::directive('sortablelink', function($expression) {
            $expression = ($expression[0] === '(') ? substr($expression, 1, -1) : $expression;
            return "<?php echo \App\Helpers\SortableLink::render(array ({$expression}));?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/SortableLink.php';
    }
}
