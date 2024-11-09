<?php
include "../db_conn.php";
session_start();

// Fetch the logged-in user's role
$email = $_SESSION['email'];
$user_role_query = "SELECT role FROM accounts WHERE email = '$email'";
$user_role_result = mysqli_query($conn, $user_role_query);
$user_role_row = mysqli_fetch_assoc($user_role_result);
$user_role = $user_role_row['role'];

// Fetch IT Support users
$it_support_query = "SELECT a.first_name, a.last_name, a.email, 
                    (SELECT COUNT(*) FROM tickets t WHERE t.assigned_to = a.email) 
                        AS ticket_count 
                     FROM accounts a 
                     WHERE a.role = 'IT_Support'";
$it_support_result = mysqli_query($conn, $it_support_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management</title>
</head>
<body>
    <?php include '../Admin/top-nav.php'; ?>

    <div class="main-content">
        <div class="ticket-table-content">
            <div class="tab">
                <?php if ($user_role !== 'IT_Support'): ?>
                    <button class="tablinks" onclick="openTab(event, 'NewTickets')" id="defaultOpen">New Tickets</button>
                    <button class="tablinks" onclick="openTab(event, 'OpenTickets')">Open Tickets</button>
                <?php endif; ?>
                <button class="tablinks" onclick="openTab(event, 'PendingTickets')">Pending Tickets</button>
                <button class="tablinks" onclick="openTab(event, 'ActiveTickets')">Active Tickets</button>
                <button class="tablinks" onclick="openTab(event, 'ClosedTickets')">Closed Tickets</button>
            </div>

            <?php if ($user_role !== 'IT_Support'): ?>
                <div id="NewTickets" class="tab-content">
                    <?php include 'tickets-tabs/new_tickets.php'; ?>
                </div>
                <div id="OpenTickets" class="tab-content">
                    <?php include 'tickets-tabs/open_tickets.php'; ?>
                </div>
            <?php endif; ?>

            <div id="PendingTickets" class="tab-content">
                <?php include 'tickets-tabs/pending_tickets.php'; ?>
            </div>
            <div id="ActiveTickets" class="tab-content">
                <?php include 'tickets-tabs/active_tickets.php'; ?>
            </div>
            <div id="ClosedTickets" class="tab-content">
                <?php include 'tickets-tabs/closed_tickets.php'; ?>
            </div>
        </div>

        <div class="account-table-content">
            <h2>IT Support Accounts</h2>
            <table class="account-table">
                <tr>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Tickets Handled</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($it_support_result)): ?>
                <tr>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                    <td><?php echo $row['ticket_count']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;

            // Hide all tab contents
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Remove the active class from all tab buttons
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab's content and add an active class to the button
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        <?php if ($user_role !== 'IT_Support'): ?>
            // If the user is not "IT_Support", open "New Tickets" by default
            document.getElementById("defaultOpen").click();
        <?php else: ?>
            // Otherwise, open "Pending Tickets" by default
            document.querySelector('.tablinks[onclick="openTab(event, \'PendingTickets\')"]').click();
        <?php endif; ?>
    </script>
    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
 
<style>
    /* Style for tab buttons */
    .tab {
        overflow: hidden;
        border-bottom: 1px solid #ccc;
    }

    .tab button {
        background-color: inherit;
        border: none;
        padding: 14px 20px;
        cursor: pointer;
        font-size: 17px;
        transition: background-color 0.3s ease;
    }

    .tab button:hover {
        background-color: #ddd;
    }

    .tab button.active {
        background-color: #ccc;
    }

    .tab-content {
        display: none;
        padding: 20px;
        border: 1px solid #ccc;
        border-top: none;
    }
    /* end for tabs style */

    .main-content {
        display: flex;
        padding: 20px;
        margin-top: -60px; 
    }

    /* style for ticket table and accounts table contents and position */
    .ticket-table-content {
        width: 60%;
        margin-right: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .account-table-content {
        width: 35%;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .ticket-table, .account-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .ticket-table th, .ticket-table td, .account-table th, .account-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .ticket-table th, .account-table th {
        background-color: #f2f2f2;
    }

    .ticket-table tr:hover, .account-table tr:hover {
        background-color: #f5f5f5;
    }

    h2 {
        padding: 15px;
        margin: 0;
        border-bottom: 1px solid #ddd;
    }
    /* end */
</style>
