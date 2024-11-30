<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <aside class="side-nav" id="side-nav">
        <div class="profile-icon" id="sidebar-profile-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="white">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
            </svg>
            <span class="login-text">Login</span> <!-- Add this span for Login text -->
        </div>
        <hr>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="products.php">Products</a>
        <a href="faqs.php">FAQs</a>
    </aside>
    <script src="js/script.js"></script>
    <script>
        function showLoginModal() {
            const loginModal = document.getElementById('login-modal');
            loginModal.style.display = 'block';
            // Reset form display states
            document.getElementById('login-form-content').style.display = 'block';
            document.getElementById('otp-form').style.display = 'none';

            // Close the sidebar if it's open
            if (sideNav.style.width === '250px') {
                closeSidebar(); // Close the sidebar
            }
        }
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
    background-color: #10375C;
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
/* Profile Icon in Sidebar */
#sidebar-profile-icon {
    cursor: pointer;
    font-size: 32px; 
    color: white;
    margin: 20px;
    display: flex;
    flex-direction: column;  /* Stack the icon and text vertically */
    align-items: center;     /* Center the icon and text */
    justify-content: center;
}

#sidebar-profile-icon svg {
    margin-bottom: 5px;  /* Add some space between the icon and text */
}

/* Login text styling */
.login-text {
    color: white;
    font-size: 16px;
    margin-left: 15px;
    text-align: center;
}

/* Sidebar links */
.side-nav a {
    display: block;
    padding: 15px 20px;
    color: white;
    font-size: 18px;
}
</style>
