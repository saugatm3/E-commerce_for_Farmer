<?php
// Include the database connection file
require 'conection.php';

// Retrieve form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];
$contact_number = $_POST['contact_number'];
$email_id = $_POST['email_id'];
$district = $_POST['district'];
$pin = $_POST['pin'];
$area_name = $_POST['area_name'];

// File upload handling
$target_dir = "customer_dp/";
$target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if the file is an actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["profile_image"]["size"] > 5000000000000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
$allowedFormats = array("jpg", "jpeg", "png", "gif");
if (!in_array($imageFileType, $allowedFormats)) {
    echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    // Move the uploaded file to the destination folder
    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["profile_image"]["name"]) . " has been uploaded.";

        // Prepare and execute the SQL query to insert customer data

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO customer_details (first_name, last_name, password, contact_number, email_id, district, pin, area_name, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $first_name, $last_name, $hashedPassword, $contact_number, $email_id, $district, $pin, $area_name, $target_file);

        if ($stmt->execute()) {
            echo "Customer sign up successful!";
            header("Location: ../index.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Close the database connection
$conn->close();
?>
