<?php

Env::init();

$bootloader = \TinyPixel\Config\Bootloader::getInstance();

$bootloader->init(dirname(__DIR__));

$bootloader->loadEnv([
    'DB_HOST',
    'DB_NAME',
    'DB_PASSWORD',
    'DB_USER',
    'REDIS_HOST',
    'REDIS_PASSWORD',
    'S3_UPLOADS_BUCKET',
    'S3_UPLOADS_ENDPOINT',
    'S3_UPLOADS_KEY',
    'S3_UPLOADS_SECRET',
    'WP_ENV',
    'WP_HOME',
    'WP_SITEURL',
]);

$bootloader->defineFS([
    'CONTENT_DIR' => 'app',
    'WP_ENV'      => env('WP_ENV'),
    'WP_HOME'     => env('WP_HOME'),
    'WP_SITEURL'  => env('WP_SITEURL'),
]);

if (env('SENTRY_DSN') && !$bootloader::get('WP_ENV')==='DEVELOPMENT') {
    Sentry\init([
        'dsn'         => env('SENTRY_DSN'),
        'environment' => env('WP_ENV'),
        'error_types' => E_ALL & ~E_NOTICE & ~E_DEPRECATED,
    ]);
}

$bootloader->defineEnvironments([
    'development' => env('ENV_DEV'),
    'staging'     => env('ENV_STAGING'),
    'production'  => env('ENV_PRODUCTION'),
]);

$bootloader->defineDB([
    'DB_NAME'      => env('DB_NAME'),
    'DB_USER'      => env('DB_USER'),
    'DB_PASSWORD'  => env('DB_PASSWORD'),
    'DB_HOST'      => env('DB_HOST'),
    'DB_CHARSET'   => env('DB_CHARSET')   ?: 'utf8',
    'DB_COLLATION' => env('DB_COLLATION') ?: 'utf8_unicode_ci',
    'DB_PREFIX'    => env('DB_PREFIX')    ?: 'wp_',
]);

$table_prefix = $bootloader::get('DB_PREFIX');

$bootloader->defineS3([
    'S3_UPLOADS_BUCKET'     => env('S3_UPLOADS_BUCKET'),
    'S3_UPLOADS_ENDPOINT'   => env('S3_UPLOADS_ENDPOINT') ?: 'https://nyc3.digitaloceanspaces.com',
    'S3_UPLOADS_REGION'     => env('S3_UPLOADS_REGION')   ?: 'nyc3',
    'S3_UPLOADS_KEY'        => env('S3_UPLOADS_KEY'),
    'S3_UPLOADS_SECRET'     => env('S3_UPLOADS_SECRET'),
]);

$bootloader->defineRedis([
    'REDIS_HOST'          => env('REDIS_HOST') ?: env('DB_NAME'),
    'REDIS_AUTH'          => env('REDIS_AUTH'),
    'REDIS_PORT'          => env('REDIS_PORT') ?: 25061,
    'PREDIS_CERT'         => "{$bootloader->bedrockDir}/config/cert/redis-ca-cert.crt",
    'PREDIS_VERIFY_PEERS' => true,
]);

$bootloader->configureRedis([
    'REDIS_OBJECT_CACHE'        => env('REDIS_OBJECT_CACHE')     ?: true,
    'WP_REDIS_USE_CACHE_GROUPS' => env('REDIS_USE_CACHE_GROUPS') ?: false,
    'WP_CACHE_KEY_SALT'         => env('REDIS_CACHE_KEY_SALT')   ?: $bootloader::get('DB_NAME'),
]);

$bootloader->defineSalts([
    'AUTH_KEY'         => env('AUTH_KEY'),
    'AUTH_SALT'        => env('AUTH_SALT'),
    'LOGGED_IN_KEY'    => env('LOGGED_IN_KEY'),
    'LOGGED_IN_SALT'   => env('LOGGED_IN_SALT'),
    'NONCE_KEY'        => env('NONCE_KEY'),
    'NONCE_SALT'       => env('NONCE_SALT'),
    'SECURE_AUTH_KEY'  => env('SECURE_AUTH_KEY'),
    'SECURE_AUTH_SALT' => env('SECURE_AUTH_SALT'),
]);

$bootloader->exposeSSL();
$bootloader->boot();
