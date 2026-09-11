<?php
/**
 * Shared bootstrap for Vercel PHP functions.
 * This file lives outside the api/ function tree so it is not treated as an endpoint.
 */

$requestMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowedOrigins = array_values(array_filter(array_map('trim', explode(',', getenv('ALLOWED_ORIGINS') ?: '*'))));

if (in_array('*', $allowedOrigins, true) || ($origin !== '' && in_array($origin, $allowedOrigins, true))) {
    header('Access-Control-Allow-Origin: ' . ($origin !== '' && !in_array('*', $allowedOrigins, true) ? $origin : '*'));
}

header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header('Access-Control-Max-Age: 86400');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

if ($requestMethod === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($requestMethod !== 'GET') {
    http_response_code(405);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['success' => false, 'error' => 'Method not allowed'], JSON_UNESCAPED_SLASHES);
    exit;
}

set_exception_handler(function (Throwable $exception): void {
    error_log(sprintf('[api] %s in %s:%d', $exception->getMessage(), $exception->getFile(), $exception->getLine()));
    http_response_code(500);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error'
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
});

set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }

    throw new ErrorException($message, 0, $severity, $file, $line);
});
