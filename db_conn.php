<?php
$servername = "localhost";
$username = "mark5_VIFAK";
$password = "vIfak_5@98";
$db_name = "web_db2";

try {
    $conn = new mysqli($servername, $username, $password, $db_name);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed'
    ]);
    exit();
}
// set the timezone for Philippine time
function calculateTimeElapsed($date_time)
{
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

// php sign
$formatPeso = fn($amount) => '₱' . number_format((float)$amount, 2, '.', ',');

