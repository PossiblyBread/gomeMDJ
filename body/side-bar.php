<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <aside class="side-nav" id="side-nav">
        <div class="profile-icon" id="sidebar-profile-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="white">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
            </svg>
        </div>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="store.php">Store</a>
    </aside>
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