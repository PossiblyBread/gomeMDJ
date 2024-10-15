<?php
session_start(); // Start the session to access session variables
include "../db_conn.php";

// Check if user email is stored in the session
if (!isset($_SESSION['email'])) {
    echo "You must be logged in to view this page.";
    exit(); // Stop execution if the user is not logged in
}

// Get the user's email from the session
$user_email = $_SESSION['email'];

// Prepare the SQL statement to fetch tickets assigned to the logged-in user
$sql = "SELECT * FROM `ticket_assigned` WHERE `assigned_to_email` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email); // Bind user email to the SQL query
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Serial Number</th>
                <th>Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Escalation Stage</th>
                <th>Ticket Age</th>
            </tr>";

    // Output each row of the tickets table
    while ($row = mysqli_fetch_assoc($result)) {
        // Calculate elapsed time for the ticket
        $ticket_age = calculateTimeElapsed($row['date_time']);

        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['phone_num']}</td>
                <td>{$row['serial_num']}</td>
                <td>{$row['type']}</td>
                <td>{$row['description']}</td>
                <td>{$row['t_status']}</td>
                <td>{$row['escalation_stage']}</td>
                <td>{$ticket_age}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No tickets found assigned to you.";
}

// Close the prepared statement and the database connection
$stmt->close();
mysqli_close($conn);
?>
