<?php

namespace App\Jobs;

use App\Traits\TraceLogException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class JobsAbstract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * use trace log exception custom
     */
    use TraceLogException;

    /**
     * JobsAbstract constructor.
     */
    public function __construct()
    {

    }
}
