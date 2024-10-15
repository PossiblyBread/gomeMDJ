<?php
include "../db_conn.php";

// Send ticket to IT Support
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $first_name = mysqli_real_escape_string($conn, $_POST['firstName']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lastName']);
    $phone_num = mysqli_real_escape_string($conn, $_POST['phoneNum']);
    $serial_num = mysqli_real_escape_string($conn, $_POST['serialNum']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $assigned_to_email = mysqli_real_escape_string($conn, $_POST['itSupportEmail']);
    $escalation_stage = 'P1'; // If you need it, include it here
    $t_status = "Pending"; // Default status
    $date_time = date("Y-m-d H:i:s");

    // Use prepared statement for inserting into ticket_assigned
    $stmt = $conn->prepare("INSERT INTO `ticket_assigned`(`first_name`, `last_name`, `phone_num`, `serial_num`, 
                `type`, `description`, `t_status`, `assigned_to_email`, `escalation_stage`, `date_time`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssssss", $first_name, $last_name, $phone_num, $serial_num, $type, $description, $t_status, $assigned_to_email, $escalation_stage, $date_time);
    
    // Execute the insert statement
    if ($stmt->execute()) {
        // Update ticket status in the tickets table
        $update_stmt = $conn->prepare("UPDATE `tickets` SET `t_status` = ? WHERE `serial_num` = ? AND `t_status` = 'new'");
        $update_stmt->bind_param("ss", $t_status, $serial_num);
        
        // Execute the update statement
        if ($update_stmt->execute()) {
            // Calculate and format elapsed time
            $elapsed_time = calculateTimeElapsed($date_time);
            echo "Ticket sent successfully. Time elapsed: " . $elapsed_time;
        } else {
            echo "Failed to update ticket status: " . mysqli_error($conn);
        }

        // Close the update statement
        $update_stmt->close();
    } else {
        echo "Failed to assign ticket: " . mysqli_error($conn);
    }

    // Close the insert statement
    $stmt->close();
}

mysqli_close($conn);
?>