<?php

namespace Packages\ChannelLogging\Handlers;

use Exception;
use InvalidArgumentException;
use Log;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Class TelegramHandler
 * @package App\Logging
 */
class TelegramHandler extends AbstractProcessingHandler
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $botToken;

    /**
     * @var int
     */
    private $chatId;

    /**
     * @string
     */
    private $appName;

    /**
     * @string
     */
    private $appEnv;

    /**
     * TelegramHandler constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        parent::__construct($level, true);
        // define variables for making Telegram request
        $this->config = $config;
        $this->baseUrl = $this->getConfigValue('base_url');
        $this->botToken = $this->getConfigValue('token');
        $this->chatId   = $this->getConfigValue('chat_id');

        // define variables for text message
        $this->appName = config('app.name');
        $this->appEnv  = config('app.env');
    }

    /**
     * @param array $record
     */
    public function write(array $record): void
    {
        if(!$this->botToken || !$this->chatId) {
            throw new InvalidArgumentException('Bot token or chat id is not defined for Telegram logger');
        }

        // trying to make request and send notification
        try {
            $textChunks = str_split($this->formatText($record), 4096);

            foreach ($textChunks as $textChunk) {
                $this->sendMessage($textChunk);
            }
        } catch (Exception $exception) {
            Log::channel('single')->error($exception->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new LineFormatter("%message% %context% %extra%\n", null, true, true);
    }

    /**
     * @param array $record
     * @return string
     */
    private function formatText(array $record): string
    {
        if (isset($record['formatted'])) $record['formatted'] = $this->formatLineBreakText($record['formatted']);
        if ($template = $this->getConfigValue('template')) {
            return view($template, array_merge($record, [
                    'appName' => $this->appName,
                    'appEnv'  => $this->appEnv,
                ])
            );
        }

        return sprintf("<b>%s</b> (%s)\n%s", $this->appName, $record['level_name'], $record['formatted']);
    }

    /**
     * @param  string  $text
     */
    private function sendMessage(string $text): void
    {
        $httpQuery = http_build_query(array_merge(
            [
                'text' => $text,
                'chat_id' => $this->chatId,
                'parse_mode' => 'html',
            ],
            $this->getConfigValue('options')
        ));

        file_get_contents("{$this->baseUrl}bot{$this->botToken}/sendMessage?" . $httpQuery);
    }

    /**
     * @param string $key
     * @param null $defaultConfigKey
     * @return mixed
     */
    private function getConfigValue(string $key, $defaultConfigKey = null)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        return config($defaultConfigKey ?: "ChannelLogging::channel_logging.telegram.$key");
    }

    /**
     * @param string $text
     * @return string|string[]
     */
    private function formatLineBreakText(string $text)
    {
        $text = str_replace('  ', ' ', $text);
        return $text;
    }
}
