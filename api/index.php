<?php

/**
 * Entry point for Vercel Serverless Function deployment.
 * Prepares necessary writable temporary directories in /tmp for Laravel
 * and forwards the request to the public index.php.
 */

$storageDirs = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/testing',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/storage/bootstrap',
    '/tmp/storage/bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Ensure Laravel caches and compiled views point to /tmp
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('APP_CONFIG_CACHE=/tmp/storage/bootstrap/cache/config.php');
putenv('APP_EVENTS_CACHE=/tmp/storage/bootstrap/cache/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/storage/bootstrap/cache/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/storage/bootstrap/cache/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/storage/bootstrap/cache/services.php');

// Serve static files from /public directly if routed to the PHP function
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$cleanUri = ltrim((string) preg_replace('#^/public/#', '/', $uri), '/');
$publicRoot = realpath(__DIR__.'/../public');
$publicFile = ($publicRoot && $cleanUri !== '') ? realpath($publicRoot.DIRECTORY_SEPARATOR.$cleanUri) : false;

if (
    $publicFile &&
    $publicRoot &&
    str_starts_with($publicFile, $publicRoot.DIRECTORY_SEPARATOR) &&
    is_file($publicFile) &&
    strtolower(pathinfo($publicFile, PATHINFO_EXTENSION)) !== 'php'
) {
    $ext = strtolower(pathinfo($publicFile, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css' => 'text/css; charset=UTF-8',
        'js' => 'application/javascript; charset=UTF-8',
        'mjs' => 'application/javascript; charset=UTF-8',
        'json' => 'application/json; charset=UTF-8',
        'map' => 'application/json; charset=UTF-8',
        'ico' => 'image/x-icon',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'txt' => 'text/plain; charset=UTF-8',
    ];

    header('Content-Type: '.($mimeTypes[$ext] ?? 'application/octet-stream'));
    header('Cache-Control: public, max-age=86400');
    readfile($publicFile);
    exit;
}

// Forward request to public index.php
require __DIR__.'/../public/index.php';
