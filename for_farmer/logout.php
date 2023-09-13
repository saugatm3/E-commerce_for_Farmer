<?php
// At the beginning of the PHP file
session_start();

// ...

// When the "Logout" button is clicked
session_destroy(); // Destroy the session
header("Location: ../index.php"); // Redirect to the index page
exit();

?>