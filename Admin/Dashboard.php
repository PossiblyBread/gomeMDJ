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
    <style>
        body {
            background-color: #d1dae1;
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
    </style>
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

    <script>
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
    </script>
</body>

</html>