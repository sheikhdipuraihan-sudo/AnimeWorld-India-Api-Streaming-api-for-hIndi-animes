<?php
require_once __DIR__ . '/../bootstrap.php';
header('Content-Type: application/json; charset=UTF-8');

echo json_encode([
    'success' => true,
    'service' => 'AnimeWorld India API',
    'status' => 'ok',
    'runtime' => 'vercel-php'
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
