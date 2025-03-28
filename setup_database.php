<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use App\Database;

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Read SQL file
    $sql = file_get_contents('database_schema.sql');
    
    // Split into individual queries
    $queries = explode(';', $sql);
    
    // Execute each query
    foreach ($queries as $query) {
        if (trim($query) !== '') {
            $conn->exec($query);
        }
    }

    echo "Database tables created successfully!";
} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage());
}