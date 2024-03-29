<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => '451237439986178',
        'client_secret' => '127b8da68b73a990db216bc541597446',
        'redirect' => 'https://localhost/Myproject/MetronicProjectModal/public/login/facebook/callback',
    ],
    'google' => [
        'client_id' => '148822435030-2gjcoe787elrvjp065jvg5kte5mgnpns.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost/Myproject/MetronicProjectModal/public/login/Google/callback',
    ],
];
