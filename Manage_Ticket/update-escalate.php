<?php
include '../db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticketId = $_POST['ticketId'];
    $status = $_POST['status'];
    $escalationReason = $_POST['escalation_reason'];

    mysqli_begin_transaction($conn);

    try {
        $getSerialQuery = "SELECT serial_num FROM tickets WHERE id = " . $ticketId;
        $result = mysqli_query($conn, $getSerialQuery);

        if (mysqli_num_rows($result) == 0) {
            throw new Exception("Ticket not found");
        }

        $ticket = mysqli_fetch_assoc($result);
        $serialNum = $ticket['serial_num'];
        $dateTimeUpdated = date('Y-m-d H:i:s');

        $insertQuery = "INSERT INTO tickets_updates 
                       (serial_num, t_status, escalation_reason)
                       VALUES ('$serialNum', '$status', '$escalationReason')";

        $insertResult = mysqli_query($conn, $insertQuery);
        if ($insertResult === false) {
            echo "Error in INSERT query: " . mysqli_error($conn);
            throw new Exception("Failed to insert update record.");
        }

        $updateQuery = "UPDATE tickets 
                        SET t_status = '$status',
                        escalation = escalation + 1,
                        escalation_reason = '$escalationReason' 
                        WHERE id = $ticketId";

        $updateResult = mysqli_query($conn, $updateQuery);
        if ($updateResult === false) {
            throw new Exception("Failed to update ticket status: " . mysqli_error($conn));
        }

        mysqli_commit($conn);
        echo "Ticket escalated and update logged successfully.";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    } finally {
        mysqli_close($conn);
    }
}
