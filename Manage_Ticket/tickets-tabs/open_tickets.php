<?php
$email = $_SESSION['email'];
$role = $_SESSION['role']; // Assuming role is stored in session

// If the user is an Admin, fetch all tickets with "Open" or "Escalated" status. Otherwise, restrict to assigned tickets.
if ($role === 'Admin') {
    $open_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                        priority, severity, escalation, date_time_created, date_time_updated 
                        FROM `tickets` 
                        WHERE `t_status` IN ('Open', 'Escalated')";
} else {
    $open_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                        priority, severity, escalation, date_time_created, date_time_updated 
                        FROM `tickets` 
                        WHERE `t_status` IN ('Open', 'Escalated') AND `assigned_to` = '$email'";
}
$open_tickets_result = mysqli_query($conn, $open_tickets_sql);

$it_support_query = "SELECT first_name, last_name, email FROM accounts WHERE role = 'IT_Support'";
$it_support_result_set = mysqli_query($conn, $it_support_query);

$it_support_staff = []; // Renamed array to store IT Support users
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
        .table-container {
            overflow-x: auto; 
            max-width: 100%;
        }
        table {
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td {
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
    <h2>New Tickets</h2>
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
                                // Format date_time_created to 12-hour format
                                $formatted_date_time_created = date("m/d/Y h:i A", strtotime($row['date_time_created']));
                                echo $formatted_date_time_created;
                            ?>
                        </td>
                        <td>
                            <button onclick="openModal('<?= $row['id'] ?>')">View</button>
                            <select id="it-support-<?= $row['id'] ?>" style="display:inline;">
                                <option value="" disabled selected>Select IT Support</option>
                                <?php foreach ($it_support_staff as $it_row): ?> <!-- Updated variable here -->
                                    <option value="<?= $it_row['email'] ?>"><?= $it_row['first_name'] ?> <?= $it_row['last_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button onclick="sendTicket('<?= $row['id'] ?>')">Send</button>
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

    <script>
        // JavaScript functions remain the same
        function openModal(ticketId) {
            document.getElementById('modal-' + ticketId).style.display = 'block';
        }

        function closeModal(ticketId) {
            document.getElementById('modal-' + ticketId).style.display = 'none';
        }

        function sendTicket(ticketId) {
            var itSupportEmail = document.getElementById('it-support-' + ticketId).value;
            if (!itSupportEmail) {
                alert("Please select an IT Support person.");
                return;
            }

            // Fetching additional ticket details
            var serialNum = document.querySelector(`tr[data-ticket-id='${ticketId}'] .serial-num`).innerText;
            var phoneNum = document.querySelector(`tr[data-ticket-id='${ticketId}'] .phone-num`).innerText;
            var type = document.querySelector(`tr[data-ticket-id='${ticketId}'] .type`).innerText;
            var description = document.querySelector(`tr[data-ticket-id='${ticketId}'] .description`).innerText;
            var priority = document.querySelector(`tr[data-ticket-id='${ticketId}'] .priority`).innerText; // Get priority
            var severity = document.querySelector(`tr[data-ticket-id='${ticketId}'] .severity`).innerText; // Get severity
            var escalation = document.querySelector(`tr[data-ticket-id='${ticketId}'] .escalation`).innerText; // Get escalation

            // Get first and last name from the row
            var firstName = document.querySelector(`tr[data-ticket-id='${ticketId}'] .first-name`).innerText;
            var lastName = document.querySelector(`tr[data-ticket-id='${ticketId}'] .last-name`).innerText;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_ticket.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var sentMessageRow = document.getElementById('sent-message-' + ticketId);
                    var sendButton = document.querySelector(`tr[data-ticket-id='${ticketId}'] button:nth-of-type(2)`);
                    
                    // Show confirmation message
                    sentMessageRow.style.display = 'table-row';
                    sentMessageRow.innerHTML = `<td colspan="11">Ticket sent to ${itSupportEmail} for resolution.</td>`;
                    
                    // Disable send button after sending
                    sendButton.disabled = true;

                    // Hide modal
                    closeModal(ticketId);
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
</html>
