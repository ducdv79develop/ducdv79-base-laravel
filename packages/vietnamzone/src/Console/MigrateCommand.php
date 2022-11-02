<?php

namespace Packages\Vietnamzone\Console;

use \Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vietnamzone:migrate {action?} {--import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vietnamzoen Migrate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $import = $this->option('import');
        $this->info("Begin migration vietnamzone.....");
        $migrations = config('Vietnamzone::config.migrations');

        switch ($action) {
            case null:
                $command = 'migrate';
                $this->artisanCallCommand($command, $migrations);
                if ($import) {
                    $output = new BufferedOutput;
                    Artisan::call('vietnamzone:migrate_import', [], $output);
                    $this->info(trim($output->fetch()));
                }
                break;
            case 'refresh':
                $command1 = 'migrate:rollback';
                $migrations1 = array_reverse($migrations);
                $this->artisanCallCommand($command1, $migrations1);
                $command2 = 'migrate';
                $this->artisanCallCommand($command2, $migrations);
                if ($import) {
                    $output = new BufferedOutput;
                    Artisan::call('vietnamzone:migrate_import', [], $output);
                    $this->info(trim($output->fetch()));
                }
                break;
            case 'rollback':
                $command = 'migrate:rollback';
                $migrations = array_reverse($migrations);
                $this->artisanCallCommand($command, $migrations);
                break;
            default:
                $this->error("Command [php artisan vietnamzone:migrate $action] does not define.");
        }
    }

    /**
     * @param $command
     * @param $migrations
     */
    private function artisanCallCommand($command, $migrations)
    {
        $base_path = config('Vietnamzone::config.base_path');

        foreach ($migrations as $table => $filename) {
            $output = new BufferedOutput;
            Artisan::call($command, [
                '--path' => $base_path . $filename
            ], $output);
            $this->info(trim($output->fetch()));
        }
    }
}
