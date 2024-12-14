<?php
// config/cors.php

return [
    'supports_credentials' => true,
    'allowed_origins' => ['https://tgi-projeto-front-end-git-main-devdamatas-projects-6bfc92be.vercel.app'], // URL do seu front-end
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
];
