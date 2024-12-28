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

?>