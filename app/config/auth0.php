<?php

declare(strict_types=1);

use Auth0\Laravel\Configuration;
use Auth0\SDK\Configuration\SdkConfiguration;

return Configuration::VERSION_2 + [
    'registerGuards' => false,
    'registerMiddleware' => false,
    'registerAuthenticationRoutes' => false,
    'configurationPath' => null,

    'guards' => [
        'default' => [
            Configuration::CONFIG_STRATEGY => Configuration::get(Configuration::CONFIG_STRATEGY, SdkConfiguration::STRATEGY_NONE),
            // Configuration::CONFIG_DOMAIN => Configuration::get(Configuration::CONFIG_DOMAIN),
            Configuration::CONFIG_CUSTOM_DOMAIN => Configuration::get(Configuration::CONFIG_CUSTOM_DOMAIN),
            Configuration::CONFIG_CLIENT_ID => Configuration::get(Configuration::CONFIG_CLIENT_ID),
            Configuration::CONFIG_CLIENT_SECRET => Configuration::get(Configuration::CONFIG_CLIENT_SECRET),
            Configuration::CONFIG_AUDIENCE => Configuration::get(Configuration::CONFIG_AUDIENCE),
            Configuration::CONFIG_ORGANIZATION => Configuration::get(Configuration::CONFIG_ORGANIZATION),
            Configuration::CONFIG_USE_PKCE => Configuration::get(Configuration::CONFIG_USE_PKCE),
            Configuration::CONFIG_SCOPE => Configuration::get(Configuration::CONFIG_SCOPE),
            Configuration::CONFIG_RESPONSE_MODE => Configuration::get(Configuration::CONFIG_RESPONSE_MODE),
            Configuration::CONFIG_RESPONSE_TYPE => Configuration::get(Configuration::CONFIG_RESPONSE_TYPE),
            Configuration::CONFIG_TOKEN_ALGORITHM => Configuration::get(Configuration::CONFIG_TOKEN_ALGORITHM),
            Configuration::CONFIG_TOKEN_JWKS_URI => Configuration::get(Configuration::CONFIG_TOKEN_JWKS_URI),
            Configuration::CONFIG_TOKEN_MAX_AGE => Configuration::get(Configuration::CONFIG_TOKEN_MAX_AGE),
            Configuration::CONFIG_TOKEN_LEEWAY => Configuration::get(Configuration::CONFIG_TOKEN_LEEWAY),
            Configuration::CONFIG_TOKEN_CACHE => Configuration::get(Configuration::CONFIG_TOKEN_CACHE),
            Configuration::CONFIG_TOKEN_CACHE_TTL => Configuration::get(Configuration::CONFIG_TOKEN_CACHE_TTL),
            Configuration::CONFIG_HTTP_MAX_RETRIES => Configuration::get(Configuration::CONFIG_HTTP_MAX_RETRIES),
            Configuration::CONFIG_HTTP_TELEMETRY => Configuration::get(Configuration::CONFIG_HTTP_TELEMETRY),

            Configuration::CONFIG_DOMAIN => env('AUTH0_ADMIN_DOMAIN'),
            Configuration::CONFIG_MANAGEMENT_TOKEN => env('AUTH0_MANAGEMENT_API_TOKEN'),
            // Configuration::CONFIG_MANAGEMENT_TOKEN => Configuration::get(Configuration::CONFIG_MANAGEMENT_TOKEN),

            Configuration::CONFIG_MANAGEMENT_TOKEN_CACHE => Configuration::get(Configuration::CONFIG_MANAGEMENT_TOKEN_CACHE),
            Configuration::CONFIG_CLIENT_ASSERTION_SIGNING_KEY => Configuration::get(Configuration::CONFIG_CLIENT_ASSERTION_SIGNING_KEY),
            Configuration::CONFIG_CLIENT_ASSERTION_SIGNING_ALGORITHM => Configuration::get(Configuration::CONFIG_CLIENT_ASSERTION_SIGNING_ALGORITHM),
            Configuration::CONFIG_PUSHED_AUTHORIZATION_REQUEST => Configuration::get(Configuration::CONFIG_PUSHED_AUTHORIZATION_REQUEST),
        ],

        'api-admin' => [
            Configuration::CONFIG_STRATEGY => SdkConfiguration::STRATEGY_API,
            Configuration::CONFIG_DOMAIN => env('AUTH0_ADMIN_DOMAIN'),
            Configuration::CONFIG_CLIENT_ID => env('AUTH0_ADMIN_CLIENT_ID'),
            Configuration::CONFIG_CLIENT_SECRET => env('AUTH0_ADMIN_CLIENT_SECRET'),
            Configuration::CONFIG_AUDIENCE => [env('AUTH0_ADMIN_AUDIENCE')],
            Configuration::CONFIG_MANAGEMENT_TOKEN => env('AUTH0_MANAGEMENT_API_TOKEN'),
        ],

        'api-public' => [
            Configuration::CONFIG_STRATEGY => SdkConfiguration::STRATEGY_API,
            Configuration::CONFIG_DOMAIN => env('AUTH0_PUBLIC_DOMAIN'),
            Configuration::CONFIG_CLIENT_ID => env('AUTH0_PUBLIC_CLIENT_ID'),
            Configuration::CONFIG_CLIENT_SECRET => env('AUTH0_PUBLIC_CLIENT_SECRET'),
            Configuration::CONFIG_AUDIENCE => [env('AUTH0_PUBLIC_AUDIENCE')],
            Configuration::CONFIG_MANAGEMENT_TOKEN => env('AUTH0_MANAGEMENT_API_TOKEN'),
        ],
    ],
];
