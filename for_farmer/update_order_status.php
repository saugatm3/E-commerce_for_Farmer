<?php
// Include the database connection file
require 'conection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the order ID and updated order status from the form data
    $orderId = $_POST['orderId'];
    $orderStatus = $_POST['orderStatus'];
    echo $orderId;

    // Update the order status in the customer_orders table
    $sql = "UPDATE customer_orders SET order_status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $orderStatus, $orderId);
    if ($stmt->execute()) {
        echo "Order status updated successfully.";
        // header("Location:my_orders.php");
    } else {
        echo "Error: Failed to update the order status.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
