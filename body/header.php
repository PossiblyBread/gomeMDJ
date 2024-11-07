<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="top-nav">
            <h1 class="logo" id="logo">
                <img src=Images/Logo.png> MDJ
            </h1>
            <div class="menu-toggle" id="menu-toggle">&#9776;</div>
            <div class="top-nav-btn">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="store.php">Products</a>
                <a href="faqs.php">FAQs</a>
                <div class="profile-icon" id="profile-icon">
                    <!-- SVG Profile Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="white">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </header>
</body>
</html>
<style>
/* Styling for the logo */
.logo {
    padding-left: 15px;
    display: flex;
    align-items: center;
    color: white;
}

.logo img {
    width: 50px;
    height: auto;
    margin-right: 10px;
}

/* Styling for navigation links */
.top-nav-btn a {
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    margin: 0 5px;
    transition: all 0.3s ease-in-out;
}

/* White glow effect on hover for links */
.top-nav-btn a:hover {
    text-shadow: 0 0 10px white, 0 0 20px white, 0 0 30px white;
}
</style>