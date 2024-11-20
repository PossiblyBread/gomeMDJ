<?php
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Modal Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0; 
            display: flex;
            flex-direction: column;
        }

        /* Top navigation styles */
        .top-navbar {
            display: flex;
            align-items: center;
            background-color: #d1dae1; 
            height: 60px;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10000;
        }

        .top-navbar .logo {
            width: 50px;
            height: auto;
        }

        .top-navbar ul {
            list-style-type: none;
            display: flex;
            padding: 0;
            margin: 0;
        }

        .top-navbar li {
            margin: 0 15px;
        }

        .top-navbar a {
            text-decoration: none;
            color: #01344C; 
            padding: 8px 10px;
            display: flex;
            align-items: center;
            font-size: 14px;
            transition: background-color 0.3s, color 0.3s;
            white-space: nowrap;
        }
        /* Top navigation styles */
        .top-navbar a {
            text-decoration: none;
            color: #01344C; 
            padding: 8px 10px;
            display: flex;
            align-items: center;
            font-size: 14px;
            position: relative;
            transition: background-color 0.3s, color 0.3s; 
            white-space: nowrap;
        }

        /* Hover effect with underline animation */
        .top-navbar a:hover {
            background-color: #BDDADB; 
            color: #01344C; 
            border-radius: 5px;
        }

        /* The underline (line animation) */
        .top-navbar a::after {
            content: ""; 
            position: absolute;
            bottom: 0; 
            left: 0;
            width: 0%; 
            height: 2px; 
            background-color: #01344C;
            transition: width 0.3s ease;
        }

        /* On hover, animate the line */
        .top-navbar a:hover::after {
            width: 100%; 
        }

        .top-navbar img {
            width: 32px;
            height: auto;
            margin-right: 5px;
            vertical-align: middle;
            cursor: pointer;
        }

        /* Log out style */
        .custom-logout-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .custom-modal-content {
            background-color: #e0e0e0;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #bbb;
            width: 300px;
            border-radius: 8px;
            color: #333;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
        }

        #confirm-logout-btn, .cancel-logout-btn {
            background-color: #7a7a7a;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        #confirm-logout-btn:hover, .cancel-logout-btn:hover {
            background-color: #555;
        }

        .cancel-logout-btn {
            background-color: #9e9e9e;
        }

        .cancel-logout-btn:hover {
            background-color: #777;
        }

        .content {
            margin-top: 70px; 
            padding: 20px;
            flex: 1; 
        }
        /* log out style end */
    </style>
</head>
<body>
    <nav class="top-navbar">
        <!-- Logo section with link to Home.php -->
        <a href="../User/Home.php">
            <img src="../Images/Logo-dark.png" alt="Logo" class="logo">
        </a>
        <ul>
            <li><a href="../Admin/Dashboard.php"><img src="../Icons_SVG_repository/Dashboard.svg" alt="Dashboard">Dashboard</a></li>
            <li><a href="../Admin/order_entry.php"><img src="../Icons_SVG_repository/orderEntry.svg" alt="New Order">New Order</a></li>
            <li><a href="../Admin/Ledger.php"><img src="../Icons_SVG_repository/Ledger.svg" alt="Ledger">Ledger</a></li>
            <li><a href="../Admin/Account_Manager.php"><img src="../Icons_SVG_repository/userAccountData.svg" alt="Users">Users</a></li>
            <li><a href="../Manage_Ticket/Recieved_Ticket.php"><img src="../Icons_SVG_repository/Tickets.svg" alt="Tickets">Tickets</a></li>
            <li><a href="#" id="custom-logout-button"><img src="../Icons_SVG_repository/Logout.svg" alt="Log Out">Log Out</a></li>
        </ul>
    </nav>

    <div class="content">
        <!-- Main content goes here -->
    </div>

    <!-- Logout Modal -->
    <div id="custom-logout-modal" class="custom-logout-modal">
        <div class="custom-modal-content">
            <h2>Log Out</h2>
            <p>Are you sure you want to log out?</p>
            <form id="custom-logout-form" action="../logout.php" method="post">
                <div class="modal-buttons">
                    <button type="submit" id="confirm-logout-btn">Confirm</button>
                    <button type="button" class="cancel-logout-btn" id="custom-cancel-logout">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Get modal element
        var customLogoutModal = document.getElementById('custom-logout-modal');
        var customLogoutButton = document.getElementById('custom-logout-button');
        var customCancelLogout = document.getElementById('custom-cancel-logout');

        // Show the modal when logout button is clicked
        customLogoutButton.onclick = function(event) {
            event.preventDefault(); // Prevent the default anchor click behavior
            customLogoutModal.style.display = 'block';
        }

        // Close the modal when the cancel button is clicked
        customCancelLogout.onclick = function() {
            customLogoutModal.style.display = 'none';
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === customLogoutModal) {
                customLogoutModal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
