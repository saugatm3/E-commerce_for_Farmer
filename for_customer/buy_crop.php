<!DOCTYPE html>
<html>
<head>
    <title>Buy Crop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .buy-crop-form {
            max-width: 500px;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="buy-crop-form">
            <?php
            // Include the database connection file
            require 'conection.php';

            // Check if the crop ID is passed
            if (isset($_GET['crop_id'])) {
                $cropId = $_GET['crop_id'];

                // Fetch the crop details from the database
                $sql = "SELECT * FROM crop_details WHERE crop_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $cropId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if the crop exists
                if ($result->num_rows == 1) {
                    $crop = $result->fetch_assoc();
                    $cropName = $crop['crop_name'];
                    $availableQuantity = $crop['available_quantity'];
                    $pricePerKg = $crop['price_per_kg'];
            ?>
                    <h2>Buy Crop: <?php echo $cropName; ?></h2>
                    <form action="confirm_order.php" method="post">
                        <input type="hidden" name="cropId" value="<?php echo $cropId; ?>">
                        <div class="form-group">
                            <label for="quantity">Quantity (in kg):</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="<?php echo $availableQuantity; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Confirm Order</button>
                    </form>
            <?php
                } else {
                    echo '<p>Crop not found.</p>';
                }

                // Close the prepared statement
                $stmt->close();
            } else {
                echo '<p>Invalid crop ID.</p>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
