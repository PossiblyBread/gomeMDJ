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
$sort_order_sql = ($sort_order === 'desc') ? 'DESC' : 'ASC';

$new_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                    priority, severity, escalation, date_time_created, date_time_updated 
                    FROM `tickets` WHERE `t_status` = 'new' 
                    ORDER BY serial_num $sort_order_sql";
$new_tickets_result = mysqli_query($conn, $new_tickets_sql);

// Function to format date in 12-hour format
function formatDateTime($dateTime) {
    $date = new DateTime($dateTime);
    return $date->format('m/d/Y h:i A'); // Format: MM/DD/YYYY HH:MM AM/PM
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Tickets</title>
    <style>
        .table-container {
            overflow-x: auto; 
            width: 100%;
        }
        .ticket-table {
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td {
            padding: 8px; 
            border: 1px solid #ccc; 
        }
        
    </style>
</head>
<body>
    <h2>New Tickets</h2>
    
    <!-- Sorting Combo Box -->
    <div class="container" id="new">
        <label for="sort-options">Sort by Serial Number:</label>
        <select class="table-sort" id="sort-options" onchange="location = this.value;">
            <option value="?sort=asc" <?php echo $sort_order === 'asc' ? 'selected' : ''; ?>>Ascending</option>
            <option value="?sort=desc" <?php echo $sort_order === 'desc' ? 'selected' : ''; ?>>Descending</option>
        </select>
    </div>
    
    <div class="table-container">
        <table class="ticket-table">
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th style="display:none;">First Name</th>
                    <th style="display:none;">Last Name</th>
                    <th>Phone Number</th>
                    <th>Type</th>
                    <th>Ticket Status</th>
                    <th>Priority</th>
                    <th>Severity</th>
                    <th style="display:none;">Escalation</th>
                    <th style="display:none;">Description</th>
                    <th>Date-Time Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($new_tickets_result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($new_tickets_result)): ?>
                        <tr data-ticket-id="<?php echo htmlspecialchars($row['id']); ?>">
                            <td class="serial-num"><?php echo htmlspecialchars($row['serial_num']); ?></td>
                            <td class="first-name" style="display:none;"><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td class="last-name" style="display:none;"><?php echo htmlspecialchars($row['last_name']); ?></td>
                            <td class="phone-num"><?php echo htmlspecialchars($row['phone_num']); ?></td>
                            <td class="type"><?php echo htmlspecialchars($row['type']); ?></td>
                            <td class="t-status"><?php echo htmlspecialchars($row['t_status']); ?></td>
                            <td class="priority-"><?php echo htmlspecialchars($row['priority']); ?></td>
                            <td class="severity-"><?php echo htmlspecialchars($row['severity']); ?>
                                <select id="severity-<?php echo $row['id']; ?>">
                                    <option value="4" <?php echo $row['severity'] == 4 ? 'selected' : ''; ?>>4 - Low</option>
                                    <option value="3" <?php echo $row['severity'] == 3 ? 'selected' : ''; ?>>3 - Medium</option>
                                    <option value="2" <?php echo $row['severity'] == 2 ? 'selected' : ''; ?>>2 - High</option>
                                    <option value="1" <?php echo $row['severity'] == 1 ? 'selected' : ''; ?>>1 - Critical</option>
                                </select>
                            </td>
                            <td class="escalation" style="display:none;"><?php echo htmlspecialchars($row['escalation']); ?></td>
                            <td class="description" style="display:none;"><?php echo htmlspecialchars($row['description']); ?></td>
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
                                <button onclick="openModal('<?php echo $row['id']; ?>')">View</button>
                                <button onclick="updateTicket(<?php echo $row['id']; ?>)">Update</button>
                            </td>
                        </tr>
                        <tr id="sent-message-<?php echo $row['id']; ?>" style="display:none;">
                            <td colspan="11" style="text-align:center; color: green;" class="sent-message"></td>
                        </tr>
                        <div id="modal-<?php echo $row['id']; ?>" class="modal">
                            <div class="modal-content">
                                <h2>Ticket Details</h2>
                                <p><strong>Serial Number:</strong> <?php echo htmlspecialchars($row['serial_num']); ?></p>
                                <p><strong>First Name:</strong> <?php echo htmlspecialchars($row['first_name']); ?></p>
                                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($row['last_name']); ?></p>
                                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['phone_num']); ?></p>
                                <p><strong>Type:</strong> <?php echo htmlspecialchars($row['type']); ?></p>
                                <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($row['t_status']); ?></p>
                                <p><strong>Date Created:</strong> <?php echo formatDateTime($row['date_time_created']); ?></p>
                                <p><strong>Elapsed Time:</strong> <?php echo calculateTimeElapsed($row['date_time_created']); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11">No new tickets found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function openModal(ticketId) {
            document.getElementById('modal-' + ticketId).style.display = 'block';
        }

        function closeModal(ticketId) {
            document.getElementById('modal-' + ticketId).style.display = 'none';
        }

        function updateTicket(ticketId) {
            var severity = document.getElementById('severity-' + ticketId).value;

            // AJAX request to send the update to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update-sla.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Check for success and show the message
                    var sentMessageRow = document.getElementById('sent-message-' + ticketId);
                    var sentMessageCell = sentMessageRow.querySelector('.sent-message');
                    sentMessageCell.innerHTML = "Ticket updated successfully!";
                    sentMessageRow.style.display = 'table-row';
                }
            };
            xhr.send("ticketId=" + ticketId + "&severity=" + severity);
        }

        window.onclick = function(event) {
            const modals = document.getElementsByClassName('modal');
            for (let i = 0; i < modals.length; i++) {
                if (event.target === modals[i]) {
                    closeModal(modals[i].id.split('-')[1]);
                }
            }
        }
    </script>
</body>
</html>