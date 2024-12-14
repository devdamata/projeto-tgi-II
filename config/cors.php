<?php
// config/cors.php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'with_credentials' => true,
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Substitua pelo domínio do front-end
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Habilitar credenciais (cookies, etc.)
    'cookie_attributes' => '; Partitioned'
];
