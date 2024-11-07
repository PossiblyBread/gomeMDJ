<?php
$email = $_SESSION['email'];
$role = $_SESSION['role']; // Assuming role is stored in the session

// If the user is an Admin, fetch all pending tickets. Otherwise, restrict to tickets assigned to the user.
if ($role === 'Admin') {
    $pending_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                            assigned_to, priority, severity, escalation, date_time_created, date_time_updated 
                            FROM `tickets` 
                            WHERE `t_status` = 'Pending'";
} else {
    $pending_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                            assigned_to, priority, severity, escalation, date_time_created, date_time_updated 
                            FROM `tickets` 
                            WHERE `t_status` = 'Pending' AND `assigned_to` = '$email'";
}

$pending_tickets_result = mysqli_query($conn, $pending_tickets_sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Tickets - <?php echo $email; ?></title> <!-- Optional: include email or role in title -->
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
        <table class="ticket-table" id="ticketTable">
            <thead class="sticky-header">
                <tr>
                    <th>Serial Number</th>
                    <th style="display:none;">First Name</th>
                    <th style="display:none;">Last Name</th>
                    <th>Phone Number</th>
                    <th>Type</th>
                    <th>Ticket Status</th>
                    <th>Assigned to</th>
                    <th>Priority</th>
                    <th>Severity</th>
                    <th>Escalation</th>
                    <th style="display:none;">Description</th>
                    <th>Ticket Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($pending_tickets_result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($pending_tickets_result)): ?>
                        <tr data-ticket-id="<?= $row['id'] ?>">
                            <td class="serial-num"><?= $row['serial_num'] ?></td>
                            <td class="first-name" style="display:none;"><?= $row['first_name'] ?></td>
                            <td class="last-name" style="display:none;"><?= $row['last_name'] ?></td>
                            <td class="phone-num"><?= $row['phone_num'] ?></td>
                            <td class="type"><?= $row['type'] ?></td>
                            <td class="t-status"><?= $row['t_status'] ?></td>
                            <td class="assigned-to"><?= $row['assigned_to'] ?></td>
                            <td class="priority"><?= $row['priority'] ?></td>
                            <td class="severity"><?= $row['severity'] ?></td>
                            <td class="escalation"><?= $row['escalation'] ?></td>
                            <td class="description" style="display:none;"><?= $row['description'] ?></td>
                            <td><?= calculateTimeElapsed($row['date_time_updated']) ?></td>
                            <td>
                                <button onclick="openModal('<?= $row['id'] ?>')">View</button>
                                <button 
                                    onclick="updateTickettoActiveStatus(<?= $row['id'] ?>, '<?= $row['assigned_to'] ?>')"
                                    <?= $role === 'Admin' ? 'disabled' : '' ?> 
                                >
                                    Accept
                                </button>
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
                                <p><strong>Severity:</strong> <?= $row['severity'] ?></p>
                                <p><strong>Escalation:</strong> <?= $row['escalation'] ?></p>
                                <p><strong>Date Created:</strong>
                                <?php 
                                    $formatted_date_time_created = date("m/d/Y h:i A", strtotime($row['date_time_created']));
                                    echo $formatted_date_time_created;
                                    ?>
                                </p>
                                <p><strong>Elapsed Time:</strong> <?= calculateTimeElapsed($row['date_time_updated']) ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11">No Pending tickets found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function updateTickettoActiveStatus(ticketId, itSupportEmail) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update-active.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var sentMessageRow = document.getElementById('sent-message-' + ticketId);
                    var sendButton = document.querySelector(`tr[data-ticket-id='${ticketId}'] button[onclick^='sendTicket']`);
                    var sentMessageCell = sentMessageRow.querySelector('.sent-message');
                    sentMessageCell.innerHTML = "TICKET has been accepted by " + itSupportEmail + "!";
                    sentMessageRow.style.display = 'table-row';
                    sendButton.disabled = true; // Disable send button after sending
                }
            };
            xhr.send(`ticketId=${ticketId}&itSupportEmail=${itSupportEmail}`);
        }
    </script>
</body>
</html>
