<?php
include '../db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticketId = $_POST['ticketId'];
    $newStatus = 'Active'; // You can modify this to use a dynamic status if needed.
    $dateTimeUpdated = date('Y-m-d H:i:s'); // Current date and time.

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Step 1: Update the 'tickets' table
        $sqlUpdate = "UPDATE `tickets` SET `t_status` = ? WHERE `id` = ?";
        if ($stmt = mysqli_prepare($conn, $sqlUpdate)) {
            mysqli_stmt_bind_param($stmt, "si", $newStatus, $ticketId);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to update ticket status.");
            }
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Failed to prepare update statement.");
        }

        // Step 2: Insert into 'tickets_updates' table
        $sqlInsert = "INSERT INTO `tickets_updates` (`serial_num`, `t_status`, `date_time_updated`) 
                      SELECT `serial_num`, ?, ? FROM `tickets` WHERE `id` = ?";
        if ($stmt = mysqli_prepare($conn, $sqlInsert)) {
            mysqli_stmt_bind_param($stmt, "ssi", $newStatus, $dateTimeUpdated, $ticketId);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to insert into tickets_updates.");
            }
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Failed to prepare insert statement.");
        }

        // Commit the transaction if both operations succeed
        mysqli_commit($conn);

        // Success response
        echo json_encode(['success' => true, 'message' => 'Ticket status updated and logged.']);

    } catch (Exception $e) {
        // Rollback the transaction if any operation fails
        mysqli_rollback($conn);
        
        // Error response
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    } finally {
        // Close the connection
        mysqli_close($conn);
    }
}
?>
