<?php
    $new_tickets_sql = "SELECT id, first_name, last_name, phone_num, serial_num, type, description, t_status, 
                        priority, severity, escalation, date_time_created, date_time_updated 
                        FROM `tickets` WHERE `t_status` = 'new'";
    $new_tickets_result = mysqli_query($conn, $new_tickets_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Tickets</title>
</head>
<body>
    <h2>New Tickets</h2>
    <table class="ticket-table">
        <tr>
            <th>Serial Number</th>
            <th style="display:none;">First Name</th>
            <th style="display:none;">Last Name</th>
            <th>Phone Number</th>
            <th>Type</th>
            <th>Ticket Status</th>
            <th style="display:none;">>Priority</th> <!-- Added Priority -->
            <th style="display:none;">>Severity</th> <!-- Added Severity -->
            <th style="display:none;">>Escalation</th> <!-- Added Escalation -->
            <th style="display:none;">Description</th>
            <th>Date-Time Created</th>
            <th>Actions</th>
        </tr>
        <?php if (mysqli_num_rows($new_tickets_result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($new_tickets_result)): ?>
                <tr data-ticket-id="<?= $row['id'] ?>">
                    <td class="serial-num"><?= $row['serial_num'] ?></td>
                    <td class="first-name" style="display:none;"><?= $row['first_name'] ?></td>
                    <td class="last-name" style="display:none;"><?= $row['last_name'] ?></td>
                    <td class="phone-num"><?= $row['phone_num'] ?></td>
                    <td class="type"><?= $row['type'] ?></td>
                    <td class="t-status"><?= $row['t_status'] ?></td>
                    <td class="priority" style="display:none;"><?= $row['priority'] ?></td> <!-- Added Priority -->
                    <td class="severity" style="display:none;"><?= $row['severity'] ?></td> <!-- Added Severity -->
                    <td class="escalation" style="display:none;"><?= $row['escalation'] ?></td> <!-- Added Escalation -->
                    <td class="description" style="display:none;"><?= $row['description'] ?></td>
                    <td><?= $row['date_time_created'] ?></td>
                    <td>
                        <button onclick="openModal('<?= $row['id'] ?>')">View</button>
                        <select id="it-support-<?= $row['id'] ?>" style="display:inline;">
                            <option value="" disabled selected>Select IT Support</option>
                            <?php foreach ($it_support_users as $it_row): ?>
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
                        <p><strong>Date Created:</strong> <?= $row['date_time_created'] ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="11">No new tickets found.</td>
            </tr>
        <?php endif; ?>
    </table>

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
                    var sendButton = document.querySelector(`tr[data-ticket-id='${ticketId}'] button[onclick^='sendTicket']`);
                    var sentMessageCell = sentMessageRow.querySelector('.sent-message');
                    sentMessageCell.innerHTML = "TICKET SENT to " + itSupportEmail + "!";
                    sentMessageRow.style.display = 'table-row';
                    sendButton.disabled = true; // Disable send button after sending
                }
            };
            xhr.send("ticketId=" + ticketId + "&serialNum=" + serialNum + "&firstName=" + firstName + "&lastName=" + lastName + "&phoneNum=" + phoneNum + "&type=" + type + "&description=" + encodeURIComponent(description) + "&priority=" + priority + "&severity=" + severity + "&escalation=" + escalation + "&itSupportEmail=" + itSupportEmail);
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
