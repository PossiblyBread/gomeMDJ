<?php
include "../db_conn.php";

// Fetch all new tickets from the database
$new_tickets_sql = "SELECT id, serial_num, first_name, last_name, phone_num, type, description, t_status, date_time FROM `tickets` WHERE `t_status` = 'new'";
$new_tickets_result = mysqli_query($conn, $new_tickets_sql);

// Fetch all IT Support accounts for the dropdown
$it_support_sql = "SELECT id, first_name, last_name, email FROM `accounts` WHERE role = 'IT_Support'";
$it_support_result = mysqli_query($conn, $it_support_sql);
$it_support_users = [];
while ($row = mysqli_fetch_assoc($it_support_result)) {
    $it_support_users[] = $row;
}

// Fetch IT Support accounts and ticket count
$it_support_query = "
    SELECT a.first_name, a.last_name, a.email, 
           (SELECT COUNT(*) FROM ticket_assigned t WHERE t.assigned_to_email = a.email) AS ticket_count 
    FROM accounts a 
    WHERE a.role = 'IT_Support'
";
$it_support_result = mysqli_query($conn, $it_support_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Container for tables */
        .main-content {
            display: flex; /* Enable flexbox for layout */
            padding: 20px; /* Add padding around the main content */
        }

        /* Style for the ticket table */
        .ticket-table-content {
            width: 60%; /* Set width for ticket table */
            margin-right: 20px; /* Margin to the right of the ticket table */
            border: 1px solid #ddd; /* Optional border around the table */
            border-radius: 8px; /* Optional border radius */
            overflow: hidden; /* To round the corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Optional shadow */
        }

        /* Style for the account table */
        .account-table-content {
            width: 35%; /* Set width for account table */
            border: 1px solid #ddd; /* Optional border around the table */
            border-radius: 8px; /* Optional border radius */
            overflow: hidden; /* To round the corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Optional shadow */
            /* Allow the height to be dynamic and not forced to match the ticket table */
        }

        .ticket-table, .account-table {
            width: 100%; /* Set width of tables to full width of their containers */
            border-collapse: collapse; /* Collapse borders for cleaner look */
            margin-bottom: 20px; /* Margin below the tables */
        }

        .ticket-table th, .ticket-table td, .account-table th, .account-table td {
            border: 1px solid #ddd; /* Add border to table cells */
            padding: 8px; /* Padding for table cells */
            text-align: left; /* Align text to the left */
        }

        .ticket-table th, .account-table th {
            background-color: #f2f2f2; /* Light gray background for headers */
        }

        .ticket-table tr:hover, .account-table tr:hover {
            background-color: #f5f5f5; /* Highlight row on hover */
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 500px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Padding for h2 elements */
        h2 {
            padding: 15px; /* Adjust the padding as needed */
            margin: 0; /* Reset margin for consistency */
            background-color: #f2f2f2; /* Optional background color */
            border-bottom: 1px solid #ddd; /* Optional bottom border */
        }
    </style>
</head>
<body>
    <?php include '../body/admin/top-nav.php'; ?>
    <div class="main-content">
        <div class="ticket-table-content">
            <h2>New Tickets</h2>
            <table class="ticket-table">
                <tr>
                    <th>Serial Number</th>
                    <th style="display:none;">First Name</th>
                    <th style="display:none;">Last Name</th>
                    <th>Phone Number</th>
                    <th>Type</th>
                    <th>Ticket Status</th>
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
                            <td class="description" style="display:none;"><?= $row['description'] ?></td>
                            <td><?= $row['date_time'] ?></td>
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
                            <td colspan="9" style="text-align:center; color: green;" class="sent-message"></td>
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
                                <p><strong>Date Created:</strong> <?= $row['date_time'] ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No new tickets found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="account-table-content">
            <h2>IT Support Accounts</h2>
            <table class="account-table">
                <tr>
                    <th>Full Name</th>
                    <th>Tickets Count</th>
                </tr>

                <?php
                if (mysqli_num_rows($it_support_result) > 0) {
                    while ($row = mysqli_fetch_assoc($it_support_result)) {
                        echo "<tr>
                            <td>{$row['first_name']} {$row['last_name']}</td>
                            <td>{$row['ticket_count']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No IT Support accounts found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>

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

            // Get first and last name from the row
            var firstName = document.querySelector(`tr[data-ticket-id='${ticketId}'] .first-name`).innerText;
            var lastName = document.querySelector(`tr[data-ticket-id='${ticketId}'] .last-name`).innerText;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "send_ticket.php", true);
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
            xhr.send("ticketId=" + ticketId + "&serialNum=" + serialNum + "&firstName=" + firstName + "&lastName=" + lastName + "&phoneNum=" + phoneNum + "&type=" + type + "&description=" + encodeURIComponent(description) + "&itSupportEmail=" + itSupportEmail);
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
