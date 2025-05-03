<?php 
session_start();
session_unset(); // Clear all session variables
session_destroy();
// Redirect to the home page after logout
header("Location: ../index.php");
exit(); // Ensure no further code is executed after the redirect
?>