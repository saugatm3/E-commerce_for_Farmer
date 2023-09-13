<!DOCTYPE html>
<html>
<head>
    <title>Farmer Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .farmer-orders-table {
            max-width: 800px;
            margin: 5% auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="farmer-orders-table">
            <h2>Farmer Orders</h2>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Crop Name</th>
                        <th>Crop ID</th>
                        <th>Crop Type</th>
                        <th>Order Quantity</th>
                        <th>Total Price</th>
                        <th>Delivered Date</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the database connection file
                    require 'conection.php';
                    session_start();

                    // Get the farmer ID from the session (assuming it is stored in $_SESSION['farmer_id'])
                    $farmerId = $_SESSION['id'];
                    // $orderId = $_SESSION['order_id'];

                    // Fetch the farmer orders from the database
                    $sql = "SELECT c.customer_id, CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
                            cr.crop_name, cr.crop_id, cr.crop_type, o.total_order_amount, o.total_price, 
                            o.delivered_date, o.order_status ,o.order_id
                            FROM customer_orders o 
                            INNER JOIN customer_details c ON o.customer_id = c.customer_id 
                            INNER JOIN crop_details cr ON o.crop_id = cr.crop_id 
                            WHERE o.farmer_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $farmerId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are any orders
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $customerId = $row['customer_id'];
                            $orderId = $row['order_id'];
                            $customerName = $row['customer_name'];
                            $cropName = $row['crop_name'];
                            $cropId = $row['crop_id'];
                            $cropType = $row['crop_type'];
                            $orderQuantity = $row['total_order_amount'];
                            $totalPrice = $row['total_price'];
                            $deliveredDate = $row['delivered_date'];
                            $orderStatus = $row['order_status'];
                            ?>
                            <tr>
                                <td><?php echo $customerId; ?></td>
                                <td><?php echo $customerName; ?></td>
                                <td><?php echo $cropName; ?></td>
                                <td><?php echo $cropId; ?></td>
                                <td><?php echo $cropType; ?></td>
                                <td><?php echo $orderQuantity; ?></td>
                                <td><?php echo $totalPrice; ?></td>
                                <td><?php echo $deliveredDate; ?></td>
                                <td>
    <form action="update_order_status.php" method="post">
        <input type="hidden" name="orderId" value="<?php echo $orderId; ?>">
        <select name="orderStatus" onchange="this.form.submit()">
            <option value="Pending" <?php if ($orderStatus == 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Confirmed" <?php if ($orderStatus == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
        </select>
    </form>
</td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="9">No orders found.</td></tr>';
                    }

                    // Close the prepared statement and database connection
                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
