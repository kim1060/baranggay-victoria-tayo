<?php
// Temporary script to import database to Railway
$host = 'crossover.proxy.rlwy.net';
$port = 12935;
$username = 'root';
$password = 'iJpsNCkSJhYMVKxNuNBbrKVGKRLbXGEc';
$database = 'railway';

// Read SQL file
$sql = file_get_contents('database/appointmate.sql');

// Connect to database
$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Execute SQL file
if ($conn->multi_query($sql)) {
    echo "Database imported successfully!";
    // Clear results
    while ($conn->next_result()) {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    }
} else {
    echo "Error importing database: " . $conn->error;
}

$conn->close();
?>
