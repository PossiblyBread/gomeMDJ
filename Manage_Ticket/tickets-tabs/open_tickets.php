<?php
$email = $_SESSION['email'];
$role = $_SESSION['role']; // Assuming role is stored in session

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

// If the user is an Admin, fetch all tickets with "Open" or "Escalated" status. Otherwise, restrict to assigned tickets.
if ($role === 'Admin') {
    $open_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                        priority, severity, escalation, escalation_reason, date_time_created, date_time_updated 
                        FROM `tickets` 
                        WHERE `t_status` IN ('Open', 'Escalated')
                        ORDER BY $order_by_sql";
} else {
    $open_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                        priority, severity, escalation, escalation_reason, date_time_created, date_time_updated 
                        FROM `tickets` 
                        WHERE `t_status` IN ('Open', 'Escalated') AND `assigned_to` = '$email'
                        ORDER BY $order_by_sql";
}

$open_tickets_result = mysqli_query($conn, $open_tickets_sql);

// Fetch IT Support staff
$it_support_query = "SELECT first_name, last_name, email, assigned_department FROM accounts WHERE role = 'IT_Support'";
$it_support_result_set = mysqli_query($conn, $it_support_query);

$it_support_staff = []; // Array to store IT Support users
if (mysqli_num_rows($it_support_result_set) > 0) {
    while ($it_support_row = mysqli_fetch_assoc($it_support_result_set)) {
        $it_support_staff[] = $it_support_row; // Store IT Support users in an array
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Tickets</title>
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 100px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 200px;
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

        .table-container {
            overflow-x: auto;
            max-width: 100%;
        }

        .ticket-table {
            width: 100%;
            border-collapse: collapse;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Open Tickets</h2>
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

    <div class="table-container">
        <table class="ticket-table">
            <tr>
                <th>Serial Number</th>
                <th style="display:none;">First Name</th>
                <th style="display:none;">Last Name</th>
                <th>Phone Number</th>
                <th>Type</th>
                <th>Ticket Status</th>
                <th>Priority</th> <!-- Added Priority -->
                <th>Severity</th> <!-- Added Severity -->
                <th>Escalation</th> <!-- Added Escalation -->
                <th style="display:none;">Description</th>
                <th>Date-Time Created</th>
                <th>Actions</th>
            </tr>
            <?php if (mysqli_num_rows($open_tickets_result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($open_tickets_result)): ?>
                    <tr data-ticket-id="<?= $row['id'] ?>">
                        <td class="serial-num"><?= $row['serial_num'] ?></td>
                        <td class="first-name" style="display:none;"><?= $row['first_name'] ?></td>
                        <td class="last-name" style="display:none;"><?= $row['last_name'] ?></td>
                        <td class="phone-num"><?= $row['phone_num'] ?></td>
                        <td class="type"><?= $row['type'] ?></td>
                        <td class="t-status"><?= $row['t_status'] ?></td>
                        <td class="priority"><?= $row['priority'] ?></td> <!-- Added Priority -->
                        <td class="severity"><?= $row['severity'] ?></td> <!-- Added Severity -->
                        <td class="escalation"><?= $row['escalation'] ?></td> <!-- Added Escalation -->
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
                            if ($elapsedTime == "") {
                                $elapsedTime = "Just now";
                            }

                            echo $elapsedTime;
                            ?>
                        </td>
                        <td>
                            <select id="it-support-<?= $row['id'] ?>" style="display:inline;">
                                <option value="" disabled selected>Select IT Support</option>
                                <?php
                                if ($row['type'] == 'Assistance Request') {
                                    $row['type'] = 'Assistance';  // Modify type if necessary
                                }
                                $ticket_type = $row['type'];

                                // If the user is an Admin, show their email as an option
                                if ($role === 'Admin'): ?>
                                    <option value="<?= $_SESSION['email'] ?>"><?= $_SESSION['email'] ?></option>
                                <?php endif; ?>
                                <?php

                                $ticket_type = $row['type'];
                                foreach ($it_support_staff as $it_row):
                                    // Only show IT Support members whose department matches the ticket type
                                    if ($it_row['assigned_department'] == $ticket_type): ?>
                                        <option value="<?= $it_row['email'] ?>"><?= $it_row['first_name'] ?> <?= $it_row['last_name'] ?></option>
                                <?php endif;
                                endforeach; ?>
                            </select>
                            <button onclick="openPasswordModal('<?= $row['id'] ?>')">Send</button>
                        </td>
                    </tr>
                    <tr id="sent-message-<?= $row['id'] ?>" style="display:none;">
                        <td colspan="11" style="text-align:center; color: green;" class="sent-message"></td>
                    </tr>
                    <div id="modal-<?= $row['id'] ?>" class="modal">
                        <div class="modal-content">
                            <h2>Ticket Details</h2>
                            <p><strong>Serial Number:</strong> <?= $row['serial_num'] ?></p>
                            <p><strong>First Name:</strong> <?= $row['first_name'] ?></p>
                            <p><strong>Last Name:</strong> <?= $row['last_name'] ?></p>
                            <p><strong>Phone Number:</strong> <?= $row['phone_num'] ?></p>
                            <p><strong>Type:</strong> <?= $row['type'] ?></p>
                            <p><strong>Description:</strong> <?= $row['description'] ?></p>
                            <p><strong>Status:</strong> <?= $row['t_status'] ?></p>
                            <p><strong>Priority:</strong> <?= $row['priority'] ?></p>
                            <p><strong>Severity:</strong> <?= $row['severity'] ?></p>
                            <p><strong>Escalation:</strong> <?= $row['escalation'] ?></p>
                            <p><strong>Escalation Comment:</strong> <?= $row['escalation_reason'] ?></p>
                            <p><strong>Date Created:</strong>
                                <?php
                                $formatted_date_time_created = date("m/d/Y h:i A", strtotime($row['date_time_created']));
                                echo $formatted_date_time_created;
                                ?>
                            </p>
                            <p><strong>Elapsed Time:</strong> <?= calculateTimeElapsed($row['date_time_created']) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">No Open tickets found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <!-- Password Modal -->
    <div id="password-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePasswordModal()">&times;</span>
            <h2>Enter Password</h2>
            <input type="password" id="password-input" placeholder="Enter admin password">
            <button onclick="validatePassword()">Submit</button>
            <p id="password-error" style="color: red; display: none;">Incorrect password. Please try again.</p>
        </div>
    </div>
    <script>
        // JavaScript functions remain the same
        function openModal(ticketId) {
            document.getElementById('modal-' + ticketId).style.display = 'block';
        }

        function closeModal(ticketId) {
            document.getElementById('modal-' + ticketId).style.display = 'none';
        }

        // Open the password modal when the "Send" button is clicked
        function openPasswordModal(ticketId) {
            document.getElementById('password-modal').style.display = 'block';
            // Store the ticket ID for later use in validation
            window.currentTicketId = ticketId;
        }

        // Close the password modal
        function closePasswordModal() {
            document.getElementById('password-modal').style.display = 'none';
        }

        // Validate the password input
        function validatePassword() {
            var password = document.getElementById('password-input').value;
            var correctPassword = 'admin1234'; // Predefined password
            if (password === correctPassword) {
                // Close the modal and proceed to send the ticket
                closePasswordModal();
                sendTicket(window.currentTicketId);
            } else {
                // Show error message for incorrect password
                document.getElementById('password-error').style.display = 'block';
            }
        }

        // Function to send the ticket (unchanged)
        function sendTicket(ticketId) {
            var itSupportEmail = document.getElementById('it-support-' + ticketId).value;
            if (!itSupportEmail) {
                alert("Please select an IT Support person.");
                return;
            }

            var serialNum = document.querySelector(`tr[data-ticket-id='${ticketId}'] .serial-num`).innerText;
            var phoneNum = document.querySelector(`tr[data-ticket-id='${ticketId}'] .phone-num`).innerText;
            var type = document.querySelector(`tr[data-ticket-id='${ticketId}'] .type`).innerText;
            var description = document.querySelector(`tr[data-ticket-id='${ticketId}'] .description`).innerText;
            var priority = document.querySelector(`tr[data-ticket-id='${ticketId}'] .priority`).innerText;
            var severity = document.querySelector(`tr[data-ticket-id='${ticketId}'] .severity`).innerText;
            var escalation = document.querySelector(`tr[data-ticket-id='${ticketId}'] .escalation`).innerText;
            var firstName = document.querySelector(`tr[data-ticket-id='${ticketId}'] .first-name`).innerText;
            var lastName = document.querySelector(`tr[data-ticket-id='${ticketId}'] .last-name`).innerText;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_ticket.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var sentMessageRow = document.getElementById('sent-message-' + ticketId);
                    var sendButton = document.querySelector(`tr[data-ticket-id='${ticketId}'] button`);

                    // Show confirmation message
                    sentMessageRow.style.display = 'table-row';
                    sentMessageRow.innerHTML = `<td colspan="8">Ticket sent to ${itSupportEmail} for resolution.</td>`;

                    // Disable send button after sending
                    sendButton.disabled = true;
                }
            };
            xhr.send("ticketId=" + ticketId + "&itSupportEmail=" + itSupportEmail +
                "&serialNum=" + encodeURIComponent(serialNum) +
                "&phoneNum=" + encodeURIComponent(phoneNum) +
                "&type=" + encodeURIComponent(type) +
                "&description=" + encodeURIComponent(description) +
                "&priority=" + encodeURIComponent(priority) +
                "&severity=" + encodeURIComponent(severity) +
                "&escalation=" + encodeURIComponent(escalation) +
                "&firstName=" + encodeURIComponent(firstName) +
                "&lastName=" + encodeURIComponent(lastName));
        }

        // Function to calculate elapsed time
        function calculateTimeElapsed(dateTimeCreated) {
            var now = new Date();
            var createdTime = new Date(dateTimeCreated);
            var elapsed = now - createdTime; // Time in milliseconds

            var seconds = Math.floor(elapsed / 1000);
            var minutes = Math.floor(seconds / 60);
            var hours = Math.floor(minutes / 60);
            var days = Math.floor(hours / 24);

            if (days > 0) return days + " days ago";
            if (hours > 0) return hours + " hours ago";
            if (minutes > 0) return minutes + " minutes ago";
            return seconds + " seconds ago";
        }
    </script>
</body>