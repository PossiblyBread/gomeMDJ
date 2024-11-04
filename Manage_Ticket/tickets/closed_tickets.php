<?php
$email = $_SESSION['email'];
$role = $_SESSION['role']; // Assuming role is stored in session

// If the user is an Admin, fetch all closed tickets. Otherwise, restrict to assigned tickets.
if ($role === 'Admin') {
    $closed_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, assigned_to,
                           priority, severity, escalation, date_time_created, date_time_updated 
                           FROM `tickets` 
                           WHERE `t_status` = 'Closed'";
} else {
    $closed_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, assigned_to,
                           priority, severity, escalation, date_time_created, date_time_updated 
                           FROM `tickets` 
                           WHERE `t_status` = 'Closed' AND `assigned_to` = '$email'";
}

$closed_tickets_result = mysqli_query($conn, $closed_tickets_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Tickets</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link to your CSS file -->
    <style>
        .table-wrapper {
            overflow-x: auto; /* Enable horizontal scroll */
            margin-bottom: 20px; /* Spacing below the table */
            position: relative; /* For positioning sticky header */
        }
        .sticky-header {
            position: sticky; /* Makes the header sticky */
            top: 0; /* Sticks to the top of the wrapper */
            background: white; /* Background color for visibility */
            z-index: 1; /* Ensure it appears above the table */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for effect */
        }
        .ticket-table {
            border-collapse: collapse;
            width: 100%; /* Full width */
        }
        .ticket-table th, .ticket-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left; /* Align text to the left */
        }
    </style>
</head>
<body>
    <h2>Pending Tickets</h2>
    <div class="table-wrapper">
        <table class="ticket-table">
            <tr>
                <th>Serial Number</th>
                <th style="display:none;">First Name</th>
                <th style="display:none;">Last Name</th>
                <th>Phone Number</th>
                <th>Type</th>
                <th>Ticket Status</th>
                <th>Resolved by</th>
                <th>Priority</th>
                <th>Severity</th> <!-- Added Severity -->
                <th>Escalation</th> <!-- Added Escalation -->
                <th style="display:none;">Description</th>
                <th>Closing Date-Time</th>
                <th>Actions</th>
            </tr>
            <?php if (mysqli_num_rows($closed_tickets_result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($closed_tickets_result)): ?>
                    <tr data-ticket-id="<?= $row['id'] ?>">
                        <td class="serial-num"><?= $row['serial_num'] ?></td>
                        <td class="first-name" style="display:none;"><?= $row['first_name'] ?></td>
                        <td class="last-name" style="display:none;"><?= $row['last_name'] ?></td>
                        <td class="phone-num"><?= $row['phone_num'] ?></td>
                        <td class="type"><?= $row['type'] ?></td>
                        <td class="t-status"><?= $row['t_status'] ?></td>
                        <td class="assigned-to"><?= $row['assigned_to'] ?></td>
                        <td class="priority"><?= $row['priority'] ?></td> <!-- Added Priority -->
                        <td class="severity"><?= $row['severity'] ?></td> <!-- Added Severity -->
                        <td class="escalation"><?= $row['escalation'] ?></td> <!-- Added Escalation -->
                        <td class="description" style="display:none;"><?= $row['description'] ?></td>
                        <td><?= calculateTimeElapsed($row['date_time_updated']) ?></td>
                        <td>
                            <button onclick="openModal('<?= $row['id'] ?>')">View</button>
                        </td>
                    </tr>
                    <tr id="sent-message-<?= $row['id'] ?>" style="display:none;">
                        <td colspan="11" style="text-align:center; color: green;" class="sent-message"></td>
                    </tr>
                    <div id="modal-<?= $row['id'] ?>" class="modal">
                        <div class="modal-content">
                            <h2>Ticket Details</h2>
                            <p><strong>Serial Number:</strong> <?= $row['serial_num'] ?></p>
                            <p><strong>Full Name:</strong> <?= $row['first_name'] . ' ' . $row['last_name'] ?></p>
                            <p><strong>Phone Number:</strong> <?= $row['phone_num'] ?></p>
                            <p><strong>Type:</strong> <?= $row['type'] ?></p>
                            <p><strong>Description:</strong> <?= $row['description'] ?></p>
                            <p><strong>Status:</strong> <?= $row['t_status'] ?></p>
                            <p><strong>Severity:</strong> <?= $row['severity'] ?></p> <!-- Added Severity -->
                            <p><strong>Escalation:</strong> <?= $row['escalation'] ?></p> <!-- Added Escalation -->
                            <p><strong>Date Created:</strong>
                                <?php 
                                    $formatted_date_time_created = date("m/d/Y h:i A", strtotime($row['date_time_created']));
                                    echo $formatted_date_time_created;
                                ?>
                            </p>
                            <p><strong>Ticket closed time:</strong> <?= calculateTimeElapsed($row['date_time_updated']) ?>   </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">No Closed tickets found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
