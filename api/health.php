<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

http_response_code(200);
echo json_encode([
    'success' => true,
    'service' => 'AnimeWorld India API',
    'status' => 'ok',
    'version' => getenv('API_VERSION') ?: '1.0.0',
    'runtime' => 'vercel-php',
    'php_version' => PHP_VERSION,
    'timestamp' => gmdate('c')
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
