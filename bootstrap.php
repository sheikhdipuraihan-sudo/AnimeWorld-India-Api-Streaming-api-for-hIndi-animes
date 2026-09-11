<?php
/**
 * Shared bootstrap for Vercel PHP functions.
 * This file lives outside the api/ function tree so it is not treated as an endpoint.
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('X-Content-Type-Options: nosniff');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    http_response_code(204);
    exit;
}

set_exception_handler(function (Throwable $exception): void {
    error_log($exception->getMessage());
    http_response_code(500);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error'
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
});
