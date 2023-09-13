<?php
$host = 'localhost'; // Replace with your MySQL host
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$database = 'provothon'; // Replace with your MySQL database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Connection successful
echo 'Connected to the database successfully!';
?>
