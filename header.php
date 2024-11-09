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
                <a href="products.php">Products</a>
                <div class="profile-icon" id="profile-icon">
                    <!-- SVG Profile Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="white">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </header>
    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="login-modal-content">
            <h2>Login</h2>
            <form id="login-form" action="Login.php" method="POST">
                <label for="username">Email:</label>
                <input type="text" id="username" name="i_email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="i_password" required>
                <button type="submit">Login</button>
            </form>
            <div class="register-prompt">
                <p>Don't have an account?</p>
                <button type="button" id="register-button" onclick="showRegisterModal()">Register</button>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="register-modal">
        <div class="register-modal-content">
            <span class="register-close" onclick="document.getElementById('register-modal').style.display='none'">&times;</span>
            <form id="register-form" action="Register.php" method="post" onsubmit="return validatePasswordAndEmail()">
                <h2>Register</h2>
                <div class="name-container">
                    <div class="name-field">
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
                    </div>
                    <div class="name-field">
                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
                    </div>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div>
                    <label for="phone_num">Phone Number:</label>
                    <input type="tel" name="phone_num" id="phone_num" placeholder="Phone Number" required pattern="\d{11}" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                </div>
                <div>
                    <label for="a_password">Password:</label>
                    <input type="password" name="a_password" id="a_password" placeholder="Password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                </div>
                <div>
                    <button type="submit" name="Submit">Register</button>
                    <button type="button" onclick="document.getElementById('register-modal').style.display='none';">Cancel</button>
                </div>
                <div id="error-message" style="color: red;"></div>
            </form>
        </div>
    </div>
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

/*Styles for Register and Login Form */
/* Modal Background Overlay */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent dark overlay */
}

/* Modal Content Box */
.login-modal-content {
    background: linear-gradient(135deg, #d0e7ff, #e6edf3); /* Light blue to light gray gradient */
    margin: 100px auto; /* Center vertically */
    padding: 30px;
    border-radius: 12px;
    width: 350px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Soft shadow */
    color: #333; /* General text color */
}

/* Header Styling */
.login-modal-content h2 {
    font-size: 24px;
    color: #4a4a4a; /* Slightly darker for contrast */
    margin-bottom: 20px;
    text-align: center;
    font-weight: bold;
}

/* Close Button */
.close {
    color: #777;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s;
}

.close:hover,
.close:focus {
    color: #555;
}

/* Login Form Styling */
#login-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

#login-form label {
    color: #666; /* Lighter gray for labels */
    font-size: 15px;
}

/* Input Field Styling */
#login-form input[type="text"],
#login-form input[type="password"] {
    padding: 10px;
    border: 3px solid #436776; /* Soft gray border */
    border-radius: 5px;
    font-size: 15px;
    color: #333;
    background-color: #f7fafc; /* Light background for contrast */
    box-sizing: border-box;
    transition: border-color 0.3s, background-color 0.3s;
}

#login-form input:focus {
    border-color: #8cb4e7; /* Light blue on focus */
    background-color: #eaf3fc; /* Slightly tinted blue */
    outline: none;
}

/* Login Button */
#login-form button[type="submit"] {
    padding: 12px;
    background-color: #6d9ad2; /* Darker blue button */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s;
}

#login-form button[type="submit"]:hover {
    background-color: #5178aa; /* Darker blue on hover */
}

/* Register Prompt */
.register-prompt {
    text-align: center;
    margin-top: 15px;
    color: #666; /* Light gray text */
}

.register-prompt p {
    margin-bottom: 8px;
    font-size: 14px;
}

/* Register Prompt Button */
.register-prompt button {
    padding: 8px 16px;
    background-color: #00254a; /* Darker blue-gray button */
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.register-prompt button:hover {
    background-color: #738da9; /* Darker gray-blue on hover */
}
/* register button to modal part */
/* Heading Styles for Register Form */
/* Modal Overlay */
.register-modal-content h2 {
    margin: 10px 0; /* Add margin above and below the heading */
    padding: 0; /* Optional: reset padding if any */
    font-size: 24px; /* Adjust font size if needed */
    color: #333; /* Set a color for the heading */
    text-align: center; /* Center align the heading text */
}
/* Register Modal Styles */
#register-modal {
    display: none; /* Hidden by default */
    position: fixed; 
    z-index: 1001; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0, 0, 0, 0.5); 
}

.register-modal-content {
    background-color: white;
    margin: 110px auto; /* Centered */
    padding: 20px;
    border: 1px solid #888;
    width: 300px; /* Could be more or less, depending on screen size */
    border-radius: 15px;
}
/* Close Button for mobile */
.register-close {
    color: #aaa;
    float: right;
    font-size: 17px;
    font-weight: bold;
    padding-top: 10px;
}

.register-close:hover,
.register-close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Register Form Styles */
#register-form {
    display: flex;
    flex-direction: column; /* Stack elements vertically */
}
#register-form label {
    margin: 10px 0 5px; /* Spacing for labels */
    font-size: 14px; /* Font size for labels */
    color: #333; /* Dark gray text for labels */
}

#register-form input[type="text"],
#register-form input[type="tel"],
#register-form input[type="email"],
#register-form input[type="password"] {
    padding: 8px; /* Padding for input */
    margin-bottom: 15px; /* Spacing between input fields */
    border: 1px solid #ccc; /* Light gray border */
    width: 100%; /* Full width */
}

/* Button Styles */
#register-form button {
    padding: 10px;
    background-color: #444; /* Dark background for button */
    color: white;
    border: none;
    cursor: pointer;
    margin-top: 10px; /* Space above button */
}

#register-form button:hover {
    background-color: #666; /* Darker gray on hover */
}

/* Link Styles */
#register-form a {
    color: #3b3e3f; /* Blue link color */
    text-decoration: none;
}

#register-form a:hover {
    text-decoration: underline; /* Underline on hover */
}
/* End for Register and Login Form */
</style>