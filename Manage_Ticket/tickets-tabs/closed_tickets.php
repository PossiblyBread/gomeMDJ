<?php
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

$email = mysqli_real_escape_string($conn, $_SESSION['email']); // Escape email to prevent SQL injection
$role = $_SESSION['role']; // Assuming role is stored in session

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


// If the user is an Admin, fetch all closed tickets. Otherwise, restrict to assigned tickets.
if ($role === 'Admin') {
    $closed_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, assigned_to,
                           priority, severity, escalation, escalation_reason, date_time_created, date_time_updated 
                           FROM `tickets` 
                           WHERE `t_status` IN ('Closed', 'Failed')
                           ORDER BY serial_num $sort_order_sql";
} else {
    $closed_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, assigned_to,
                           priority, severity, escalation, escalation_reason, date_time_created, date_time_updated 
                           FROM `tickets` 
                           WHERE `t_status` IN ('Closed', 'Failed') AND `assigned_to` = '$email'
                           ORDER BY serial_num $sort_order_sql";
}

// Run the query to fetch closed tickets
$closed_tickets_result = mysqli_query($conn, $closed_tickets_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Closed Tickets</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
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
        }
        .ticket-table th, .ticket-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left; 
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
    </style>
</head>
<body>
    <h2>Closed Tickets</h2>
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
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th style="display:none;">First Name</th>
                    <th style="display:none;">Last Name</th>
                    <th>Phone Number</th>
                    <th>Type</th>
                    <th>Ticket Status</th>
                    <th>Resolved by</th>
                    <th>Priority</th>
                    <th>Severity</th>
                    <th>Escalation</th>
                    <th style="display:none;">Description</th>
                    <th>Closing Date-Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($closed_tickets_result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($closed_tickets_result)): ?>
                        <tr data-ticket-id="<?= htmlspecialchars($row['id']) ?>">
                            <td class="serial-num"><?= htmlspecialchars($row['serial_num']) ?></td>
                            <td class="first-name" style="display:none;"><?= htmlspecialchars($row['first_name']) ?></td>
                            <td class="last-name" style="display:none;"><?= htmlspecialchars($row['last_name']) ?></td>
                            <td class="phone-num"><?= htmlspecialchars($row['phone_num']) ?></td>
                            <td class="type"><?= htmlspecialchars($row['type']) ?></td>
                            <td class="t-status"><?= htmlspecialchars($row['t_status']) ?></td>
                            <td class="assigned-to"><?= htmlspecialchars($row['assigned_to']) ?></td>
                            <td class="priority"><?= htmlspecialchars($row['priority']) ?></td>
                            <td class="severity"><?= htmlspecialchars($row['severity']) ?></td>
                            <td class="escalation"><?= htmlspecialchars($row['escalation']) ?></td>
                            <td class="description" style="display:none;"><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= calculateTimeElapsed($row['date_time_updated']) ?></td>
                            <td>
                                <button onclick="openModal(<?= $row['id'] ?>)">View</button>
                                <form action="reopen.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($row['id']) ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to reopen this ticket?');">Reopen</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Hidden message for any changes made -->
                        <tr id="sent-message-<?= $row['id'] ?>" style="display:none;">
                            <td colspan="11" style="text-align:center; color: green;" class="sent-message"></td>
                        </tr>

                        <!-- Modal to view ticket details -->
                        <div id="modal-<?= $row['id'] ?>" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal(<?= $row['id'] ?>)">&times;</span>
                                <h2>Ticket Details</h2>
                                <p><strong>Serial Number:</strong> <?= htmlspecialchars($row['serial_num']) ?></p>
                                <p><strong>Full Name:</strong> <?= htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) ?></p>
                                <p><strong>Phone Number:</strong> <?= htmlspecialchars($row['phone_num']) ?></p>
                                <p><strong>Type:</strong> <?= htmlspecialchars($row['type']) ?></p>
                                <p><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></p>
                                <p><strong>Status:</strong> <?= htmlspecialchars($row['t_status']) ?></p>
                                <p><strong>Severity:</strong> <?= htmlspecialchars($row['severity']) ?></p>
                                <p><strong>Escalation:</strong> <?= $row['escalation'] ?></p>
                                <p><strong>Escalation Comment:</strong> <?= $row['escalation_reason'] ?></p>
                                <p><strong>Date Created:</strong>
                                    <?php 
                                        $formatted_date_time_created = date("m/d/Y h:i A", strtotime($row['date_time_created']));
                                        echo $formatted_date_time_created;
                                    ?>
                                </p>
                                <p><strong>Ticket closed time:</strong> <?= calculateTimeElapsed($row['date_time_updated']) ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="13">No Closed tickets found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function openModal(ticketId) {
            var modal = document.getElementById('modal-' + ticketId);
            modal.style.display = "block"; // Show the modal
        }

        function closeModal(ticketId) {
            var modal = document.getElementById('modal-' + ticketId);
            modal.style.display = "none"; // Hide the modal
        }

        // Close modal if clicked outside
        window.onclick = function(event) {
            var modal = document.getElementsByClassName("modal");
            for (var i = 0; i < modal.length; i++) {
                if (event.target == modal[i]) {
                    modal[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
