<?php

namespace Modules\Admin\Console;

class Command extends \Illuminate\Console\Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Module';

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

    }
}
