<?php
session_start();
include "db_conn.php";

// Check if email and password are set
if (!isset($_POST['i_email']) || !isset($_POST['i_password'])) {
    header("Location: Guest.php");
    exit();
}

function validate($data) {
    return htmlspecialchars(trim(stripslashes($data)));
}

$i_email = validate($_POST['i_email']);
$i_password = validate($_POST['i_password']);

if (empty($i_email)) {
    header("Location: index.php?error=Email is required");
    exit();
}

if (empty($i_password)) {
    header("Location: index.php?error=Password is required");
    exit();
}

// Check for admin credentials (hardcoded admin user for testing purposes)
if ($i_email == 'admin@gmail.com' && $i_password == 'admin1234') {
    $_SESSION['username'] = 'Admin';
    $_SESSION['role'] = 'admin';
    session_regenerate_id(true);  // Prevent session fixation
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
    
    // Verify password
    if (password_verify($i_password, $row['h_password'])) {
        // Store user data in session
        $_SESSION['username'] = $row['first_name'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['email'] = $row['email']; // Ensure this matches your ticket view requirements
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];  // Store role in session

        // Regenerate session ID
        session_regenerate_id(true);

        // Redirect based on the user role
        if ($row['role'] === 'Admin') {
            header("Location: Admin/Dashboard.php");
        } elseif ($row['role'] === 'IT_Support') {
            header("Location: Manage_Ticket/ticket_support.php"); // Ensure this is the correct URL for IT Support
        } else {
            header("Location: User/Home.php");
        }
        exit();
    } else {
        header("Location: index.php?error=Incorrect password");
        exit();
    }
} else {
    header("Location: index.php?error=User not found");
    exit();
}

$stmt->close();
$conn->close();
?>
