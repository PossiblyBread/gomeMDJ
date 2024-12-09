<?php
include '../db_conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input values for security
    $ticket_id = mysqli_real_escape_string($conn, $_POST['ticket_id']);
    $new_status = 'Open'; // Assuming you want to set the status to "Open"

    // Get the serial number of the ticket to use it for the update log
    $get_ticket_sql = "SELECT serial_num FROM tickets WHERE id = '$ticket_id'";
    $result = mysqli_query($conn, $get_ticket_sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the serial number of the ticket
        $ticket_data = mysqli_fetch_assoc($result);
        $serial_num = $ticket_data['serial_num'];

        // Update the ticket status in the 'tickets' table
        $update_status_sql = "UPDATE tickets SET t_status = '$new_status', date_time_updated = NOW() WHERE id = '$ticket_id'";

        if (mysqli_query($conn, $update_status_sql)) {
            // Insert a record into the 'tickets_updates' table
            $insert_update_sql = "INSERT INTO tickets_updates (serial_num, t_status, date_time_updated) 
                                  VALUES ('$serial_num', '$new_status', NOW())";

            if (mysqli_query($conn, $insert_update_sql)) {
                // Redirect to a confirmation page (or display success message)
                header("Location: Recieved_Ticket.php?status=reopened"); // Replace with your actual page
                exit();
            } else {
                // If insert fails, show error
                echo "Error inserting into tickets_updates: " . mysqli_error($conn);
            }
        } else {
            // If update fails, show error
            echo "Error updating ticket status: " . mysqli_error($conn);
        }
    } else {
        echo "Ticket not found.";
    }
}
?>
