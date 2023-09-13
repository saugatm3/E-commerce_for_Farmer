<?php
// Start a session
session_start();

// Check if the farmer is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page
    // header("Location:../index.php");
    // exit();
    echo "error";
}

// Include the database connection file
require 'conection.php';

// Fetch the farmer details from the database using session variable
$farmer_id = $_SESSION['id'];

// Prepare and execute the SQL query to fetch the farmer's details
$sql = "SELECT * FROM farmers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the farmer's details
if ($result->num_rows == 1) {
    $farmer = $result->fetch_assoc();
    $farmer_name = $farmer['first_name'] . ' ' . $farmer['last_name'];
    $contact = $farmer['contact_number'];
    $email = $farmer['email_id'];
    $district = $farmer['district'];
    $pin = $farmer['pin'];
    $area = $farmer['area_name'];
}

// Count the orders of the farmer
$sql = "SELECT COUNT(*) AS total_orders FROM customer_orders WHERE farmer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the total orders count
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $total_orders = $row['total_orders'];
} else {
    $total_orders = 0;
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .dashboard-container {
            max-width: 800px;
            margin: 5% auto; /* Updated margin top and centered horizontally */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .profile-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: none;
        }
        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="dashboard-container">
            <h2>Farmer Dashboard</h2>
            <img src="../rough/Photo_navbar.jpeg" class="profile-image" alt="Profile Image">
            <div class="row">
                <div class="col-md-6">
                    <h4>Name: <?php echo $farmer_name; ?></h4>
                    <p>Contact: <?php echo $contact; ?></p>
                    <p>district: <?php echo $district; ?></p>
                    <p>pin: <?php echo $pin; ?></p>
                    <p>area: <?php echo $area; ?></p>
                    <p>Email: <?php echo $email; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="upload_crop.php" class="btn btn-primary">Upload Crop</a>
                </div>
                <div class="col-md-6">
                    <a href="my_orders.php" class="btn btn-primary">My Orders</a>
                </div>
            </div>
            
            
            <!-- Additional buttons -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
                <div class="col-md-6">
                    <a href="all_orders.php" class="btn btn-primary">All Orders</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Statistics</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="orderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
    <script>
        // Generate the chart
        // var totalOrders = <?php //echo $total_orders; ?>;
        // var pendingOrders = Math.floor(Math.random() * totalOrders);
        // var completedOrders = totalOrders - pendingOrders;

        var totalOrders = 14;
        var pendingOrders = 10;
        var completedOrders = totalOrders - pendingOrders;

        // Create the chart
        var ctx = document.getElementById('orderChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Orders', 'Pending Orders', 'Completed Orders'],
                datasets: [{
                    data: [totalOrders, pendingOrders, completedOrders],
                    backgroundColor: ['#007bff', '#ffc107', '#28a745'],
                }]
            },
            options: {
                legend: { display: false },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 10
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
