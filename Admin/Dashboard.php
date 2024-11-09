<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
include_once "../db_conn.php";

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
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
            justify-content: flex-end;
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
        /* end */
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
    </style>
</head>

<body>
    <?php include 'greetings.php'; ?>
    <?php include 'side-nav.php'; ?>

    <div class="main-content">
        <?php include 'dashboard-contents.php'; ?>
    </div>

    <div class="top-nav">
        <span class="user-name" id="user-name">
            <?php echo htmlspecialchars($userFirstName . ' ' . $userLastName); ?>
        </span>
        <div class="bell-notification-container">
            
            <button class="bell-notification-button" id="bellNotificationButton">
                <svg width="20px" height="40px" viewBox="0 0 30.00 30.00" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <title>bell</title>
                        <desc>Created with Sketch Beta.</desc>
                        <defs></defs>
                        <g id="Page-1" stroke-width="0.0003" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                            <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-415.000000, -882.000000)" fill="#000000">
                                <path d="M440.021,883.289 C435.258,880.604 429.167,882.197 426.417,886.85 L422.434,893.589 L415.001,898.383 L424.336,903.646 C424.129,904.055 424,904.511 424,905 C424,906.657 425.343,908 427,908 C428.074,908 429.01,907.431 429.54,906.581 L439.148,912 L439.683,903.315 L443.666,896.576 C446.416,891.924 444.784,885.976 440.021,883.289" id="bell" sketch:type="MSShapeGroup"></path>
                            </g>
                        </g>
                    </g>
                </svg>
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
