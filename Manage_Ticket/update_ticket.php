<?php
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST; // Get posted data

    if (isset($data['ticketId'])) {
        $ticketId = $data['ticketId'];
        $itSupportEmail = $data['itSupportEmail']; // Assuming you want to do something with this
        // Get other details as needed
        $serialNum = $data['serialNum'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $phoneNum = $data['phoneNum'];
        $type = $data['type'];
        $description = $data['description'];
        $priority = $data['priority'];
        $severity = $data['severity'];
        $escalation = $data['escalation'];

        // Update the ticket status to Pending
        $update_sql = "UPDATE `tickets` SET `t_status` = 'Pending', `assigned_to` = '$itSupportEmail', 
                        `date_time_updated` = NOW() WHERE `id` = $ticketId";

        if (mysqli_query($conn, $update_sql)) {
            echo json_encode(["success" => true, "message" => "Ticket updated successfully."]);
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
