<?php
include "../db_conn.php";

// Check if the user is logged in
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

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
        $severity = $data['severity'];  // Receive severity from the frontend
        $t_status = "new"; // Initial status
        $assigned_to = "";
        $priority = "";
        $escalation = "";
        $date_time_updated = date("Y-m-d H:i:s"); // Current timestamp for the update

        // Set the priority based on the type
        switch ($type) {
            case "Billing":
                $priority = "1";
                break;
            case "Technical":
                $priority = "3";
                break;
            case "Mechanical":
                $priority = "2";
                break;
            case "Assistance Request":
                $priority = "4";
                break;
        }

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Prepare the SQL statement for the tickets table
            $stmt = $conn->prepare("INSERT INTO `tickets` (`first_name`, `last_name`, `user_email`, `phone_num`, `serial_num`, 
                                    `type`, `description`, `t_status`, `assigned_to`, `priority`, `severity`, `escalation`) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            // Bind parameters to the SQL query
            $stmt->bind_param(
                "ssssssssssss",
                $first_name,
                $last_name,
                $user_email,
                $phone_num,
                $serial_num,
                $type,
                $description,
                $t_status,
                $assigned_to,
                $priority,
                $severity,
                $escalation
            );

            $stmt->execute();
            $stmt_update = $conn->prepare("INSERT INTO `tickets_updates` (`serial_num`, `t_status`, `date_time_updated`) 
                                          VALUES (?, ?, ?)");
            $stmt_update->bind_param("sss", $serial_num, $t_status, $date_time_updated);
            $stmt_update->execute();
            $conn->commit();

            echo json_encode(["success" => true, "message" => "Ticket submitted successfully, and update recorded."]);
        } catch (Exception $e) {
            // Rollback the transaction if something goes wrong
            $conn->rollback();

            echo json_encode(["success" => false, "message" => "Failed to submit ticket: " . $e->getMessage()]);
        }

        // Close the statements
        $stmt->close();
        $stmt_update->close();
    } else {
        echo json_encode(["success" => false, "message" => "No data received"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

function getNextTicketSerialNum($conn)
{
    // Query the tickets table to get the next serial number
    $query = "SELECT MAX(serial_num) AS max_serial FROM tickets";
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
