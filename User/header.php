<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-left">
                <h1 class="logo" id="logo">
                    <img src=../Images/Logo.png>MDJ
                </h1>
                <nav class="nav-links">
                    <a href="Account.php">Account</a>
                    <a href="Home.php">Home</a>
                    <a href="store.php">Products</a>
                    <a href="about.php">About</a>
                    <a href="support.php">Support</a>
                </nav>
            </div>
            <div class="header-right">
                <div class="bell-notification-container" id="bell-icon">
                    <svg viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.18"></g><g id="SVGRepo_iconCarrier"> <title>bell</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-415.000000, -882.000000)" fill="#ffffff"> <path d="M440.021,883.289 C435.258,880.604 429.167,882.197 426.417,886.85 L422.434,893.589 L415.001,898.383 L424.336,903.646 C424.129,904.055 424,904.511 424,905 C424,906.657 425.343,908 427,908 C428.074,908 429.01,907.431 429.54,906.581 L439.148,912 L439.683,903.315 L443.666,896.576 C446.416,891.924 444.784,885.976 440.021,883.289" id="bell" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                </div>
                <span class="user-name" id="user-name">
                    <?php echo htmlspecialchars($userFirstName . ' ' . $userLastName); ?>
                </span>
                <div class="profile-icon" id="profile-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="white">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z" />
                    </svg>
                </div>
                <div class="dropdown-menu" id="dropdown-menu">
                    <a href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <div class="notif-dropdown-menu" id="notif-dropdown-menu"> 
           <!-- ticket notif  here  -->
        <p>Notification:</p>
        <?php include 'notification.php'; ?>   
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userNameElement = document.getElementById('user-name');
            const profileIconElement = document.getElementById('profile-icon');
            const dropdownMenuElement = document.getElementById('dropdown-menu');
            const notifdropdownMenuElement = document.getElementById('notif-dropdown-menu');
            const bellIconElement = document.getElementById('bell-icon');

            // Function to toggle dropdown visibility
            function toggleDropdown() {
                if (window.innerWidth > 768) {
                    if (dropdownMenuElement.classList.contains('open')) {
                        dropdownMenuElement.classList.remove('open');
                        setTimeout(() => {
                            dropdownMenuElement.style.display = 'none'; // Hide after animation
                        }, 300);
                    } else {
                        dropdownMenuElement.style.display = 'block'; // Show immediately
                        setTimeout(() => {
                            dropdownMenuElement.classList.add('open');
                        }, 10);
                    }
                }
            }

            // Click events for both the username and profile icon
            userNameElement.addEventListener('click', toggleDropdown);
            profileIconElement.addEventListener('click', toggleDropdown);
            bellIconElement.addEventListener('click', () => {
                 // Placeholder action for the bell icon
            });

            // Close dropdown if clicking outside of it
            document.addEventListener('click', function(event) {
                if (!dropdownMenuElement.contains(event.target) && !userNameElement.contains(event.target) && !profileIconElement.contains(event.target)) {
                    dropdownMenuElement.classList.remove('open');
                    setTimeout(() => {
                        dropdownMenuElement.style.display = 'none'; // Hide after animation
                    }, 300);
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const bellIconElement = document.getElementById('bell-icon');
            const notifDropdownMenuElement = document.getElementById('notif-dropdown-menu');

            // Toggle dropdown menu visibility
            bellIconElement.addEventListener('click', function(event) {
                event.stopPropagation();
                notifDropdownMenuElement.classList.toggle('open');
            });

            // Close dropdown if clicking outside of it
            document.addEventListener('click', function(event) {
                if (!notifDropdownMenuElement.contains(event.target) && !bellIconElement.contains(event.target)) {
                    notifDropdownMenuElement.classList.remove('open');
                }
            });
        });

    </script>
</body>
</html>
<style>
    /* General styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        color: #333;
    }

    h1, h2, h3 {
        margin: 0;
    }

    a {
        text-decoration: none;
        color: #333;
        padding: 10px 15px;
    }

    /* Fixed Header Section */
    header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background-color: #1b212f;
        color: white;
    }

    /* Add some padding to the body so content doesn't hide behind the fixed header */
    .content {
        padding-top: 80px; 
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15.7px 20px;
    }

    /* Left Section: Logo & Navigation Links */
    .header-left {
        display: flex;
        align-items: center;
    }

    .logo {
        padding-left: 15px;
        display: flex; 
        align-items: center;
        color: white; 
        margin-right:30px;
    }

    .logo img {
        width: 50px;
        height: auto;
        margin-right: 5px; 
    }

    .nav-links a {
        color: white;
        padding: 10px 15px;
    }

    /* Hover effect for navigation links */
    .nav-links a:hover {
        background-color: #555;
        color: #fff;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Style for the dropdown menu */
    .dropdown-menu {
        position: absolute;
        right: 10px;
        top: 50px;
        background-color: #444;
        color: white;
        padding: 0 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1001;
        transform: translateY(-20px);
        opacity: 0;
        visibility: hidden;
        transition: transform 0.3s ease, opacity 0.3s ease, visibility 0s linear 0.3s;
    }

    .dropdown-menu.open {
        padding: 10px;
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
        transition: transform 0.3s ease, opacity 0.3s ease, visibility 0s linear 0s;
    }

    .dropdown-menu a {
        text-decoration: none;
        color: white;
        display: block;
        padding: 5px;
    }

    .dropdown-menu a:hover {
        background-color: #555;
    }

    /* Only show on wider screens */
    @media (min-width: 769px) {
        #user-name {
            cursor: pointer;
        }
    }
    /* Right Section: Username & Profile Icon */
    .header-right {
        display: flex;
        align-items: center;
        justify-content: center; 
    }

    .bell-notification-container {
        margin-right: 30px;
        display: flex;
        align-items: center;
        width: 24px; 
        height: 24px; 
        cursor: pointer;
    }

    .user-name {
        font-size: 18px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Profile Icon */
    .profile-icon {
        cursor: pointer;
        font-size: 24px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-icon svg {
        width: 24px;
        height: 24px;
        fill: white;
    }

    /* Hide navigation links on narrow screens */
    @media (max-width: 768px) {
        .nav-links {
            display: none; 
        }

        .profile-icon {
            display: none; 
        }
    }
    /* notification  */
    .notif-dropdown-menu {
        position: fixed;
        right: 20px;
        top: 60px;
        background-color: #444;
        color: white;
        padding: 10px;
        width: 400px;
        border-radius: 5px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1001;
        display: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s, transform 0.3s;
    }

    .notif-dropdown-menu.open {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .notif-dropdown-menu a {
        text-decoration: none;
        color: white;
        display: block;
        padding: 8px 0;
    }

    .notif-dropdown-menu a:hover {
        background-color: #555;
    }
</style>
