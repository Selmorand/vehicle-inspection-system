<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Environment-Specific Configuration
    |--------------------------------------------------------------------------
    |
    | Settings that change between local, staging, and production
    |
    */

    'local' => [
        'allow_registration' => true,
        'allow_password_reset' => true,
        'debug_passwords' => true, // Show passwords in logs (NEVER in production!)
        'test_users_enabled' => true,
        'default_password' => 'password123',
    ],

    'staging' => [
        'allow_registration' => false,
        'allow_password_reset' => true,
        'debug_passwords' => false,
        'test_users_enabled' => true,
        'default_password' => 'StageTest123!',
        'sync_from_production' => true, // Allow production data sync
    ],

    'production' => [
        'allow_registration' => false,
        'allow_password_reset' => true,
        'debug_passwords' => false,
        'test_users_enabled' => false,
        'default_password' => null, // Never use default passwords
        'sync_from_production' => false, // Never sync in production
    ],

    /*
    |--------------------------------------------------------------------------
    | Test User Accounts
    |--------------------------------------------------------------------------
    */
    
    'test_accounts' => [
        'staging' => [
            'admin@staging.test' => 'StageAdmin123!',
            'inspector@staging.test' => 'StageInspect123!',
            'demo@staging.test' => 'DemoUser123!',
        ],
        'local' => [
            'admin@local.test' => 'admin',
            'inspector@local.test' => 'inspector',
            'test@local.test' => 'test',
        ],
    ],
];