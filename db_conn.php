<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "web_db";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error()); 
}

// For registering a new user
if (isset($_POST['Submit'])) {
    $serial_num = getNextSerialNum($conn);
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name']; 
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num']; 
    $a_password = $_POST['a_password']; 
    $h_password = password_hash($a_password, PASSWORD_DEFAULT);
    $role = "user";

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Check if the email already exists using a prepared statement
    $checkEmailQuery = "SELECT * FROM `accounts` WHERE `email` = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email); // "s" indicates the type is string
    $stmt->execute();
    $emailResult = $stmt->get_result();

    if ($emailResult->num_rows > 0) {
        header("Location: index.php?msg=Email already in use!");
        exit; 
    }

    // Insert the new user into the database using a prepared statement
    $sql = "INSERT INTO `accounts` (`serial_num`, `last_name`, `first_name`, `email`, `phone_num`, `h_password`, `role`) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $serial_num, $last_name, $first_name, $email, $phone_num, $h_password, $role);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['user_logged_in'] = true; 
            $_SESSION['user_email'] = $email;
        
        header("Location: index.php?msg=User Created Successfully!");
        exit; 
    } else {
        echo "Failed: " . $stmt->error; // Use $stmt->error for prepared statement errors
    }   
}

function getNextSerialNum($conn) {
    // Change the table name to accounts to get the next serial number
    $query = "SELECT MAX(serial_num) AS max_serial FROM accounts"; 
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return isset($row['max_serial']) ? $row['max_serial'] + 1 : 10000;
}

// Function to calculate time elapsed
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
