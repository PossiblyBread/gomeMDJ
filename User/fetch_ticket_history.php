<?php
include '../db_conn.php'; 

header('Content-Type: application/json'); 

if (isset($_GET['serial_num'])) {
    $serialNum = $_GET['serial_num']; 

    // Query to get the ticket history
    $sql = "SELECT status, update_description, date_time_updated FROM tickets_updates WHERE serial_num = ? ORDER BY date_time_updated DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serialNum);
    $stmt->execute();
    $result = $stmt->get_result();

    $history = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $history[] = [
                'status' => $row['status'],
                'update_description' => $row['update_description'],
                'date_time_updated' => $row['date_time_updated']
            ];
        }
        echo json_encode(['success' => true, 'history' => $history]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No updates available']);
    }
}
?>
