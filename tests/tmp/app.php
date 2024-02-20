<?php

return [
    'name' => 'MyTestApp',
    'url' => 'http://localhost',
    'locale' => 'en',
    'debug' => true,
    'database' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'test_db',
        'username' => 'test_user',
        'password' => 'test_pass',
    ],
    'mail' => [
        'transport' => 'smtp',
        'host' => 'smtp.test.com',
        'port' => 587,
        'encryption' => 'tls',
        'username' => 'mailuser',
        'password' => 'mailpass',
    ],
    'api' => [
        'key' => 'api_key_123456',
        'endpoint' => 'https://api.test.com/v1',
    ],
    'features' => [
        'feature1' => true,
        'feature2' => false,
        'feature3' => true,
    ],
    'logging' => [
        'level' => 'debug',
        'path' => '/var/log/myapp.log',
    ],
    'session' => [
        'driver' => 'file',
        'lifetime' => 120,
        'files' => '/tmp/sessions',
    ],
    'cache' => [
        'driver' => 'file',
        'path' => '/tmp/cache',
    ],
];
