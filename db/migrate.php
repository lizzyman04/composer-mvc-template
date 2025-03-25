<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/../config/database.php';

use Illuminate\Database\Capsule\Manager as Capsule;

function createTable($name, $callback) {
    if (!Capsule::schema()->hasTable($name)) {
        Capsule::schema()->create($name, $callback);
        echo "Table '$name' created successfully.\n";
    } else {
        echo "Table '$name' already exists.\n";
    }
}

if (isset($argv[1]) && $argv[1] === '--reset') {
    echo "Dropping all tables...\n";
    Capsule::schema()->dropAllTables();
}

echo "Running migrations...\n";
createDatabaseTables();
echo "Migrations completed.\n";