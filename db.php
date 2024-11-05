<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Default username for PHPMyAdmin, change if different
$password = ""; // Default password for PHPMyAdmin, change if different
$dbname = "donate_food"; // Database name, should match the name you created

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
