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
     * Middleware classes to protect the inbox.
     */
    'middleware' => [
        'web',
    ],
];
