<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <a href="Home.php">Home</a>
        <a href="Account.php">Account</a>
        <a href="about.php">About</a>
        <a href="store.php">Store</a>
        <a href="support.php">Support</a>
        <a href="../logout.php">Logout</a>
    </aside>
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
                if (window.innerWidth < 768) {
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
    </script>
</body>
</html>
<style>
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
    padding-top: 20px; /* Adjusted for spacing */
    z-index: 1001; /* Ensure it's above the overlay */
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
    padding-top: 20px; /* Adjusted for spacing */
    z-index: 1001; /* Ensure it's above the overlay */
}

/* Profile Icon in Sidebar */
#sidebar-profile-icon {
    cursor: pointer;
    font-size: 32px; /* Adjusted size */
    color: white;
    margin: 20px; /* Margin for spacing */
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Sidebar links */
.side-nav a {
    display: block;
    padding: 15px 20px;
    color: white;
    font-size: 18px;
}
</style>