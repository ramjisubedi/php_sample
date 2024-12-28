<?php
// Start the session to track login state
session_start();

// If the user is already logged in, redirect them to the homepage or the requested page
if (isset($_SESSION['user_id'])) {
    // If there's a redirect URL stored, send them back to that page after login
    if (isset($_SESSION['redirect_url'])) {
        $redirect_url = $_SESSION['redirect_url'];
        unset($_SESSION['redirect_url']);  // Remove redirect URL after use
        header("Location: $redirect_url");
    } else {
        // Redirect to the homepage if no redirect URL is set
        header("Location: home.php");
    }
    exit();
}

// Simulate a simple login process (replace with actual validation)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Here you'd typically validate the username and password against a database
    if ($username == 'valid_user' && $password == 'valid_password') {
        // Set session variable on successful login
        $_SESSION['user_id'] = $username;

        // Check if there's a redirect URL stored (user tried to access a protected page)
        if (isset($_SESSION['redirect_url'])) {
            // Redirect to the page the user originally requested
            $redirect_url = $_SESSION['redirect_url'];
            unset($_SESSION['redirect_url']);  // Remove redirect URL after use
            header("Location: $redirect_url");
        } else {
            // Redirect to the homepage if no specific URL is stored
            header("Location: home.php");
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
</body>
</html>