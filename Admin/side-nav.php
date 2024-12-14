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
</head>
<body>
    <nav class="left-navbar">
        <img src="../Images/Logo-dark.png" alt="Logo" class="logo">
        <hr>

        <ul>
            <li><a href="Dashboard.php"><img src="../Icons_SVG_repository/Dashboard.svg" alt="Dashboard">Dashboard</a></li>
            <li><a href="Account_Manager.php"><img src="../Icons_SVG_repository/userAccountData.svg" alt="Users">Users</a></li>
            <li><a href="order_entry.php"><img src="../Icons_SVG_repository/orderEntry.svg" alt="New Order">New Order</a></li>
            <li><a href="Ledger.php"><img src="../Icons_SVG_repository/Ledger.svg" alt="Ledger">Ledger</a></li>
            <li><a href="../Manage_Ticket/Recieved_Ticket.php"><img src="../Icons_SVG_repository/Tickets.svg" alt="Tickets">Tickets</a></li>
            <li><a href="userFeedback.php"><img src="../Icons_SVG_repository/feedback.svg" alt="Users">Feedback</a></li>
            <li><a href="Analytics.php"><img src="../Icons_SVG_repository/analytics.svg" alt="Users">Analytics</a></li>
            <li><a href="" id="custom-logout-button"><img src="../Icons_SVG_repository/Logout.svg" alt="Log Out">Log Out</a></li>
        </ul>
    </nav>

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
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0; 
    display: flex;
}
/* left nav design */
.left-navbar {
    width: 150px;
    background-color: #d1dae1;
    height: 100vh;
    padding: 10px 0;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
    z-index: 10000;
    text-align: center;
}

.left-navbar .logo {
    width: 70%;  
    height: auto;
    margin: -10px auto;
    padding: 5px 0;  
    display: block;  
}

.left-navbar hr {
    border: none;
    height: 1.75px;
    background-color: #01344C;
    margin: 0;
    width: 80%;
    margin-left: auto;
    margin-right: auto;
    border-radius: 2px;
}

.left-navbar ul {
    list-style-type: none;
    padding: 0;
}

.left-navbar li {
    margin: 10px 0;
    border-radius: 5px;
}

.left-navbar a {
    text-decoration: none;
    color: #01344C;
    padding: 8px 10px;
    display: flex;
    align-items: center;
    font-size: 14px;
    transition: background-color 0.3s, color 0.3s, transform 0.2s;  /* Added transform transition */
    white-space: nowrap;
}

.left-navbar a:hover {
    background-color: #BDDADB;
    color: #01344C;
    border-radius: 5px;
}
.left-navbar img {
    width: 32px;
    height: auto;
    margin-right: 10px;
    vertical-align: middle;
    cursor: pointer;
}

/* log out style */
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

#confirm-logout-btn {
    background-color: #7a7a7a;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
}

#confirm-logout-btn:hover {
    background-color: #555;
}

.cancel-logout-btn {
    background-color: #9e9e9e;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
}

.cancel-logout-btn:hover {
    background-color: #777;
}
</style>
