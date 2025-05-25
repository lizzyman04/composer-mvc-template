<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/../config/database.php';

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Create a table if it does not exist.
 */
function createTable($name, $callback)
{
    if (!Capsule::schema()->hasTable($name)) {
        Capsule::schema()->create($name, $callback);
        echo "Table '$name' created successfully.\n";
    } else {
        echo "Table '$name' already exists.\n";
    }
}

/**
 * Insert data into a table.
 */
function insertData($table, array $data)
{
    Capsule::table($table)->insert($data);
    echo "Inserted data into '$table'.\n";
}

/**
 * Insert data and return the ID of the inserted row.
 */
function insertDataReturningId($table, array $data)
{
    $id = Capsule::table($table)->insertGetId($data);
    echo "Inserted data into '$table' with ID $id.\n";
    return $id;
}

// Parse command-line options
$options = $argv;
array_shift($options); // remove script name

$reset = in_array('--reset', $options);
$seed = in_array('--seed', $options);

// Optional: Reset tables
if ($reset) {
    echo "Dropping all tables...\n";
    Capsule::schema()->dropAllTables();
    echo "All tables dropped.\n";
}

// Run migrations
echo "Running migrations...\n";
createDatabaseTables();

// Run seeder
if ($seed) {
    echo "Seeding data...\n";
    insertDefaultData();
    echo "Data seeded.\n";
}

echo "Migrations completed.\n";
