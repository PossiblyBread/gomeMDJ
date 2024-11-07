<?php
include '../db_conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticketId = $_POST['ticketId'];
    
    $sql = "UPDATE `tickets` SET `t_status` = 'Active' WHERE `id` = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $ticketId);
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo json_encode(['success' => true, 'message' => 'Ticket status updated to Active.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No ticket found with that ID.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
    }
}
mysqli_close($conn);
?>
