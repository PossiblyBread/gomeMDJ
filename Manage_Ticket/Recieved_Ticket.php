<?php
    include "../db_conn.php";
    // Fetch IT_Users
    session_start();
    $email = $_SESSION['email'];
    
    $it_support_sql = "SELECT id, first_name, last_name, email FROM `accounts` WHERE role = 'Admin'";
    $it_support_result = mysqli_query($conn, $it_support_sql);
    $it_support_users = [];
    while ($row = mysqli_fetch_assoc($it_support_result)) {
        $it_support_users[] = $row;
    }
    $it_support_query = "SELECT a.first_name, a.last_name, a.email, 
                        (SELECT COUNT(*) FROM tickets t WHERE t.assigned_to = a.email) 
                            AS ticket_count 
                         FROM accounts a 
                         WHERE a.role = 'IT_Support'";
    $it_support_result = mysqli_query($conn, $it_support_query);
?>
<!-- admin side to distribute tickets -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management</title>
</head>
<body>
    <?php include '../body/admin/top-nav.php'; ?>

    <div class="main-content">
        <div class="ticket-table-content">
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'NewTickets')" id="defaultOpen">New Tickets</button>
                <button class="tablinks" onclick="openTab(event, 'OpenTickets')">Open Tickets</button>
                <button class="tablinks" onclick="openTab(event, 'PendingTickets')">Pending Tickets</button>
                <button class="tablinks" onclick="openTab(event, 'ActiveTickets')">Active Tickets</button>
                <button class="tablinks" onclick="openTab(event, 'ClosedTickets')">Closed Tickets</button>
            </div>
            <div id="NewTickets" class="tab-content">
                <?php include 'tickets/new_tickets.php'; ?>
            </div>
            <div id="OpenTickets" class="tab-content">
                <?php include 'tickets/open_tickets.php'; ?>
            </div>

            <div id="PendingTickets" class="tab-content">
                <?php include 'tickets/pending_tickets.php'; ?>
            </div>

            <div id="ActiveTickets" class="tab-content">
                <?php include 'tickets/active_tickets.php'; ?>
            </div>

            <div id="ClosedTickets" class="tab-content">
                <?php include 'tickets/closed_tickets.php'; ?>
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

        // Open the default tab (Open Tickets)
        document.getElementById("defaultOpen").click();
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

    .main-content {
        display: flex;
        padding: 20px;
    }

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
        background-color: #f2f2f2;
        border-bottom: 1px solid #ddd;
    }
</style>