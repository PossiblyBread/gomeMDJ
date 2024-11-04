<?php
include '../db_conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticketId = $_POST['ticketId'];
    $priority = $_POST['priority'];
    $severity = $_POST['severity'];

    // Update SQL statement
    $update_sql = "UPDATE `tickets` 
                   SET `t_status` = 'Open', 
                       `priority` = ?, 
                       `severity` = ?, 
                       `date_time_updated` = NOW() 
                   WHERE `id` = ?";
    
    // Prepare and execute statement
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("iii", $priority, $severity, $ticketId);
    
    if ($stmt->execute()) {
        echo "Ticket updated successfully.";
    } else {
        echo "Error updating ticket: " . $stmt->error;
    }
    
    $stmt->close();
}
?>
