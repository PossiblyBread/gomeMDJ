<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "web_db";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error()); 
}

// Function to calculate time elapsed
// set the timezone for Philippine time
function calculateTimeElapsed($date_time) {
    date_default_timezone_set('Asia/Singapore'); // Ensure timezone is set
    $current_time = time();
    $upload_time = strtotime($date_time);
    
    $elapsed_time = $current_time - $upload_time;

    if ($elapsed_time < 86400) {
        $hours = floor($elapsed_time / 3600);
        $minutes = floor(($elapsed_time % 3600) / 60);
        $seconds = $elapsed_time % 60;
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    } else {
        $days = floor($elapsed_time / 86400);
        return $days . " day" . ($days != 1 ? "s" : ""); 
    }
}

?>
