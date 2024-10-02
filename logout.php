<?php
session_start();
// Destroy all session data
session_unset();
session_destroy();
// Redirect to the login page or home page
header("Location: Home.php"); // Adjust the location as needed
exit();
?>
