<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class="right-navbar">
        <ul>
            <li><a href="../Admin/Dashboard.php">Dashboard</a></li>
            <li><a href="../Admin/Ledger.php">Ledger</a></li>
            <li><a href="../Admin/upload_product.php">Add new Product</a></li>
            <li><a href="../Admin/order_entry.php">Create new Order</a></li>
            <li><a href="../Admin/Account_Manager.php">User Account Data</a></li>
            <li><a href="../Manage_Ticket/Recieved_Ticket.php">Tickets</a></li>
            <li><a href="#" id="logout-button">Log Out</a></li>
        </ul>
    </nav>

    <div id="logout-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="close-logout-modal">&times;</span>
            <h2>Log Out</h2>
            <p>Are you sure you want to log out?</p>
            <form id="logout-form" action="../logout.php" method="post">
                <div class="modal-buttons">
                    <button type="submit" id="confirm-logout">Confirm</button>
                    <button type="button" class="cancel-btn" id="cancel-logout">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Get modal element
        var adminLogoutModal = document.getElementById('logout-modal');
        var adminLogoutButton = document.getElementById('logout-button');
        var adminCloseModal = document.getElementById('close-logout-modal');
        var adminCancelLogout = document.getElementById('cancel-logout');

        // Show the modal when logout button is clicked
        adminLogoutButton.onclick = function() {
            adminLogoutModal.style.display = 'block';
        }

        // Close the modal when the close button is clicked
        adminCloseModal.onclick = function() {
            adminLogoutModal.style.display = 'none';
        }

        // Close the modal when the cancel button is clicked
        adminCancelLogout.onclick = function() {
            adminLogoutModal.style.display = 'none';
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == adminLogoutModal) {
                adminLogoutModal.style.display = 'none';
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
        display: flex; /* Use flex to align navbar and content */
    }

    /* Styling for the fixed navigation bar */
    .right-navbar {
        width: 250px; /* Width of the side navigation */
        background-color: #333; /* Dark gray background */
        height: 100vh; /* Full height */
        padding: 20px 0; /* Padding */
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5); /* Shadow for depth */
        position: fixed; /* Fixed position */
        top: 0; /* Align to the top */
        right: 0; /* Align to the right */
        overflow-y: auto; /* Scroll if content overflows */
    }

    .right-navbar ul {
        list-style-type: none; /* Remove default list style */
        padding: 0; /* Remove padding */
    }

    .right-navbar li {
        margin: 15px 0; /* Margin between list items */
    }

    .right-navbar a {
        text-decoration: none; /* Remove underline from links */
        color: #f0f0f0; /* Light gray text color */
        padding: 10px 15px; /* Padding for better click area */
        display: block; /* Make link fill the whole list item */
        transition: background-color 0.3s; /* Smooth transition for hover effect */
    }

    .right-navbar a:hover {
        background-color: #555; /* Darker gray on hover */
        border-radius: 5px; /* Slightly rounded corners on hover */
    }

    /* Modal styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1000; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.5); /* Slightly darker background with transparency */
    }

    .modal-content {
        background-color: #e0e0e0; /* Light gray background for modal */
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px; /* Padding inside the modal */
        border: 1px solid #bbb; /* Light gray border */
        width: 300px; /* Width of the modal */
        border-radius: 8px; /* Rounded corners */
        color: #333; /* Dark gray text color for better contrast */
    }

    .close-btn {
        color: #666; /* Medium gray */
        float: right; /* Right align */
        font-size: 28px; /* Font size */
        font-weight: bold; /* Bold text */
    }

    .close-btn:hover,
    .close-btn:focus {
        color: #444; /* Darker gray on hover */
        text-decoration: none; /* No underline */
        cursor: pointer; /* Pointer cursor */
    }

    /* Modal button styles */
    .modal-buttons {
        display: flex; /* Flexbox for buttons */
        justify-content: space-between; /* Space between buttons */
    }

    #confirm-logout {
        background-color: #7a7a7a; /* Gray background for confirm */
        color: white; /* White text */
        border: none; /* Remove border */
        padding: 10px 15px; /* Padding */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor */
    }

    #confirm-logout:hover {
        background-color: #555; /* Darker gray on hover */
    }

    .cancel-btn {
        background-color: #9e9e9e; /* Light gray background for cancel */
        color: white; /* White text */
        border: none; /* Remove border */
        padding: 10px 15px; /* Padding */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor */
    }

    .cancel-btn:hover {
        background-color: #777; /* Darker gray on hover */
    }
</style>