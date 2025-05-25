<?php

/**
 * ============================================
 * DATABASE MIGRATION FILE
 * ============================================
 *
 * This file is responsible for defining the database structure.
 * 
 * To create a new table, use:
 * createTable('table_name', function (Blueprint $table) {
 *     $table->id();
 *     $table->string('column_name');
 *     $table->timestamps();
 * });
 * See more explanations about other columns and parameters below.
 */


use Illuminate\Database\Schema\Blueprint;

function createDatabaseTables()
{
    createTable('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    });

    createTable('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->foreignId('user_id')->constrained('users');
        $table->timestamps();
    });
}

/**
* Inside the function you can add the following columns to your table:
*
* Basic column types:
*     $table->id(); // Creates an auto-incrementing primary key column named 'id'.
*     $table->string('column_name'); // Creates a column for storing strings (e.g., text or short strings).
*     $table->timestamps(); // Adds 'created_at' and 'updated_at' columns to automatically track record creation and modification times.
* 
* Additional column types and constraints:
* 
*     $table->integer('column_name'); // Creates a column for storing integer values.
*     $table->text('column_name'); // Creates a column for storing large amounts of text.
*     $table->boolean('column_name'); // Creates a column for storing boolean values (true/false).
*     $table->float('column_name', 8, 2); // Creates a column for storing floating-point numbers (e.g., 8 digits in total with 2 after the decimal).
*     $table->date('column_name'); // Creates a column for storing date values.
*     $table->dateTime('column_name'); // Creates a column for storing date and time values.
* 
* Column constraints:
* 
*     $table->unique('column_name'); // Ensures that the values in this column are unique across all records.
*     $table->primary('column_name'); // Sets the specified column(s) as the primary key for the table.
*     $table->foreign('column_name')->references('id')->on('other_table'); // Creates a foreign key constraint, linking to the 'id' column in another table.
*     $table->nullable(); // Allows the column to have NULL values.
*     $table->default('value'); // Sets a default value for the column if no value is provided during insertion.
*
* For more details on adding columns and setting up constraints, read: https://laravel.com/docs/5.0/schema#adding-columns

 */

/**
 * ============================================
 * SEEDERS (Insert default data after migration)
 * ============================================
 */
function insertDefaultData()
{
    $now = date('Y-m-d H:i:s');

    // Insert a default administrator user
    $userId = insertDataReturningId('users', [
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => password_hash('password', PASSWORD_DEFAULT),
        'created_at' => $now,
        'updated_at' => $now,
    ]);

    // Insert initial post
    insertData('posts', [
        'title' => 'Welcome Post',
        'content' => 'This is your first post!',
        'user_id' => $userId,
        'created_at' => $now,
        'updated_at' => $now,
    ]);
}
