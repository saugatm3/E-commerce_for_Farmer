<?php
// Include the database connection file
require 'conection.php';
session_start();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $cropId = $_POST['cropId'];
    $quantity = $_POST['quantity'];

    // Fetch the crop details from the database
    $sql = "SELECT * FROM crop_details WHERE crop_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cropId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the crop exists
    if ($result->num_rows == 1) {
        $crop = $result->fetch_assoc();
        $farmerId = $crop['farmer_id'];
        $pricePerKg = $crop['price_per_kg'];

        // Calculate total order amount and total price
        $totalOrderAmount = $quantity;
        $totalPrice = $quantity * $pricePerKg;

        // Get the current date
        $orderDate = date('Y-m-d');
        $deliveryDate = $orderDate; // Set delivery date same as order date

        // Get the customer ID from the session (assuming it is stored in $_SESSION['customer_id'])
        $customerId = $_SESSION['customer_id'];

        // Set the order status as 'Pending'
        $orderStatus = 'Pending';

        // Insert the order details into the customer_orders table
        $sql = "INSERT INTO customer_orders (crop_id, farmer_id, customer_id, order_date, order_status, price_per_kg, total_order_amount, total_price, delivered_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiissddss", $cropId, $farmerId, $customerId, $orderDate, $orderStatus, $pricePerKg, $totalOrderAmount, $totalPrice, $deliveryDate);
        if ($stmt->execute()) {
            // Update the available quantity in the crop_detail table
            $newQuantity = $crop['available_quantity'] - $quantity;
            $sql = "UPDATE crop_details SET available_quantity = ? WHERE crop_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $newQuantity, $cropId);
            $stmt->execute();

            echo "Order confirmed successfully.";
            header("Location: consumer.php");
        } else {
            echo "Error: Failed to confirm the order.";
        }
    } else {
        echo "Error: Crop not found.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
