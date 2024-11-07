<?php
// get_ticket_status.php
include '../db_conn.php'; // Include database connection

// Get the serial number from the request
$serialNumber = $_GET['serialNumber'] ?? '';

// Prepare the response array
$response = ['status' => ''];

// Query the database only if serial number is provided
if (!empty($serialNumber)) {
    // Prepare and execute the SQL query to fetch the ticket status
    $stmt = $conn->prepare("SELECT t_status FROM tickets WHERE serial_num = ?");
    $stmt->bind_param("s", $serialNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a result was found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response['status'] = $row['t_status']; // Fetch the ticket status
    } else {
        $response['status'] = 'Ticket not found.'; // If no matching ticket is found
    }
    
    $stmt->close();
} else {
    $response['status'] = 'Invalid serial number.';
}

$conn->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
