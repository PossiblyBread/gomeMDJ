<?php
session_start();
include '../db_conn.php';

if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

$id = $_SESSION['id'];  // Assume user ID is stored in session
$validation_status = '';

// Fetch the user's validation status from the accounts table
$sql_validation = "SELECT `validation` FROM `accounts` WHERE `id` = '$id'";
$validation_result = mysqli_query($conn, $sql_validation);
if ($validation_result) {
    $row = mysqli_fetch_assoc($validation_result);
    $validation_status = $row['validation'];  // Get validation status
} else {
    die("Error fetching validation status.");
}


// Check if the form is submitted via POST (for updating user type and feedback)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use the POST values if provided, otherwise retain the default $user_type
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : $user_type;
    $feedback_rating = isset($_POST['feedback_rating']) ? $_POST['feedback_rating'] : 0; // Default to 0 if not set
    $feedback_comment = isset($_POST['feedback_comment']) ? trim($_POST['feedback_comment']) : ''; // Default to empty string if not set

    // Ensure feedback rating is between 1 and 5
    if ($feedback_rating < 1 || $feedback_rating > 5) {
        $feedback_rating = 0; // Default to 0 if invalid
    }

    // Prepare and execute the database query to insert the feedback
    $stmt = $conn->prepare("INSERT INTO website_feedback (user_type, feedback_rating, feedback_comment) VALUES (?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sis", $user_type, $feedback_rating, $feedback_comment);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Thank you for your feedback!"; // Success message
        } else {
            $_SESSION['message'] = "Error submitting feedback: " . $stmt->error; // Error message
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error preparing statement: " . $conn->error; // Error preparing statement
    }

    // Redirect back to the page that opened the modal
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
