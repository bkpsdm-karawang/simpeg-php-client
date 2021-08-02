<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Serever url
    */
    'server_url' => env('SIMPEG_URL', 'https://api.simpeg.bkpsdm.karawangkab.go.id'),
    'issue_token_url' => env('SIMPEG_ISSUE_TOKEN_URL', '/oauth/token'),
    'get_profile_url' => env('SIMPEG_PROFILE_URL', '/api/me'),

    /*
    |--------------------------------------------------------------------------
    | Credentiasl
    */
    'client_id' => env('SIMPEG_CLIENT_ID'),
    'client_secret' => env('SIMPEG_CLIENT_SECRET'),
    'client_scope' => env('SIMPEG_CLIENT_SCOPE', '*'),
    'client_callback_url' => env('APP_URL').'/callback/simpeg',
    'user_scope' => env('SIMPEG_USER_SCOPE', 'profile pegawai'),

    /*
    |--------------------------------------------------------------------------
    | SIM-ASN Routes
    */
    'prefix' => 'simpeg', // nullable
    'middleware' => ['auth'],
];
