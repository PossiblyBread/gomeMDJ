<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include 'feedback-form.php'; ?>
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
                <div class="profile-icon" id="profile-icon"><span>Login</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="white">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z" />
                    </svg>
                </div>
            </div>
        </div>
    </header>
    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="login-modal-content" id="login-form-content">
            <span class="login-close" onclick="document.getElementById('login-modal').style.display='none'">&times;</span>
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
        <!-- OTP Form -->
        <div class="modal-content" id="otp-form">

            <div class="form-container">
                <h2>Enter OTP</h2>

                <div class="message-container">
                    <div id="otp-status-message">Please check your email for the OTP code</div>
                </div>

                <form id="otp-verification-form">
                    <div class="form-group">
                        <label for="otp">Enter OTP:</label>
                        <input type="text"
                            id="otp"
                            name="otp"
                            maxlength="6"
                            pattern="\d{6}"
                            required
                            inputmode="numeric"
                            placeholder="Enter 6-digit OTP">
                    </div>

                    <div class="message-container">
                        <div id="otp-expiry-message">Time remaining: <span id="countdown">2:00</span></div>
                        <div id="otp-wait-message">Please wait, sending OTP...</div>
                    </div>

                    <div class="button-group">
                        <button type="submit" id="verify-otp-btn" class="primary-btn">Verify OTP</button>
                        <button type="button" id="resend-otp-btn" class="secondary-btn" style="display: none;">Resend OTP</button>
                        <button type="button" class="back-btn" onclick="backToLoginForm()">Back</button>
                    </div>
                </form>
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
                    <input type="tel" name="phone_num" id="phone_num" placeholder="Phone Number" required pattern="\d{11}" maxlength="11" inputmode="numeric" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);">
                </div>
                <div>
                    <label for="a_password">Password:</label>
                    <input type="password" name="a_password" id="a_password" placeholder="Password" required maxlength="32" oninput="checkPasswordStrength()">
                    <div id="password-strength" style="height: 5px; width: 100%; margin-top: 5px;"></div>
                    <div id="password-strength-message"></div>
                </div>

                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required maxlength="32">
                </div>
                <div>
                    <button type="submit" name="Submit">Register</button>
                    <button type="button" onclick="document.getElementById('register-modal').style.display='none';">Cancel</button>
                </div>
                <div id="error-message" style="color: red;"></div>
            </form>
        </div>
    </div>
    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('a_password').value;
            const strengthMessage = document.getElementById('password-strength-message');
            
            let strength = "weak"; // Default is weak
            let strengthClass = "weak"; // Initial class for weak strength
            
            if (password.length >= 8 && password.length <= 11) {
                strength = "medium";
                strengthClass = "medium";
            } else if (password.length >= 12) {
                strength = "strong";
                strengthClass = "strong";
            }

            // Update the password strength message and its color
            if (strengthMessage) {
                strengthMessage.innerText = `Password Strength: ${strength.charAt(0).toUpperCase() + strength.slice(1)}`;
                
                // Remove previous classes if any
                strengthMessage.classList.remove('weak', 'medium', 'strong');
                // Add the new strength class
                strengthMessage.classList.add(strengthClass);
            }
        }

        function validatePasswordAndEmail() {
            const password = document.getElementById('a_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const email = document.getElementById('email').value;
            const phoneNum = document.getElementById('phone_num').value; // Get the phone number input
            const errorMessage = document.getElementById('error-message');

            // Clear previous error message
            errorMessage.textContent = '';

            // Check if phone number length is 11
            if (phoneNum.length !== 11) {
                errorMessage.textContent = 'Phone number must be exactly 11 digits long!';
                return false; // Prevent form submission
            }

            // Check if passwords match
            if (password !== confirmPassword) {
                errorMessage.textContent = 'Passwords do not match!';
                return false; // Prevent form submission
            }

            // Check for minimum password length
            if (password.length < 8) {
                errorMessage.textContent += 'Password must be at least 8 characters long! ';
                return false; // Prevent form submission
            }

            // Check for maximum password length (32 characters)
            if (password.length > 32) {
                errorMessage.textContent += 'Password cannot be longer than 32 characters!';
                return false; // Prevent form submission
            }
            // Check if password contains at least one number, one uppercase letter, and one special character
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,32}$/;
                if (!passwordPattern.test(password)) {
                errorMessage.textContent += 'Password must contain at least one uppercase letter, one number, and one special character (!@#$%^&*). ';
                return false; // Prevent form submission
            }
            // Check if email is valid and ends with @gmail.com
            const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            if (!emailPattern.test(email)) {
                errorMessage.textContent += 'Email must be a valid Gmail address (e.g., example@gmail.com)!';
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
</body>

</html>
<style>
    /* Styling for the logo */
    /* Fixed Header Section */
    header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background-color:#1b212f ;
        color: white;
    }
    .logo {
        padding-left: 15px;
        display: flex;
        align-items: center;
        color: white;
    }

    .profile-icon span {
        padding-right: 15px;
        font-size: 1.2rem;
    }

    .logo img {
        width: 50px;
        height: auto;
        margin-right: 10px;
    }

    /* Styling for navigation links */
    .top-nav-btn a{
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