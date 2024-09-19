<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    /**
     * The endpoint to view the inbox
     */
    'prefix' => env('MAILTHIEF_PREFIX', 'dev'),

    /**
     * The endpoint to view the inbox
     */
    'endpoint' => env('MAILTHIEF_ENDPOINT', 'emails'),

    /**
     * The theme which to use
     *
     * Supported: tailwind, bootstrap
     */
    'theme' => env('MAILTHIEF_THEME', 'tailwind'),

    /**
     * Middleware classes to protect the inbox.
     */
    'middleware' => [
        'web',
    ],
];
