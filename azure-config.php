<?php
// Azure Database Configuration
// Gets credentials from Azure Environment Variables

// Get environment variables from Azure App Service
$host = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$database = getenv('DB_NAME');
$port = 3306;

// Debug: Uncomment to check if variables are loaded
// echo "Host: " . $host . "<br>";
// echo "User: " . $username . "<br>";
// echo "Database: " . $database . "<br>";

// Create MySQL connection
$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    // More detailed error for debugging
    $error_msg = "Connection failed: " . $conn->connect_error . 
                 " [Host: $host, User: $username, DB: $database]";
    error_log($error_msg);
    die("Database connection error. Please try again later.");
}

// Set charset to UTF-8
if (!$conn->set_charset("utf8mb4")) {
    error_log("Error loading character set utf8mb4: " . $conn->error);
}

// Enable error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('America/Costa_Rica');

// Return the connection
// Note: Don't close connection here - let individual files manage it
?>