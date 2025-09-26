<?php

return [
    'endpoint' => env('DIFY_ENDPOINT'),
    'api_key' => env('DIFY_API_KEY'),
    'timeout' => (int) env('DIFY_TIMEOUT', 8),
];
