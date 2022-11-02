<?php

return [
    'telegram' => [
        // Telegram logger bot token
        'token' => env('TELEGRAM_LOGGER_BOT_TOKEN'),
        // Telegram chat id
        'chat_id' => env('TELEGRAM_LOGGER_CHAT_ID'),
        // Blade Template to use formatting logs
        'template' => env('TELEGRAM_LOGGER_TEMPLATE', 'ChannelLogging::telegram.standard'),
        // Telegram sendMessage options: https://core.telegram.org/bots/api#sendmessage
        'base_url' => env('TELEGRAM_BASE_URL', 'https://api.telegram.org/'),
        'options' => [
            'parse_mode' => 'html',
            'disable_web_page_preview' => false,
            'disable_notification' => false
        ]
    ]
];
