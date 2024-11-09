<?php
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $user_email = $data['user_email'];
        $phone_num = $data['phone_num'];
        $serial_num = getNextTicketSerialNum($conn); // Get the next ticket serial number
        $type = $data['type'];
        $description = $data['description'];
        $t_status = "new";
        $assigned_to = "";
        $priority = "";
        $severity = "";
        $escalation = "";

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO `tickets` (`first_name`, `last_name`, `user_email`, `phone_num`, `serial_num`, 
                                `type`, `description`, `t_status`, `assigned_to`, `priority`, `severity`, `escalation`) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters to the SQL query
        $stmt->bind_param("ssssssssssss", $first_name, $last_name, $user_email, $phone_num, $serial_num, 
                          $type, $description, $t_status, $assigned_to, $priority, $severity, $escalation);

        // Execute the statement
        $result = $stmt->execute();

        if ($result) {
            echo json_encode(["success" => true, "message" => "Ticket submitted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to submit ticket: " . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "No data received"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

function getNextTicketSerialNum($conn) {
    // Query the tickets table to get the next serial number
    $query = "SELECT MAX(serial_num) AS max_serial FROM tickets"; // Changed to tickets
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    return isset($row['max_serial']) ? $row['max_serial'] + 1 : 10000; // Default starting serial number
}

// Close the database connection
$conn->close();
?>
