<?php
$email = $_SESSION['email'];
$role = $_SESSION['role'];

if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

// Check for sort order in the URL and set default if not set
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'asc';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'serial_num'; // Default sort by serial number
$sort_order_sql = ($sort_order === 'desc') ? 'DESC' : 'ASC';

// Determine the sort column based on user selection
$order_by_sql = "CASE WHEN escalation IS NOT NULL AND escalation != '' THEN 0 ELSE 1 END, "; // Prioritize escalation
if ($sort_by === 'priority') {
    $order_by_sql .= "priority $sort_order_sql, serial_num ASC"; // Sort by priority first, then by serial number
} elseif ($sort_by === 'severity') {
    $order_by_sql .= "severity $sort_order_sql, serial_num ASC"; // Sort by severity first, then by serial number
} elseif ($sort_by === 'escalation') {
    $order_by_sql .= "escalation $sort_order_sql, serial_num ASC"; // Sort by escalation first, then by serial number
} else {
    $order_by_sql .= "serial_num $sort_order_sql"; // Default sort by serial number
}

if ($role === 'Admin') {
    $pending_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, assigned_to,
                            priority, severity, escalation, escalation_reason, date_time_created, date_time_updated 
                            FROM `tickets` 
                            WHERE `t_status` = 'Active'
                            ORDER BY date_time_updated DESC"; // Sort by most recent first
} else {
    $pending_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, assigned_to,
                            priority, severity, escalation, escalation_reason, date_time_created, date_time_updated 
                            FROM `tickets` 
                            WHERE `t_status` = 'Active' AND `assigned_to` = '$email'
                            ORDER BY date_time_updated DESC"; // Sort by most recent first
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
        /* Styles for the page */
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

        .ticket-table th,
        .ticket-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .ticket-table th {
            background-color: #f2f2f2;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            transition: opacity 0.3s ease-in-out;
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: slide-down 0.4s ease-out;
        }

        @keyframes slide-down {
            from {
                transform: translateY(-20%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            transition: color 0.2s;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        textarea {
            width: calc(100% - 22px);
            height: 120px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }


        @media (max-width: 768px) {
            .modal-content {
                width: 90%;
                margin: 20% auto;
            }
        }
    </style>
</head>

<body>
    <h2>Active Tickets</h2>
    <div class="container">
        <div>
            <label for="sort-serial">Sort by Serial Number:</label>
            <select class="table-sort" id="sort-serial" onchange="location = this.value;">
                <option value="?sort_by=serial_num&sort=asc" <?php echo $sort_by === 'serial_num' && $sort_order === 'asc' ? 'selected' : ''; ?>>Ascending</option>
                <option value="?sort_by=serial_num&sort=desc" <?php echo $sort_by === 'serial_num' && $sort_order === 'desc' ? 'selected' : ''; ?>>Descending</option>
            </select>
        </div>
        <div>
            <label for="sort-priority">Sort by Priority:</label>
            <select class="table-sort" id="sort-priority" onchange="location = this.value;">
                <option value="?sort_by=priority&sort=asc" <?php echo $sort_by === 'priority' && $sort_order === 'asc' ? 'selected' : ''; ?>>Ascending</option>
                <option value="?sort_by=priority&sort=desc" <?php echo $sort_by === 'priority' && $sort_order === 'desc' ? 'selected' : ''; ?>>Descending</option>
            </select>
        </div>
        <div>
            <label for="sort-severity">Sort by Severity:</label>
            <select class="table-sort" id="sort-severity" onchange="location = this.value;">
                <option value="?sort_by=severity&sort=asc" <?php echo $sort_by === 'severity' && $sort_order === 'asc' ? 'selected' : ''; ?>>Ascending</option>
                <option value="?sort_by=severity&sort=desc" <?php echo $sort_by === 'severity' && $sort_order === 'desc' ? 'selected' : ''; ?>>Descending</option>
            </select>
        </div>
        <div>
            <label for="sort-escalation">Sort by Escalation:</label>
            <select class="table-sort" id="sort-escalation" onchange="location = this.value;">
                <option value="?sort_by=escalation&sort=asc" <?php echo $sort_by === 'escalation' && $sort_order === 'asc' ? 'selected' : ''; ?>>Ascending</option>
                <option value="?sort_by=escalation&sort=desc" <?php echo $sort_by === 'escalation' && $sort_order === 'desc' ? 'selected' : ''; ?>>Descending</option>
            </select>
        </div>
    </div>
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
                            <td>
                                <?php
                                // Get the ticket creation date and current time
                                $dateTimeCreated = strtotime($row['date_time_created']);
                                $currentTime = time();

                                // Calculate the difference in seconds
                                $timeDifference = $currentTime - $dateTimeCreated;

                                // Convert time difference to human-readable format
                                $days = floor($timeDifference / (60 * 60 * 24)); // Days
                                $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60)); // Hours
                                $minutes = floor(($timeDifference % (60 * 60)) / 60); // Minutes

                                // Format the elapsed time
                                $elapsedTime = "";
                                if ($days > 0) {
                                    $elapsedTime .= "$days days ";
                                }
                                if ($hours > 0) {
                                    $elapsedTime .= "$hours hours ";
                                }
                                if ($minutes > 0) {
                                    $elapsedTime .= "$minutes minutes ago";
                                }

                                // If there's no significant difference (less than a minute)
                                if ($elapsedTime == "") {
                                    $elapsedTime = "Just now";
                                }

                                echo $elapsedTime;
                                ?>
                            </td>
                            <td>
                                <button onclick="openModal(<?= $row['id'] ?>)">View</button>
                                <button onclick="updateTicketStatus(<?= $row['id'] ?>)" <?= $role === 'user' ? 'disabled' : '' ?>>Resolved</button>

                                <!-- Escalate button, changes to 'Failed' if escalation is 3 -->
                                <button id="escalate-btn-<?= $row['id'] ?>" onclick="escalateTicketStatus(<?= $row['id'] ?>)"
                                    <?= $role === 'user' ? 'disabled' : '' ?>>
                                    <?php echo $row['escalation'] >= 3 ? 'Failed' : 'Escalate'; ?>
                                </button>
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
                                <p><strong>Escalation Comment:</strong> <?= $row['escalation_reason'] ?></p>
                                <p><strong>Date Created:</strong>
                                    <?php
                                    $formatted_date_time_created = date("m/d/Y h:i A", strtotime($row['date_time_created']));
                                    echo $formatted_date_time_created;
                                    ?>
                                </p>
                                <p><strong>Elapsed Time:</strong> <?= calculateTimeElapsed($row['date_time_updated']) ?></p>
                            </div>
                        </div>
                        <div id="escalation-reason-modal-<?= $row['id'] ?>" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeEscalationModal(<?= $row['id'] ?>)">&times;</span>
                                <h2>Escalation Reason</h2>
                                <form id="escalation-form-<?= $row['id'] ?>" onsubmit="submitEscalationReason(event, <?= $row['id'] ?>)">
                                    <textarea name="escalation_reason" required placeholder="Please provide a detailed reason for the escalation."></textarea>
                                    <button type="submit">Submit</button>
                                </form>
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
            var modal = document.getElementById('escalation-reason-modal-' + ticketId);
            modal.style.display = "block";
        }

        function closeEscalationModal(ticketId) {
            var modal = document.getElementById('escalation-reason-modal-' + ticketId);
            modal.style.display = "none";
        }

        function submitEscalationReason(event, ticketId) {
            event.preventDefault();
            const form = document.getElementById('escalation-form-' + ticketId);
            const escalationReason = form.elements['escalation_reason'].value;
            const ticketRow = document.querySelector(`tr[data-ticket-id='${ticketId}']`);
            const escalationValue = parseInt(ticketRow.querySelector('.escalation').innerText);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update-escalate.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        var sentMessageRow = document.getElementById('sent-message-' + ticketId);
                        var sentMessageCell = sentMessageRow.querySelector('.sent-message');
                        sentMessageCell.innerHTML = "Ticket status updated to " + (escalationValue >= 3 ? 'Failed' : 'Escalated') + ".";
                        sentMessageRow.style.display = 'table-row';

                        const statusCell = ticketRow.querySelector('.t-status');
                        const escalateButton = ticketRow.querySelector(`#escalate-btn-${ticketId}`);

                        statusCell.innerText = escalationValue >= 3 ? 'Failed' : 'Escalated';

                        if (escalationValue >= 3) {
                            escalateButton.innerText = 'Failed';
                            escalateButton.disabled = true;
                        } else {
                            escalateButton.innerText = 'Escalated';
                        }

                        closeEscalationModal(ticketId);

                    } else {
                        console.error("Failed to update ticket status.");
                    }
                }
            };
            xhr.send(`ticketId=${ticketId}&status=${(escalationValue >= 3) ? 'Failed' : 'Escalated'}&escalation_reason=${encodeURIComponent(escalationReason)}`);
        }
    </script>
</body>

</html>