<?php
include '../db_conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect the POST data
    $ticketId = $_POST['ticketId'];
    $severity = $_POST['severity'];

    // Start a transaction to ensure both the update and insert are done atomically
    $conn->begin_transaction();

    try {
        // Step 1: Update SQL statement to update ticket in `tickets` table
        $update_sql = "UPDATE `tickets` 
                       SET `t_status` = 'Open', 
                           `severity` = ?, 
                           `date_time_updated` = NOW() 
                       WHERE `id` = ?";
        
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ii", $severity, $ticketId);
        
        if (!$stmt->execute()) {
            throw new Exception("Error updating ticket: " . $stmt->error);
        }

        // Step 2: Insert a new record into `tickets_updates` table
        $insert_update_sql = "INSERT INTO `tickets_updates` (`serial_num`, `t_status`, `date_time_updated`) 
                              SELECT `serial_num`, 'Open', NOW() FROM `tickets` WHERE `id` = ?";
        
        $stmt_update = $conn->prepare($insert_update_sql);
        $stmt_update->bind_param("i", $ticketId);
        
        if (!$stmt_update->execute()) {
            throw new Exception("Error inserting into tickets_updates: " . $stmt_update->error);
        }

        // Commit the transaction if both queries were successful
        $conn->commit();
        
        // Return success message
        echo "Ticket updated and update recorded successfully.";

    } catch (Exception $e) {
        // Rollback the transaction if any error occurs
        $conn->rollback();
        
        // Output error message
        echo "Error: " . $e->getMessage();
    }

    // Close the prepared statements
    $stmt->close();
    $stmt_update->close();
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
