<?php
$email = $_SESSION['email'];
$role = $_SESSION['role'];

if ($role === 'Admin') {
    $pending_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, assigned_to,
                            priority, severity, escalation, date_time_created, date_time_updated 
                            FROM `tickets` 
                            WHERE `t_status` = 'Active'";
} else {
    $pending_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, assigned_to,
                            priority, severity, escalation, date_time_created, date_time_updated 
                            FROM `tickets` 
                            WHERE `t_status` = 'Active' AND `assigned_to` = '$email'";
}

$pending_tickets_result = mysqli_query($conn, $pending_tickets_sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Tickets</title>
    <style>
        .table-wrapper {
            overflow-x: auto; 
            margin-bottom: 20px; 
            position: relative; 
        }
        .sticky-header {
            position: sticky; 
            top: 0; 
            background: white; 
            z-index: 1; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .ticket-table {
            border-collapse: collapse;
            width: 100%; 
            min-width: 600px; 
        }
        .ticket-table th, .ticket-table td { 
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left; 
        }
        .ticket-table th {
            background-color: #f2f2f2; 
        }
        .modal {
            display: none; /* Hidden by default */
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 30%; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Active Tickets</h2>

    <div class="table-wrapper">
        <table class="ticket-table">
            <thead class="sticky-header">
                <tr>
                    <th>Serial Number</th>
                    <th style="display:none;">First Name</th>
                    <th style="display:none;">Last Name</th>
                    <th>Phone Number</th>
                    <th>Type</th>
                    <th>Ticket Status</th>
                    <th style="display:none;">Assigned to</th>
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
                            <td class="assigned-to" style="display:none;"><?= $row['assigned_to'] ?></td>
                            <td class="priority"><?= $row['priority'] ?></td>
                            <td class="severity"><?= $row['severity'] ?></td>   
                            <td class="escalation"><?= $row['escalation'] ?></td>
                            <td class="description" style="display:none;"><?= $row['description'] ?></td>
                            <td><?= calculateTimeElapsed($row['date_time_updated']) ?></td>
                            <td>
                                <button onclick="openModal(<?= $row['id'] ?>)">View</button>
                                <button onclick="updateTicketStatus(<?= $row['id'] ?>)" <?= $role === 'Admin' ? 'disabled' : '' ?>>Resolved</button>
                                <button onclick="escalateTicketStatus(<?= $row['id'] ?>)" <?= $role === 'Admin' ? 'disabled' : '' ?>>Escalate</button>
                            </td>
                        </tr>
                        <tr id="sent-message-<?= $row['id'] ?>" style="display:none;">
                            <td colspan="11" style="text-align:center; color: green;" class="sent-message"></td>
                        </tr>
                        <div id="modal-<?= $row['id'] ?>" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal(<?= $row['id'] ?>)">&times;</span>
                                <h2>Ticket Details</h2>
                                <p><strong>Serial Number:</strong> <?= $row['serial_num'] ?></p>
                                <p><strong>Full Name:</strong> <?= $row['first_name'] . ' ' . $row['last_name'] ?></p>
                                <p><strong>Phone Number:</strong> <?= $row['phone_num'] ?></p>
                                <p><strong>Type:</strong> <?= $row['type'] ?></p>
                                <p><strong>Description:</strong> <?= $row['description'] ?></p>
                                <p><strong>Status:</strong> <?= $row['t_status'] ?></p>
                                <p><strong>Assigned to:</strong> <?= $row['assigned_to'] ?></p>
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
                        <td colspan="11">No Active tickets found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function openModal(ticketId) {
            var modal = document.getElementById('modal-' + ticketId);
            modal.style.display = "block";
        }

        function closeModal(ticketId) {
            var modal = document.getElementById('modal-' + ticketId);
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (let i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none";
                }
            }
        }

        function updateTicketStatus(ticketId) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update-resolved.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var sentMessageRow = document.getElementById('sent-message-' + ticketId);
                    var sentMessageCell = sentMessageRow.querySelector('.sent-message');
                    sentMessageCell.innerHTML = "Ticket status updated to Closed.";
                    sentMessageRow.style.display = 'table-row';

                    const ticketRow = document.querySelector(`tr[data-ticket-id='${ticketId}']`);
                    const statusCell = ticketRow.querySelector('.t-status');
                    statusCell.innerText = 'Closed';
                }
            };
            xhr.send(`ticketId=${ticketId}&status=Closed`);
        }

        function escalateTicketStatus(ticketId) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update-escalate.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var sentMessageRow = document.getElementById('sent-message-' + ticketId);
                    var sentMessageCell = sentMessageRow.querySelector('.sent-message');
                    sentMessageCell.innerHTML = "Ticket status updated to Escalated.";
                    sentMessageRow.style.display = 'table-row';

                    const ticketRow = document.querySelector(`tr[data-ticket-id='${ticketId}']`);
                    const statusCell = ticketRow.querySelector('.t-status');
                    statusCell.innerText = 'Escalated';
                }
            };
            xhr.send(`ticketId=${ticketId}&status=Escalated`);
        }
    </script>
</body>
</html>
