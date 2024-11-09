<?php
include '../db_conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'];

    // Update the ticket status to 'Open'
    $update_status_sql = "UPDATE tickets SET t_status = 'Open', date_time_updated = NOW() WHERE id = '$ticket_id'";

    if (mysqli_query($conn, $update_status_sql)) {
        // Redirect or display a success message
        header("Location: Recieved_Ticket.php?status=reopened"); // Replace with your actual page
        exit();
    } else {
        echo "Error updating ticket: " . mysqli_error($conn);
    }
}
?>
