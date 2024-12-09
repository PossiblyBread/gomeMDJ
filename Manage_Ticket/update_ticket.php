<?php
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST; // Get posted data

    if (isset($data['ticketId'])) {
        $ticketId = $data['ticketId'];
        $itSupportEmail = $data['itSupportEmail']; // Assuming you want to do something with this
        // Get other details as needed
        $serialNum = $data['serialNum']; // Serial number to be logged in tickets_updates
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $phoneNum = $data['phoneNum'];
        $type = $data['type'];
        $description = $data['description'];
        $priority = $data['priority'];
        $severity = $data['severity'];
        $escalation = $data['escalation'];

        // Step 1: Update the ticket status to Pending
        $update_sql = "UPDATE `tickets` SET `t_status` = 'Pending', `assigned_to` = '$itSupportEmail', 
                        `date_time_updated` = NOW() WHERE `id` = $ticketId";

        if (mysqli_query($conn, $update_sql)) {
            // Step 2: Insert a record into the tickets_updates table
            // First, fetch the serial number and the updated status
            $select_ticket_sql = "SELECT `serial_num`, `t_status` FROM `tickets` WHERE `id` = $ticketId";
            $result = mysqli_query($conn, $select_ticket_sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $ticket = mysqli_fetch_assoc($result);
                $serialNum = $ticket['serial_num']; // Get the serial number from the ticket
                $newStatus = 'Pending'; // We set the new status to 'Pending' when updating the ticket

                // Insert the update into tickets_updates table
                $insert_update_sql = "INSERT INTO `tickets_updates` (`serial_num`, `t_status`, `date_time_updated`) 
                                      VALUES ('$serialNum', '$newStatus', NOW())";

                if (mysqli_query($conn, $insert_update_sql)) {
                    echo json_encode(["success" => true, "message" => "Ticket updated and update recorded successfully."]);
                } else {
                    echo json_encode(["success" => false, "message" => "Error inserting into tickets_updates: " . mysqli_error($conn)]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Error fetching ticket details."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Error updating ticket: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Ticket ID not provided."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
