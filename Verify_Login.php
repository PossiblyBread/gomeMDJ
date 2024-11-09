<?php
session_start();
header('Content-Type: application/json');

// Debug line - remove in production
error_log("Session OTP: " . (isset($_SESSION['otp']) ? $_SESSION['otp'] : 'not set'));

// Check if it's an AJAX request
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

// Get and validate OTP
$input = json_decode(file_get_contents('php://input'), true);
$entered_otp = isset($input['otp']) ? strval(trim($input['otp'])) : '';
$stored_otp = isset($_SESSION['otp']) ? strval($_SESSION['otp']) : '';

// Debug lines - remove in production
error_log("Entered OTP: " . $entered_otp);
error_log("Stored OTP: " . $stored_otp);

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
    // OTP is valid - determine redirect URL using redirect map
    $redirectMap = [
        'Admin' => 'Admin/Dashboard.php',
        'IT_Support' => 'Manage_Ticket/ticket_support.php',
        'User' => 'User/Home.php'
    ];

    $redirectUrl = isset($_SESSION['role']) && isset($redirectMap[$_SESSION['role']]) 
        ? $redirectMap[$_SESSION['role']] 
        : $redirectMap['User']; // Default to User/Home.php if role not found

    // Clear OTP session data
    unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['pending_verification']);

    echo json_encode([
        'status' => 'OTP verified',
        'redirect' => $redirectUrl
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
}
?>
