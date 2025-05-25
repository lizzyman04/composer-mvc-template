<?php

/**
 * CSS Watcher Starter
 * Can be started with: composer watch
 */

use Core\Css\Watcher;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/env.php';

if (!defined('CSS_CONFIG')) {
    echo "❌ CSS_CONFIG not defined.\n";
    exit(1);
}

$config = CSS_CONFIG;

if (!is_dir($config['input_dir'])) {
    echo "❌ Input directory '{$config['input_dir']}' not found.\n";
    exit(1);
}

if (!is_dir($config['output_dir'])) {
    mkdir($config['output_dir'], 0777, true);
    echo "📁 Output directory created at '{$config['output_dir']}'\n";
}

echo "🛠️  Starting CSS Module Watcher...\n";
$watcher = new Watcher(
    $config['input_dir'],
    $config['output_dir'],
    $config['watch_interval_ms']
);

$watcher->start();
