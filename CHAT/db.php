<?php

// Database connection
// Use Railway MySQL env vars first, fallback to Docker/local
$servername = getenv('MYSQLHOST') ?: "db";
$username = getenv('MYSQLUSER') ?: "appointmate_user";
$password = getenv('MYSQLPASSWORD') ?: "appointmate_password";
$dbname = getenv('MYSQLDATABASE') ?: "appointmate";

$conn = new mysqli($servername, $username, $password, $dbname);
// Use Railway MySQL env vars first, fallback to Docker/local
$servername = getenv('MYSQLHOST') ?: getenv('DATABASE_HOST') ?: "db";
$username = getenv('MYSQL_USER') ?: getenv('DATABASE_USER') ?: "appointmate_user";
$password = getenv('MYSQLPASSWORD') ?: getenv('DATABASE_PASSWORD') ?: "appointmate_password";
$dbname = getenv('MYSQL_DATABASE') ?: getenv('DATABASE_NAME') ?: "appointmate";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>