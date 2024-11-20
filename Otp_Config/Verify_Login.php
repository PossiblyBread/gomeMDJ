<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Debug logging
error_log("Verify_Login.php started");
error_log("Session role: " . ($_SESSION['role'] ?? 'not set'));

// Check if user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

// Get and validate OTP
$input = json_decode(file_get_contents('php://input'), true);
$entered_otp = isset($input['otp']) ? strval(trim($input['otp'])) : '';
$stored_otp = isset($_SESSION['otp']) ? strval($_SESSION['otp']) : '';

// Debug logging
error_log("Entered OTP: " . $entered_otp);
error_log("Stored OTP: " . $stored_otp);
error_log("User Role: " . $_SESSION['role']);

if (empty($entered_otp)) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter OTP']);
    exit();
}

// Verify OTP
if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expiry'])) {
    echo json_encode(['status' => 'error', 'message' => 'No OTP request found']);
    exit();
}

if (time() > $_SESSION['otp_expiry']) {
    echo json_encode(['status' => 'error', 'message' => 'OTP has expired']);
    exit();
}

if ($entered_otp === $stored_otp) {
    // Define redirect paths based on role
    $redirectPaths = [
        'Admin' => '../Admin/Dashboard.php',
        'IT_Support' => '../Manage_Ticket/ticket_support.php',
        'User' => '../User/Home.php'
    ];

    // Get user's role from session
    $userRole = $_SESSION['role'];
    error_log("Redirecting user with role: " . $userRole);

    // Determine redirect URL
    if (isset($redirectPaths[$userRole])) {
        $redirectUrl = $redirectPaths[$userRole];
    } else {
        error_log("Invalid role detected: " . $userRole);
        $redirectUrl = $redirectPaths['User']; // Default to User if role not found
    }

    // Clear OTP session data but keep user session
    unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['pending_verification']);
    
    error_log("Redirecting to: " . $redirectUrl);

    echo json_encode([
        'status' => 'OTP verified',
        'redirect' => $redirectUrl,
        'role' => $userRole // Include role in response for debugging
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
}
?> 