<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

include_once "../db_conn.php";

// Fetch user details from session
$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$userId = isset($_SESSION['id']) ? $_SESSION['id'] : '';

// Fetch the role from the accounts table
$query = "SELECT role FROM accounts WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($userRole);
$stmt->fetch();
$stmt->close();

// Function to fetch notifications
function fetchNotifications($conn)
{
    $notifications = [];

    // Get added records from accounts (from the last day)
    $addedAccounts = mysqli_query($conn, "SELECT * FROM accounts WHERE date_created >= NOW() - INTERVAL 1 DAY;");
    while ($row = mysqli_fetch_assoc($addedAccounts)) {
        $notificationText = "Added Account: " . htmlspecialchars($row['first_name'] . " " . $row['last_name']) .
            " | " . (new DateTime($row['date_created']))->format('F j, Y');
        array_unshift($notifications, $notificationText); // Add to the beginning of the array
    }

    // Get added records from tickets (from the last day)
    $addedTickets = mysqli_query($conn, "SELECT date_time_created, serial_num, type FROM tickets WHERE date_time_created >= NOW() - INTERVAL 1 DAY;");
    while ($row = mysqli_fetch_assoc($addedTickets)) {
        $formattedDateTime = (new DateTime($row['date_time_created']))->format('F j, Y \a\t g:i A');
        $notificationText = "Ticket ID: " . htmlspecialchars($row['serial_num']) . " | Issue: " . htmlspecialchars($row['type']) . " | " . $formattedDateTime;
        array_unshift($notifications, $notificationText); // Add to the beginning of the array
    }
    return $notifications;
}

$notifications = fetchNotifications($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <?php include 'greetings.php'; ?>
    <?php include 'side-nav.php'; ?>

    <div class="main-content">
        <?php include 'dashboard-contents.php'; ?>
    </div>

    <div class="top-nav">
        <!-- Left Section for Employee -->
        <div class="top-nav-left">
            <?php if ($userRole === 'IT_Support'): ?>
                <span class="employee-label">Employee</span>
            <?php endif; ?>
        </div>

        <!-- Right Section for User Name and Notifications -->
        <div class="top-nav-right">
            <span class="user-name" id="user-name">
                <?php echo htmlspecialchars($userFirstName . ' ' . $userLastName); ?>
            </span>

            <div class="bell-notification-container">
                <button class="bell-notification-button" id="bellNotificationButton">
                    <!-- Replace SVG with the Bell.svg from the repository -->
                    <img src="../Icons_SVG_repository/Bell.svg" alt="Bell Icon" width="20px" height="40px">
                </button>
                <div class="bell-dropdown" id="bellDropdownMenu">
                    <?php if (!empty($notifications)): ?>
                        <?php foreach ($notifications as $notification): ?>
                            <div class="bell-dropdown-item"><?php echo htmlspecialchars($notification); ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="bell-dropdown-item">No notifications</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Success Modal for Upload Success -->
    <div id="SuccessModal" class="SuccessModal">
        <div class="modal-content">
            <span class="close" id="closeSuccessModal">&times;</span>
            <strong>Upload Successful!</strong>
        </div>
    </div>
    <!-- Success Modal for Delete Product -->
    <div id="DeleteSuccessModal" class="SuccessModal">
        <div class="modal-content">
            <span class="close" id="closeDeleteSuccessModal">&times;</span>
            <strong>Product Deleted Successfully!</strong>
        </div>
    </div>
    <!-- Success Modal for Update Success -->
    <div id="UpdateSuccessModal" class="SuccessModal">
        <div class="modal-content">
            <span class="close" id="closeUpdateSuccessModal">&times;</span>
            <strong>Update Successful!</strong>
        </div>
    </div>
    <script>
        // Show the Upload Success Modal
        function SuccessModal() {
            var modal = document.getElementById("SuccessModal");
            modal.style.display = "block";
        }

        // Show the Update Success Modal
        function showUpdateSuccessModal() {
            var modal = document.getElementById("UpdateSuccessModal");
            modal.style.display = "block";
        }

        // Show the Delete Success Modal
        function showDeleteSuccessModal() {
            var modal = document.getElementById("DeleteSuccessModal");
            modal.style.display = "block";
        }

        // Close the modal when the user clicks the 'X'
        document.getElementById("closeSuccessModal").onclick = function() {
            document.getElementById("SuccessModal").style.display = "none";
        }

        document.getElementById("closeDeleteSuccessModal").onclick = function() {
            document.getElementById("DeleteSuccessModal").style.display = "none";
        }

        document.getElementById("closeUpdateSuccessModal").onclick = function() {
            document.getElementById("UpdateSuccessModal").style.display = "none";
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function(event) {
            var successModal = document.getElementById("SuccessModal");
            var deleteSuccessModal = document.getElementById("DeleteSuccessModal");
            var updateSuccessModal = document.getElementById("UpdateSuccessModal");

            if (event.target == successModal) {
                successModal.style.display = "none";
            } else if (event.target == deleteSuccessModal) {
                deleteSuccessModal.style.display = "none";
            } else if (event.target == updateSuccessModal) {
                updateSuccessModal.style.display = "none";
            }
        }

        // JavaScript to toggle dropdown visibility
        document.getElementById("bellNotificationButton").onclick = function(event) {
            event.stopPropagation(); // Prevent the click from propagating to the window
            const dropdown = document.getElementById("bellDropdownMenu");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block"; // Toggle display
        };

        // Close dropdown if clicked outside
        window.onclick = function(event) {
            const dropdown = document.getElementById("bellDropdownMenu");
            if (!event.target.matches('#bellNotificationButton')) {
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                }
            }
        };

        // Check URL parameters to show the correct modal for upload, delete, or update success
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);

            // Show the upload success modal if upload_success is true
            if (urlParams.has('upload_success') && urlParams.get('upload_success') === 'true') {
                SuccessModal();
            }

            // Show the delete success modal if delete_success is true
            if (urlParams.has('delete_success') && urlParams.get('delete_success') === 'true') {
                showDeleteSuccessModal();
            }

            // Show the update success modal if update_success is true
            if (urlParams.has('update_success') && urlParams.get('update_success') === 'true') {
                showUpdateSuccessModal();
            }
        }
    </script>
</body>
</html>
<style>
    body {
        background-color: #d1dae1;
    }
    strong {
        font-weight: bold; /* Ensure it stands out */
        font-size: 18px;   /* Slightly increase the font size */
        color: #000000;       /* Set text color to white */
    }
    /* style for top nav */
    .top-nav {
        display: flex;
        justify-content: space-between;
        /* Space between left and right elements */
        align-items: center;
        background-color: #6e89a0;
        padding: 10px 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999;
    }

    .top-nav-left {
        display: flex;
        align-items: center;
    }

    .top-nav-right {
        display: flex;
        align-items: center;
    }

    .main-content {
        margin: 0;
        width: auto;
    }

    /* style for bell */
    .bell-notification-container {
        position: relative;
        display: inline-block;
        margin: 10px 50px 0 0;
    }

    .bell-notification-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .bell-notification-button svg {
        width: 40px;
        height: 40px;
    }

    .bell-dropdown {
        display: none;
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        z-index: 1;
        margin-top: 5px;
        width: 350px;
        left: -300px;
        max-height: 400px;
        overflow-y: auto;
        border-radius: 15px;
    }

    .bell-dropdown-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #ccc;
    }

    .bell-dropdown-item:last-child {
        border-bottom: none;
    }

    .bell-dropdown-item:hover {
        background-color: #f1f1f1;
    }

    /* end */
    /* name tag design */
    .user-name {
        font-size: 25px;
        padding-right: 15px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }

    .employee-label {
        font-size: 30px;
        color: white;
        margin-left: 150px;
        font-weight: bold;
        text-shadow: 2px 2px 4px black;
    }
    /* Modal Styles */
    .SuccessModal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 999999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }

    .SuccessModal .modal-content {
        background-color: #add8e6; /* Light blue color */
        margin: 300px auto 15% auto; /* Added 200px top margin */
        max-width: 500px;
        padding: 15px;
        border: 2px solid #1b212f;
        width: 80%;
        border-radius: 15px;
        text-align: center;
    }

    .SuccessModal .close {
        margin-top: -10px;
        color: maroon;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .SuccessModal .close:hover,
    .SuccessModal .close:focus {
        color: red;
        text-decoration: none;
        cursor: pointer;
    }
</style>