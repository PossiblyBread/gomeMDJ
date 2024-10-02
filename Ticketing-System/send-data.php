<?php
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $phone_num = $data['phone_num'];
        $serial_num = getNextSerialNum($conn);
        $type = $data['type'];
        $description = $data['description'];
        $t_status = $data['t_status'] = "Pending";
        $escalation_stage = "P1";  

        $sql = "INSERT INTO `tickets` (`id`, `first_name`, `last_name`, `phone_num`, `serial_num`, `type`, `description`, `t_status`, `escalation_stage`) 
                VALUES (NULL, '$first_name', '$last_name', '$phone_num', '$serial_num', '$type', '$description', '$t_status', '$escalation_stage')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo json_encode(["success" => true, "message" => "Ticket submitted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to submit ticket: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No data received"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
