<?php
session_start();
include "../db_conn.php";

function fetchNotifications($conn) {
    $notifications = [];
    
    // Get added records
    $added = mysqli_query($conn, "SELECT * FROM accounts WHERE date_created >= NOW() - INTERVAL 1 DAY;"); // Adjust this query based on your needs
    while ($row = mysqli_fetch_assoc($added)) {
        $notifications[] = "Added: " . $row['first_name'] . " " . $row['last_name'];
    }
    
    return $notifications;
}

$notifications = fetchNotifications($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Accounts Data</title>
    <style>
        body {
            margin: 0; /* Remove default margin */
        }

        /* Top navigation styles */
        .top-nav {
            display: flex; /* Use flexbox for the navigation */
            justify-content: flex-end; /* Align items to the right */
            align-items: center; /* Center items vertically */
            background-color: #f8f9fa; /* Background color for nav */
            padding: 10px 20px; /* Padding for nav */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for nav */
            width: 100%; /* Stretch nav to full width */
            position: fixed; /* Fix position at the top */
            top: 0; /* Align to the top */
            left: 0; /* Align to the left */
        }

        /* Adjust main content padding to account for fixed navbar */
        .main-content {
            padding-top: 60px; /* Space for the navbar height */
        }

        .bell-notification-container {
            position: relative; /* Position relative for dropdown */
            display: inline-block; /* Inline block to align with other elements */
            margin: 10px 300px 0 0; /* Adjust this value to change space to the right */
        }

        .bell-notification-button {
            background-color: transparent; /* Transparent background */
            border: none; /* Remove border */
            cursor: pointer; /* Change cursor to pointer */
            padding: 0; /* Remove padding */
        }

        .bell-notification-button svg {
            width: 40px; /* Set width */
            height: 40px; /* Set height */
        }

        .bell-dropdown {
            display: none; /* Hide dropdown by default */
            position: absolute; /* Position dropdown absolutely */
            background-color: white; /* Dropdown background */
            border: 1px solid #ccc; /* Border */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Shadow */
            z-index: 1; /* Make sure it appears above other elements */
            margin-top: 5px; /* Space from button */
            width: 200px; /* Set width of dropdown */
            left: -150px; /* Position dropdown to the left (adjust as needed) */
        }

        .bell-dropdown-item {
            padding: 10px; /* Padding for dropdown items */
            cursor: pointer; /* Pointer cursor for items */
        }

        .bell-dropdown-item:hover {
            background-color: #f1f1f1; /* Highlight on hover */
        }
    </style>
</head>

<body>
<?php include '../body/IT/side-nav.php'; ?>

    <div class="top-nav">
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

    <div class="main-content">
        <!-- Your main content goes here -->
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
