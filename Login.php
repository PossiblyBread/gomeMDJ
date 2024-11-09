<?php
session_start();
include "db_conn.php";

// Set proper headers
header('Content-Type: application/json');
header('X-Requested-With: XMLHttpRequest');

// Function to send JSON response
function sendJsonResponse($status, $message, $data = null) {
    $response = [
        'status' => $status,
        'message' => $message
    ];
    if ($data) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit();
}

// Check if email and password are set
if (!isset($_POST['i_email']) || !isset($_POST['i_password'])) {
    sendJsonResponse('error', 'Email and password are required');
}

// Function to sanitize user input
function validate($data) {
    return htmlspecialchars(trim(stripslashes($data)));
}

$i_email = validate($_POST['i_email']);
$i_password = validate($_POST['i_password']);

// Check for empty email or password
if (empty($i_email) || empty($i_password)) {
    sendJsonResponse('error', 'Email and password are required');
}

try {
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, h_password, role FROM accounts WHERE email = ?");
    if ($stmt === false) {
        throw new Exception("Database prepare failed: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("s", $i_email);
    if (!$stmt->execute()) {
        throw new Exception("Database execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        if (password_verify($i_password, $row['h_password'])) {
            // Store user data in session variables
            $_SESSION['username'] = $row['first_name'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['pending_verification'] = true;

            sendJsonResponse('success', 'Login successful, OTP required');
        } else {
            sendJsonResponse('error', 'Incorrect password');
        }
    } else {
        sendJsonResponse('error', 'User not found');
    }

} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    sendJsonResponse('error', 'An error occurred during login');
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
