<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SOTK SERVER
    |--------------------------------------------------------------------------
    |
    | setup SOTK server credentials here
    |
    */

    'client_uri' => env('SIMPEG_URI', 'https://api.simpeg.bkpsdm.karawangkab.go.id'),
    'client_id' => env('SIMPEG_CLIENT_ID'),
    'client_secret' => env('SIMPEG_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | SOTK Routes
    |--------------------------------------------------------------------------
    |
    | Here you can define SOTK route as you need.
    |
    */

    'prefix' => 'simpeg', // nullable
    'middleware' => ['auth']
];
