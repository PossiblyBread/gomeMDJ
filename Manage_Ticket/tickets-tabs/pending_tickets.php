<?php
$email = $_SESSION['email'];
$role = $_SESSION['role']; // Assuming role is stored in the session

// Check if the user is logged in
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


// If the user is an Admin, fetch all pending tickets. Otherwise, restrict to tickets assigned to the user.
if ($role === 'Admin') {
    $pending_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                            assigned_to, priority, severity, escalation, escalation_reason, date_time_created, date_time_updated 
                            FROM `tickets` 
                            WHERE `t_status` = 'Pending'
                            ORDER BY serial_num $sort_order_sql";
} else {
    $pending_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                            assigned_to, priority, severity, escalation, escalation_reason, date_time_created, date_time_updated 
                            FROM `tickets` 
                            WHERE `t_status` = 'Pending' AND `assigned_to` = '$email'
                           ORDER BY serial_num $sort_order_sql";
}

$pending_tickets_result = mysqli_query($conn, $pending_tickets_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Tickets - <?php echo $email; ?></title>
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }
        .ticket-table {
            border-collapse: collapse;
            width: 100%; 
        }
        .ticket-table th, .ticket-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Pending Tickets</h2>
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
                                <p><strong>Escalation Comment:</strong> <?= $row['escalation_reason'] ?></p>
                                <p><strong>Date Created:</strong>
                                <p>
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
                    const response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        // Update UI with success message and disable the "Accept" button
                        var sentMessageRow = document.getElementById('sent-message-' + ticketId);
                        var sentMessageCell = sentMessageRow.querySelector('.sent-message');
                        var sendButton = document.querySelector(`tr[data-ticket-id='${ticketId}'] button[onclick^='updateTickettoActiveStatus']`);

                        sentMessageCell.innerHTML = "TICKET has been accepted by " + itSupportEmail + "!";
                        sentMessageRow.style.display = 'table-row';
                        sendButton.disabled = true; // Disable button after action
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            };

            xhr.send(`ticketId=${ticketId}&itSupportEmail=${itSupportEmail}`);
        }
    </script>
</body>
</html>
