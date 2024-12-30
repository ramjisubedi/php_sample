<?php 
// Function to clean input data
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to check role
function checkPermission($allowed_roles) {
    // If user is not logged in or does not have the right role
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
        // Redirect or show error if role is not allowed
        header("Location: access_denied.php");
        exit();
    }
}
?>