<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Email Subject Setting
    |--------------------------------------------------------------------------
    */
    'from' => env('MAIL_FROM_ADDRESS', 'developteamshoplm@gmail.com'),
    // Email Default To
    'to' => 'duc.daovan0709@gmail.com',
    // List Email CC
    'cc' => [
        'duc.daovan0709@gmail.com' => 'Ducdv'
    ],

    'contact_reply_test' => [
        'subject' => 'Subject Email Contact Reply'
    ],
    'contact_reply_admin' => [
        'subject' => 'Subject Email Contact Reply'
    ],
    'mail_username' => 'developteamshoplm@gmail.com',
    'mail_subject' => 'Shop LM',
];
