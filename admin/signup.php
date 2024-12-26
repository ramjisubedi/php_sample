
<?php
// Check if we are in development or production environment
$environment = 'development'; // Change this value based on your environment

if ($environment === 'production') {
    // Disable error reporting in production
    error_reporting(0);               // No errors
    ini_set('display_errors', 0);      // Do not display errors
    ini_set('log_errors', 1);          // Enable error logging
    ini_set('error_log', 'error_log.log');  // Log errors to a file
} else {
    // Enable all errors in development
    error_reporting(E_ALL);            // All errors, warnings, and notices
    ini_set('display_errors', 1);      // Display errors in the browser
}


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

include('../helper/index.php');
// Initialize error variables
$nameErr = $emailErr = $ageErr = "";
$name = $email = $age = "";

$nameClass = $nameErr ? 'error-border' : '';
$emailClass = $emailErr ? 'error-border' : '';
$ageClass = $ageErr ? 'error-border' : '';
//SET FLAG
$hasErrors = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $hasErrors = true;
    } else {
        $name = validate_input($_POST["name"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
            $hasErrors = true;
        }
    }

    // Validate Email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $hasErrors = true;
    } else {
        $email = validate_input($_POST["email"]);
        // Check if email format is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $hasErrors = true;
        }
    }

    // Validate Age
    if (empty($_POST["age"])) {
        $ageErr = "Age is required";
        $hasErrors = true;
    } else {
        $age = validate_input($_POST["age"]);
        // Check if age is a number
        if (!is_numeric($age)) {
            $ageErr = "Age must be a number";
            $hasErrors = true;
        } else if ($age < 18) {
            $ageErr = "Age must be 18 or older";
            $hasErrors = true;
        }
    }

    if ($hasErrors) {
        require("../config/db.php");
        // INSER QUERY
        //     $sql = "INSERT INTO MyGuests (firstname, lastname, email)
        // VALUES ('John', 'Doe', 'john@example.com')";

        // if ($conn->query($sql) === TRUE) {
        // echo "New record created successfully";
        // redirect("Location:login.php");
        // exit();
        // } else {
        // echo "Error: " . $sql . "<br>" . $conn->error;
        // }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        .error-border{
            border: 1px solid red;
        }
    </style>
</head>
<body>
    <h1>Signup</h1>
    <form method="post" action="">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" class="<?= $nameClass ?>" >
    <span class="error"><?php echo $nameErr ?? ''; ?></span><br>

    <label for="email">Email:</label>
    <input type="text" name="email" id="email" class="<?= $emailClass ?>">
    <span class="error"><?php echo $emailErr ?? ''; ?></span><br>

    <label for="age">Age:</label>
    <input type="text" name="age" id="age" class="<?= $ageClass ?>">
    <span class="error"><?php echo $ageErr ?? ''; ?></span><br>

    <input type="submit" value="Submit">
</form>
</body>
</html>