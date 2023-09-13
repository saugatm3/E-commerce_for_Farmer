<?php
// Start a session
session_start();

// Include the database connection file
require 'conection.php';

// Retrieve form data
$email_id = $_POST['email_id'];
$password = $_POST['password'];

// Prepare and execute the SQL query to fetch the customer's data
$sql = "SELECT * FROM customer_details WHERE email_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if a matching record is found
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    
    // Verify the password
    if (password_verify($password, $row['password'])) {
        // Store customer's data in session variables
        $_SESSION['customer_id'] = $row['customer_id'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        // Add other required data to be stored in session
        
        // Redirect to the customer dashboard or any other desired page
        header("Location: ./for_customer/consumer.php");
        exit();
    } else {
        // Invalid password
        echo "Invalid password.";
    }
} else {
    // No matching record found
    echo "Invalid email ID.";
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
