<?php
session_start();
include "db_conn.php";

// Check if email and password are set
if (!isset($_POST['i_email']) || !isset($_POST['i_password'])) {
    header("Location: Guest.php");
    exit();
}

// Function to sanitize user input
function validate($data) {
    return htmlspecialchars(trim(stripslashes($data))); // Sanitize input to prevent XSS and whitespace issues
}

$i_email = validate($_POST['i_email']);
$i_password = validate($_POST['i_password']);

// Check for empty email or password
if (empty($i_email) || empty($i_password)) {
    header("Location: index.php?error=Email and password are required");
    exit();
}

// Limit login attempts
$maxAttempts = 7; // Max login attempts
$lockoutTime = 60 * 60; // Lockout time in seconds

// Initialize attempts and lockout time if not already set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = 0;
}

// Check if the user is currently locked out
if ($_SESSION['lockout_time'] > time()) {
    $remainingTime = $_SESSION['lockout_time'] - time();
    die("Account locked. Try again in " . ceil($remainingTime / 60) . " minute(s).");
}

// Prepare SQL statement to prevent SQL injection, selecting only necessary columns
$stmt = $conn->prepare("SELECT id, first_name, last_name, email, h_password, role FROM accounts WHERE email = ?");
if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

// Bind parameters and execute
$stmt->bind_param("s", $i_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    
    // Verify the password using password_verify function
    if (password_verify($i_password, $row['h_password'])) {
        // Reset login attempts on successful login
        $_SESSION['login_attempts'] = 7;

        // Store user data in session variables
        $_SESSION['username'] = $row['first_name'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        // Regenerate session ID for security
        session_regenerate_id(true);

        // Redirect based on user role
        $redirectMap = [
            'Admin' => 'Admin/Dashboard.php',
            'IT_Support' => 'Manage_Ticket/ticket_support.php',
            'User' => 'User/Home.php'
        ];
        
        header("Location: " . ($redirectMap[$row['role']] ?? 'User/Home.php'));
        exit();
    } else {
        incrementLoginAttempts($maxAttempts, $lockoutTime);
        header("Location: index.php?error=Incorrect password");
        exit();
    }
} else {
    incrementLoginAttempts($maxAttempts, $lockoutTime);
    header("Location: index.php?error=User not found");
    exit();
}

// Function to increment login attempts and handle lockout
function incrementLoginAttempts($maxAttempts, $lockoutTime) {
    $_SESSION['login_attempts']++;
    
    if ($_SESSION['login_attempts'] >= $maxAttempts) {
        $_SESSION['lockout_time'] = time() + $lockoutTime; // Lock the account
        die("Too many failed attempts. You can not log in for " . ($lockoutTime / 60) . " minutes.");
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
