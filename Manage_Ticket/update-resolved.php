<?php
include '../db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticketId = $_POST['ticketId'];
    $status = $_POST['status'];
    
    // Get the serial number of the ticket (used for the update log)
    $getSerialQuery = "SELECT serial_num FROM tickets WHERE id = ?";
    $stmt = $conn->prepare($getSerialQuery);
    $stmt->bind_param("i", $ticketId);
    $stmt->execute();
    $result = $stmt->get_result();
    $ticket = $result->fetch_assoc();
    $serialNum = $ticket['serial_num'];
    $stmt->close();

    // Current date and time for the update
    $dateTimeUpdated = date('Y-m-d H:i:s');

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Step 1: Update the 'tickets' table
        $updateQuery = "UPDATE tickets SET t_status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("si", $status, $ticketId);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update ticket status.");
        }
        $stmt->close();

        // Step 2: Insert into 'tickets_updates' table
        $insertQuery = "INSERT INTO tickets_updates (serial_num, t_status, date_time_updated) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $serialNum, $status, $dateTimeUpdated);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert into tickets_updates.");
        }
        $stmt->close();

        // Commit the transaction if both queries succeed
        mysqli_commit($conn);

        echo "Ticket status updated and logged successfully.";
    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        mysqli_rollback($conn);

        echo "Error: " . $e->getMessage();
    } finally {
        // Close the connection
        mysqli_close($conn);
    }
}
?>
