<?php

/**
 * ============================================
 * ENVIRONMENT CONFIGURATION
 * ============================================
 * Define paths, URLs, and reusable constants
 */

// ================================
// BASE PATH AND URL
// This configuration defines the base path of the project
// and the base URL for the application.
// It is used throughout the application to reference files and resources.
// ================================

define('BASE_PATH', dirname(__DIR__));
define(
    'BASE_URL',
    php_sapi_name() === 'cli' ? '' :
    (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/'
);

// ================================
// CSS MODULE CONFIG
// This configuration is used by the CSS module watcher.
// It defines the input and output directories for CSS files,
// as well as the watch interval in milliseconds.
// ================================
define('CSS_CONFIG', [
    'input_dir' => BASE_PATH . '/src/Views/styles',
    'output_dir' => BASE_PATH . '/public/assets/css',
    'watch_interval_ms' => 2000,
]);

// ================================
// ROUTER NOT FOUND CONTROLLER
// This controller is used when no route matches the request.
// It should handle 404 errors gracefully.
// ================================
define('ROUTER_NOT_FOUND_CONTROLLER', \Source\Controllers\HomeController::class);
define('ROUTER_NOT_FOUND_METHOD', 'notFound');
