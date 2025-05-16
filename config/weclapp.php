<?php

return [
    'api_base_url' => env('WECLAPP_API_BASE_URL'),
    'auth_token' => env('WECLAPP_AUTH_TOKEN'),

    'logging' => [
        'enabled' => (bool) env('WECLAPP_ENABLE_LOGGING', true),
    ],
];
