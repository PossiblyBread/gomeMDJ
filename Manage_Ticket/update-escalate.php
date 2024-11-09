<?php
include '../db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticketId = $_POST['ticketId'];
    $status = $_POST['status'];

    $sql = "UPDATE tickets SET t_status = ?, escalation = escalation + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $ticketId);
    if ($stmt->execute()) {
        echo "Ticket escalated successfully.";
    } else {
        echo "Error updating ticket: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
