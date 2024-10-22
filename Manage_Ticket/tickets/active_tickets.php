<?php
// Fetch all new tickets from the database with the t_status of 'new'
$active_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, assigned_to,
                        priority, severity, escalation, date_time_created, date_time_updated 
                        FROM `tickets` WHERE `t_status` = 'Active'";
$active_tickets_result = mysqli_query($conn, $active_tickets_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Tickets</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link to your CSS file -->
</head>
<body>
    <h2>Pending Tickets</h2>
    <table class="ticket-table">
        <tr>
            <th>Serial Number</th>
            <th style="display:none;">First Name</th>
            <th style="display:none;">Last Name</th>
            <th>Phone Number</th>
            <th>Type</th>
            <th>Ticket Status</th>
            <th>Assigned to</th>
            <th style="display:none;">Severity</th> <!-- Added Severity -->
            <th style="display:none;">Escalation</th> <!-- Added Escalation -->
            <th style="display:none;">Description</th>
            <th>Date-Time Updated</th>
            <th>Actions</th>
        </tr>
        <?php if (mysqli_num_rows($active_tickets_result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($active_tickets_result)): ?>
                <tr data-ticket-id="<?= $row['id'] ?>">
                    <td class="serial-num"><?= $row['serial_num'] ?></td>
                    <td class="first-name" style="display:none;"><?= $row['first_name'] ?></td>
                    <td class="last-name" style="display:none;"><?= $row['last_name'] ?></td>
                    <td class="phone-num"><?= $row['phone_num'] ?></td>
                    <td class="type"><?= $row['type'] ?></td>
                    <td class="t-status"><?= $row['t_status'] ?></td>
                    <td class="assigned-to"><?= $row['assigned_to'] ?></td>
                    <td class="severity" style="display:none;"><?= $row['severity'] ?></td> <!-- Added Severity -->
                    <td class="escalation" style="display:none;"><?= $row['escalation'] ?></td> <!-- Added Escalation -->
                    <td class="description" style="display:none;"><?= $row['description'] ?></td>
                    <td><?= $row['date_time_updated'] ?></td>
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
                        <p><strong>Date Created:</strong> <?= $row['date_time_updated'] ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="11">No Active tickets found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
