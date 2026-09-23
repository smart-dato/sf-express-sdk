<?php

// config for SmartDato/SfExpress
return [
    // SIT (sandbox): https://api-ifsp-sit.sf.global
    'base_url' => env('SF_EXPRESS_BASE_URL'),

    'app' => [
        'key' => env('SF_EXPRESS_API_KEY'),
        'secret' => env('SF_EXPRESS_SECRET'),
        'encoding_aes_key' => env('SF_EXPRESS_ENCODING_AES_KEY'),
    ],
];
