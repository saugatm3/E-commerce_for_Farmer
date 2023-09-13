<?php
// Start a session
session_start();

// Check if the farmer is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page
    header("Location: ../index.php");
    exit();
}

// Include the database connection file
require 'conection.php';

// Get the farmer ID from the session
$farmer_id = $_SESSION['id'];

// Define the target directory for uploading the crop image
$targetDirectory = "crop_image/";
$targetFile = $targetDirectory . basename($_FILES['cropImage']['name']);
$uploadOk = true;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if the form is submitted and the crop image is uploaded successfully
if (isset($_POST['cropName']) && isset($_FILES['cropImage']) && $_FILES['cropImage']['error'] === 0) {
    // Check if the uploaded file is an image
    $check = getimagesize($_FILES['cropImage']['tmp_name']);
    if ($check === false) {
        echo "Error: Invalid image file.";
        $uploadOk = false;
    }

    // Check if the target file already exists
    if (file_exists($targetFile)) {
        echo "Error: File already exists.";
        $uploadOk = false;
    }

    // Check the file size
    if ($_FILES['cropImage']['size'] > 5000000000) {
        echo "Error: File size is too large.";
        $uploadOk = false;
    }

    // Check the file format
    if ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png" && $imageFileType !== "gif") {
        echo "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = false;
    }

    // If all checks pass, move the uploaded file to the target directory
    if ($uploadOk) {
        if (move_uploaded_file($_FILES['cropImage']['tmp_name'], $targetFile)) {
            // Get the form data
            $cropName = $_POST['cropName'];
            $cropType = $_POST['cropType'];
            $pricePerKg = $_POST['pricePerKg'];
            $availableQuantity = $_POST['availableQuantity'];
            $cropDescription = $_POST['cropDescription'];

            // Prepare and execute the SQL query to insert crop details into the database
            $sql = "INSERT INTO crop_details (farmer_id, crop_name, crop_image, crop_type, price_per_kg, available_quantity, crop_description) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssdss", $farmer_id, $cropName, $targetFile, $cropType, $pricePerKg, $availableQuantity, $cropDescription);
            if ($stmt->execute()) {
                // Redirect to the farmer dashboard page after successful upload
                header("Location: farmer_dashboard.php");
                exit();
            } else {
                echo "Error: Failed to insert crop details into the database.";
            }
            $stmt->close();
        } else {
            echo "Error: Failed to upload the crop image.";
        }
    }
}

// Close the database connection
$conn->close();
?>
