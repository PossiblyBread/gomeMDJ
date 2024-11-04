<?php
include '../db_conn.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticketId = $_POST['ticketId'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE `tickets` SET t_status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $ticketId);

    if ($stmt->execute()) {
        echo "Ticket status updated to Closed.";
    } else {
        echo "Error updating ticket status: " . $conn->error;
    }

    $stmt->close();
}
?>
