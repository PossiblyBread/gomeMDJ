<?php
session_start();
include "db_conn.php";

if (!isset($_POST['i_email']) || !isset($_POST['i_password'])) {
    header("Location: Guest.php");
    exit();
}

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$i_email = validate($_POST['i_email']);
$i_password = validate($_POST['i_password']);

if (empty($i_email)) {
    header("Location: index.php?error=User Name is required");
    exit();
}
if (empty($i_password)) {
    header("Location: index.php?error=Password is required");
    exit();
}

// Check for admin credentials 
if ($i_email == 'admin@gmail.com' && $i_password == 'admin1234') {
    $_SESSION['username'] = 'Admin'; // Set username for admin
    header("Location: Admin/Dashboard.php");
    exit();
}

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM accounts WHERE email = ?");
$stmt->bind_param("s", $i_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    
    if (password_verify($i_password, $row['h_password'])) {
        $_SESSION['username'] = 'Guest'; // Set username for regular users
        $_SESSION['first_name'] = $row['first_name']; // Set first_name from database
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        header("Location: User/Shop.php");
        exit();
    } else {
        header("Location: Home.php?error=Incorrect username or password");
        exit();
    }
} else {
    header("Location: Home.php?error=Incorrect username or password");
    exit();
}

$stmt->close();
$conn->close();
?>
