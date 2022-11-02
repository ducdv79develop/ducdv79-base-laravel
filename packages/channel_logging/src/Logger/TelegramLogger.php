<?php

namespace Packages\ChannelLogging\Logger;

use Monolog\Logger;
use Packages\ChannelLogging\Handlers\TelegramHandler;

/**
 * Class TelegramLogger
 * @package App\Logging
 */
class TelegramLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return Logger
     */
    public function __invoke(array $config): Logger
    {
        return new Logger(
            config('app.name'),
            [
                new TelegramHandler($config),
            ]
        );
    }
}
