<?php

return [
    'paths' => [
        'services',
        'services/*',
        'projects',
        'projects/*',
        'posts',
        'posts/*',
        'categories',
        'contact',
        'consultation',
        'quote',
        'quote/*',
        'testimonials',
        'faqs',
        'settings',
        'board-members',
        'partners',
        'files',
        'files/*',
        'admin',
        'admin/*',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_values(array_filter(array_merge(
        [env('FRONTEND_URL')],
        array_map('trim', explode(',', (string) env('FRONTEND_URLS', '')))
    ))),

    /*
     * Local Next.js often runs on any port (3000, 3001, …). Listing every origin in .env is fragile,
     * so in local we allow http://localhost:* and http://127.0.0.1:* via patterns.
     */
    'allowed_origins_patterns' => env('APP_ENV') === 'local'
        ? [
            '#^http://localhost(:\d+)?$#',
            '#^http://127\.0\.0\.1(:\d+)?$#',
        ]
        : [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];

