<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

include "../db_conn.php";

// Validate POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial_num = isset($_POST['serial_num']) ? $_POST['serial_num'] : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

    if (empty($serial_num) || $rating < 1 || $rating > 5) {
        http_response_code(400); // Bad Request
        exit("Invalid input");
    }

    // Check if the ticket is "Closed" and belongs to the user
    $checkQuery = "SELECT t_status FROM tickets WHERE serial_num = ? AND user_email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $serial_num, $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404); // Not Found
        exit("Ticket not found or you do not have permission to update this feedback.");
    }

    $row = $result->fetch_assoc();
    if ($row['t_status'] !== 'Closed') {
        http_response_code(403); // Forbidden
        exit("Feedback can only be given to tickets with a 'Closed' status.");
    }

    // Update the feedback
    $updateQuery = "UPDATE tickets SET ticket_rating = ? WHERE serial_num = ? AND user_email = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("iss", $rating, $serial_num, $_SESSION['email']);
    if ($stmt->execute()) {
        header("Location: Tickets.php?msg=Feedback has been sent!");
    } else {
        http_response_code(500); // Internal Server Error
        exit("Failed to update feedback.");
    }
} else {
    http_response_code(405); // Method Not Allowed
    exit("Invalid request method.");
}
?>
