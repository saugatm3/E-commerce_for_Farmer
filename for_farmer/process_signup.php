<?php
// Include the database connection file
require 'conection.php';

// Retrieve form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$contact_number = $_POST['contact_number'];
$district = $_POST['district'];
$pin = $_POST['pin'];
$area_name = $_POST['area_name'];
$email_id = $_POST['email_id'];

// Validate passwords match
if ($password !== $confirm_password) {
    echo "Error: Passwords do not match.";
    exit;
}
// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare and execute the SQL query to insert farmer data
$sql = "INSERT INTO farmers (first_name, last_name, password, contact_number, district, pin, area_name, email_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $first_name, $last_name, $hashedPassword, $contact_number, $district, $pin, $area_name, $email_id);

if ($stmt->execute()) {
    echo "Farmer sign up successful!";
    header("Location: ../index.php");
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
