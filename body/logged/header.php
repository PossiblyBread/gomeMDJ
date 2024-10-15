<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-left">
                <h1 class="logo" id="logo">gomeMDJ</h1>
                <nav class="nav-links">
                    <a href="Home.php">Home</a>
                    <a href="Account.php">Account</a>
                    <a href="about.php">About</a>
                    <a href="store.php">Store</a>
                    <a href="support.php">Support</a>
                </nav>
            </div>
            <div class="header-right">
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
</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userNameElement = document.getElementById('user-name');
        const profileIconElement = document.getElementById('profile-icon');
        const dropdownMenuElement = document.getElementById('dropdown-menu');

        // Function to toggle dropdown visibility
        function toggleDropdown() {
            console.log('Toggle dropdown triggered'); // Debug log
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

        // Close dropdown if clicking outside of it
        document.addEventListener('click', function(event) {
            if (!dropdownMenuElement.contains(event.target) && !userNameElement.contains(event.target) && !profileIconElement.contains(event.target)) {
                dropdownMenuElement.classList.remove('open');
                setTimeout(() => {
                    dropdownMenuElement.style.display = 'none';
                }, 300);
            }
        });
    });
</script>
<style>
    
/* logged in user css styles */
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

/* Updated Header Section */
.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15.7px 20px;
    background-color: #444; /* Consistent with .top-nav background color */
    color: white;           /* Consistent with .top-nav text color */
}

/* Left Section: Logo & Navigation Links */
.header-left {
    display: flex;
    align-items: center;
}

.logo {
    font-size: 24px;        /* Consistent with .top-nav h1 size */
    color: white;           /* Same color as navigation links */
    margin-right: 20px;
}

.nav-links a {
    color: white;           /* Consistent with .top-nav-btn a color */
    padding: 10px 15px;     /* Matches the padding from previous a styles */
}

/* Style for the dropdown menu */
.dropdown-menu {
    position: absolute;
    right: 10px; /* Align it with the profile icon */
    top: 50px; /* Position it below the header */
    background-color: #444;
    color: white;
    padding: 0 10px; /* Only horizontal padding initially */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1001; /* Ensure it is above other content */

    /* Animation properties */
    transform: translateY(-20px); /* Start slightly above */
    opacity: 0; /* Start hidden */
    visibility: hidden; /* Initially hidden */
    transition: transform 0.3s ease, opacity 0.3s ease, visibility 0s linear 0.3s; /* Smooth transitions */
}

.dropdown-menu.open {
    padding: 10px; /* Restore vertical padding when open */
    transform: translateY(0); /* Slide down to its position */
    opacity: 1; /* Fully visible */
    visibility: visible; /* Make it visible when open */
    transition: transform 0.3s ease, opacity 0.3s ease, visibility 0s linear 0s; /* No delay for visibility */
}


.dropdown-menu a {
    text-decoration: none;
    color: white;
    display: block;
    padding: 5px;
}

.dropdown-menu a:hover {
    background-color: #555; /* Change color on hover */
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
}

.user-name {
    font-size: 18px;        /* Slightly smaller than logo */
    color: white;           /* Same color as profile icon */
    margin-right: 10px;     /* Space between username and profile icon */
}
/* Profile Container */
.profile-container {
    display: flex;
    flex-direction: column; /* Stack icon and username vertically */
    align-items: center; /* Center align icon and username */
    padding: 20px; /* Add some padding */
}

.sidebar-user-name {
    color: white; /* Make sure the text color matches */
    font-size: 16px; /* Adjust font size as needed */
    margin-top: 10px; /* Space between icon and username */
}
/* Profile Icon */
.profile-icon {
    cursor: pointer;
    font-size: 24px;        /* Matches previous profile icon size */
    color: white;           /* Same color for consistency */
    margin-left: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-icon svg {
    width: 24px;            /* Consistent with other icon sizes */
    height: 24px;
    fill: white;            /* Consistent with icon color */
}
/* Hide navigation links on narrow screens */
@media (max-width: 768px) {
    .nav-links {
        display: none; /* Hide navigation links */
    }

    .user-name {
        cursor: pointer; /* Change cursor to indicate clickable element */
    }
    .profile-icon {
        display: none; /* Hide profile icon on narrow screens */
    }
}
hr {
    border: none; /* Remove the default border */
    height: 3px; /* Set the height of the line */
    background-color: #ccc; /* Light gray color */
    margin: 25px 5%; /* Spacing above and below */
    border-radius: 5px; /* Rounded corners */

}
</style>