<?php
// config/cors.php

return [
    'supports_credentials' => true,
    'allowed_origins' => ['http://localhost:3000'], // URL do seu front-end
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
];
