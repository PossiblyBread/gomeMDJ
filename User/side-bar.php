<?php
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

$id = $_SESSION['id'];  // Assume user ID is stored in session
$validation_status = '';

// Fetch the user's validation status from the accounts table
$sql_validation = "SELECT `validation` FROM `accounts` WHERE `id` = '$id'";
$validation_result = mysqli_query($conn, $sql_validation);
if ($validation_result) {
    $row = mysqli_fetch_assoc($validation_result);
    $validation_status = $row['validation'];  // Get validation status
} else {
    die("Error fetching validation status.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <aside class="side-nav" id="side-nav">
        <!-- Profile Icon at the Top -->
        <div class="profile-container">
            <div class="profile-icon" id="sidebar-profile-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="white">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z" />
                </svg>
            </div>
            <span class="user-name" id="user-name">
                <?php echo htmlspecialchars($userFirstName . ' ' . $userLastName); ?>
            </span>
        </div>
        <hr>
        <div class="side-nav-links">
            <a href="Account.php">Account</a>
            <?php if ($validation_status === "Validated"): ?>
                <a href="paymentHistory.php">Payments</a>
            <?php endif; ?>
            <a href="Home.php">Home</a>
            <a href="store.php">Products</a>
            <a href="about.php">About</a>
            <a href="support.php">Support</a>
            <?php if ($validation_status === "Validated"): ?>
                <a href="Tickets.php">Tickets</a>
            <?php endif; ?>
            <a onclick="openModal()">Feedback</a>
            <a href="#" id="logoutLink">Logout</a>
        </div>
    </aside>
    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="logout-modal">
        <div class="logout-modal-content">
            <span class="close" id="closeLogoutModal">&times;</span>
            <p><strong>Are you sure you want to log out?</strong></p>
            <button id="confirmLogout">Log Out</button>
            <button id="cancelLogout">Cancel</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userNameElement = document.getElementById('user-name');
            const dropdownMenuElement = document.getElementById('dropdown-menu');

            // Sidebar Elements
            const sideNav = document.getElementById('side-nav');
            const overlay = document.getElementById('overlay');

            // Function to open/close sidebar
            function toggleSidebar() {
                if (sideNav.style.width === "250px") {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }

            // Click event for username to toggle sidebar only on narrow screens
            function handleUserNameClick(event) {
                event.stopPropagation(); // Prevent event bubbling to document click
                toggleSidebar();
            }

            // Overlay click event to close the sidebar
            overlay.addEventListener('click', function() {
                closeSidebar();
            });

            // Function to open the sidebar
            function openSidebar() {
                sideNav.style.width = "250px"; // Adjusted to full width
                overlay.style.display = "block"; // Show overlay when sidebar opens
            }

            // Function to close the sidebar
            function closeSidebar() {
                sideNav.style.width = "0";
                overlay.style.display = "none"; // Hide overlay when sidebar closes
            }

            // Check window size and add click event listener accordingly
            function checkScreenSize() {
                if (window.innerWidth <= 1000) {
                    userNameElement.addEventListener('click', handleUserNameClick);
                } else {
                    userNameElement.removeEventListener('click', handleUserNameClick);
                    closeSidebar(); // Close sidebar on wider screens
                    overlay.style.display = "none"; // Hide overlay
                }
            }
            // Initial check
            checkScreenSize();
            // Check on resize
            window.addEventListener("resize", checkScreenSize);
        });
        document.addEventListener('DOMContentLoaded', function() {
            const logoutLink = document.getElementById('logoutLink');
            const logoutModal = document.getElementById('logoutModal');
            const closeModal = document.getElementById('closeLogoutModal');
            const confirmLogout = document.getElementById('confirmLogout');
            const cancelLogout = document.getElementById('cancelLogout');

            // Open the logout confirmation modal when the logout link is clicked
            logoutLink.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default action
                logoutModal.style.display = 'block'; // Show the modal
            });

            // Close the modal when the user clicks on <span> (x)
            closeModal.addEventListener('click', function() {
                logoutModal.style.display = 'none'; // Hide the modal
            });

            // Close the modal when the user clicks anywhere outside of the modal
            window.addEventListener('click', function(event) {
                if (event.target === logoutModal) {
                    logoutModal.style.display = 'none'; // Hide the modal
                }
            });

            // Confirm logout and redirect to the logout page
            confirmLogout.addEventListener('click', function() {
                window.location.href = '../logout.php'; // Redirect to logout page
            });

            // Cancel logout and close the modal
            cancelLogout.addEventListener('click', function() {
                logoutModal.style.display = 'none'; // Hide the modal
            });
        });
    </script>
</body>

</html>
<style>
    /* Logout Modal Styles */
    .logout-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    /* Content of the modal */
    .logout-modal-content {
        background-color: #fefefe;
        padding: 20px;
        border: 1px solid #888;
        width: 400px;
        border-radius: 15px;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-width: 1.5px;
    }

    @media (max-width: 600px) {
        .logout-modal-content {
            width: 70%;
        }
    }

    /* Close button styling */
    .logout-modal .close {
        margin-top: -15px;
        margin-right: -10px;
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        float: right;
    }

    .logout-modal .close:hover,
    .logout-modal .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    #confirmLogout,
    #cancelLogout {
        padding: 8px;
        color: #2c3e50;
        background-color: #ADD8E6;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        /* Optional: adds rounded corners */
        transition: background-color 0.3s, transform 0.2s;
        /* Smooth transition effect */
    }

    #confirmLogout:hover,
    #cancelLogout:hover {
        background-color: #2c3e50;
        /* Darker blue on hover */
        color: #ADD8E6;
        transform: scale(1.05);
        /* Slightly enlarges the button */
    }

    /* Sidebar navigation */
    .side-nav {
        height: 100%;
        width: 0;
        position: fixed;
        top: 0;
        right: 0;
        background-color: #333;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 20px;
        z-index: 1001;
    }

    .side-nav hr {
        border: 1.50px solid #f1f1f1;
        width: 80%;
        margin: 20px auto;
        border-radius: 15px;
    }

    /* Sidebar navigation */
    .side-nav {
        height: 100%;
        width: 0;
        position: fixed;
        top: 0;
        right: 0;
        background-color: #00254a;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 20px;
        z-index: 1001;
    }

    /* Profile Icon in Sidebar */
    #sidebar-profile-icon {
        cursor: pointer;
        font-size: 32px;
        color: white;
        margin: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Sidebar links */
    .side-nav-links a {
        display: block;
        padding: 15px 20px;
        color: white;
        font-size: 18px;
    }
</style>