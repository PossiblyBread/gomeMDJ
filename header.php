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
                <a href="faqs.php">FAQs</a>
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
            <a href="javascript:void(0);" onclick="openForgotPasswordModal()">Forgot Password?</a>
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
    <!-- Forgot Password Modal -->
    <div class="modal" id="forgot-password-modal">
        <div class="forgot-password-modal-content">
            <span class="forgot-password-close" onclick="document.getElementById('forgot-password-modal').style.display='none'">&times;</span>
            <h2>Forgot Password</h2>
            <form id="forgot-password-form" action="send-password-reset.php" method="POST">
                <label for="email">Enter your email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <div class="modal" id="forgot-password-modal-error">
        <div class="forgot-password-modal-content">
            <span class="forgot-password-close" onclick="document.getElementById('forgot-password-modal-error').style.display='none'">&times;</span>
            <strong>Oops!</strong>
            <p>Make sure the email you have provided is correct or is registered in our website!</p>
            <h2>Forgot Password</h2>
            <form id="forgot-password-form" action="send-password-reset.php" method="POST">
                <label for="email">Enter your email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Submit</button>
            </form>
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
                    <div id="password-strength" style="height: 3px; width: 100%; margin-top: 5px; margin-left:5px"></div>
                    <div id="password-strength-message"></div>
                    <ul id="password-requirements" style="color: red; margin-top: 10px;"></ul> <!-- List of missing requirements -->
                </div>

                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required maxlength="32">
                </div>
                <div>
                    <!-- Terms and Conditions Checkbox -->
                    <input type="checkbox" id="terms-checkbox" required>
                    <label for="terms-checkbox">
                        I agree to the <a href="javascript:void(0);" onclick="openTermsModal()" class="terms-link">Terms and Conditions</a>.
                    </label>
                </div>
                <div>
                    <button type="submit" name="Submit">Register</button>
                    <button type="button" onclick="document.getElementById('register-modal').style.display='none';">Cancel</button>
                </div>
                <div id="error-message" style="color: red;"></div>
            </form>
        </div>
    </div>
    <!-- Terms and Conditions Modal -->
    <div id="terms-modal" style="display:none;">
        <div class="terms-modal-content">
            <span class="terms-close" onclick="document.getElementById('terms-modal').style.display='none'">&times;</span>
            <h2>Terms and Conditions</h2>
            <p>
                Before registering and using the MDJ eBike Store website, users must agree to the following:
            </p>
            <ol>
                <li><strong>Registration with Email Account</strong>
                    <ul>
                        <li>I confirm that I will use a valid Email account to register on the Website.</li>
                        <li>I agree to provide accurate and complete information during registration, including my Email address.</li>
                        <li>I acknowledge that the Email address provided will be used for communication regarding inquiries, updates, and other related matters.</li>
                        <li>I am responsible for ensuring that my Email account remains active and accessible.</li>
                    </ul>
                </li>
                <li><strong>Website Usage</strong>
                    <ul>
                        <li>I will use the Website for personal and non-commercial purposes only.</li>
                        <li>I understand that the Website is designed for browsing eBikes, viewing promotions, and managing inquiries or transactions.</li>
                        <li>I agree to abide by all rules and policies outlined on the Website.</li>
                    </ul>
                </li>
                <li><strong>Privacy and Security</strong>
                    <ul>
                        <li>I agree to the collection, use, and storage of my Email address and other personal data as described in the Privacy Policy.</li>
                        <li>I acknowledge that MDJ eBike Store will take reasonable measures to protect my information but cannot guarantee absolute security.</li>
                    </ul>
                </li>
                <li><strong>Email Notifications</strong>
                    <ul>
                        <li>I understand that MDJ eBike Store may use email account regarding account verification.</li>
                        <li>I am responsible for regularly checking my Email account to stay informed about these communications.</li>
                    </ul>
                </li>
                <li><strong>Limitations and Liability</strong>
                    <ul>
                        <li>I understand that the content on the Website, including eBike specifications and promotions, may be updated or changed without prior notice.</li>
                    </ul>
                </li>
                <li><strong>Account Termination</strong>
                    <ul>
                        <li>I understand that MDJ eBike Store reserves the right to suspend or terminate my account if I violate these Terms and Conditions.</li>
                    </ul>
                </li>
            </ol>
            <div>
                <input type="radio" id="terms-agree" name="terms-agree" value="agree" onclick="enableCloseButton()">
                <label for="terms-agree">I have read and agree to the terms and conditions.</label>
            </div>
            <div>
                <button id="terms-close-btn" onclick="closeTermsModal()" disabled>Agree</button>
            </div>
        </div>
    </div>

    <script>
        function openForgotPasswordModal() {
            document.getElementById('login-modal').style.display = 'none';
            document.getElementById('forgot-password-modal').style.display = 'block';
        }
        function closeForgotPasswordModal() {
            document.getElementById('forgot-password-modal').style.display = 'none';
        }
        function closeForgotPasswordModal() {
            document.getElementById('forgot-password-modal-error').style.display = 'none';
        }
        // Function to check the password strength and requirements
        function checkPasswordStrength() {
            const password = document.getElementById('a_password').value;
            const strengthMessage = document.getElementById('password-strength-message');
            const passwordStrengthBar = document.getElementById('password-strength');
            
            let strength = "weak"; // Default strength
            let strengthClass = "weak"; // Default class for weak strength
            let requirements = {
                length: password.length >= 8,  // Password length at least 8
                uppercase: /[A-Z]/.test(password),  // Contains at least one uppercase letter
                number: /\d/.test(password),  // Contains at least one number
                specialChar: /[!@#$%^&*]/.test(password),  // Contains at least one special character
            };

            // Update password strength based on the criteria
            let strengthPercentage = 0;
            if (requirements.length) strengthPercentage += 25;
            if (requirements.uppercase) strengthPercentage += 25;
            if (requirements.number) strengthPercentage += 25;
            if (requirements.specialChar) strengthPercentage += 25;

            // Adjust strength level based on percentage
            if (strengthPercentage === 100) {
                strength = "strong";
                strengthClass = "strong";
            } else if (strengthPercentage >= 50) {
                strength = "medium";
                strengthClass = "medium";
            }

            // Update the password strength message
            if (strengthMessage) {
                strengthMessage.innerText = `Password Strength: ${strength.charAt(0).toUpperCase() + strength.slice(1)}`;
                // Remove previous classes and add the new one
                strengthMessage.classList.remove('weak', 'medium', 'strong');
                strengthMessage.classList.add(strengthClass);
            }

            // Update the password strength bar width based on strength
            if (passwordStrengthBar) {
                passwordStrengthBar.style.width = `${strengthPercentage}%`;
                passwordStrengthBar.style.backgroundColor = strengthClass === "strong" ? 'green' :
                                                        strengthClass === "medium" ? 'orange' : 'red';
            }

            // Display which password requirements are met or not
            const requirementMessages = document.getElementById('password-requirements');
            let requirementText = "";

            // Check each requirement and provide feedback
            if (!requirements.length) {
                requirementText += "<li>Password must be at least 8 characters long.</li>";
            }
            if (!requirements.uppercase) {
                requirementText += "<li>Password must contain at least one uppercase letter.</li>";
            }
            if (!requirements.number) {
                requirementText += "<li>Password must contain at least one number.</li>";
            }
            if (!requirements.specialChar) {
                requirementText += "<li>Password must contain at least one special character (!@#$%^&*).</li>";
            }

            // Display the live feedback for missing requirements
            if (requirementMessages) {
                requirementMessages.innerHTML = requirementText;
            }
        }

        // Function to open the Terms and Conditions modal
        function openTermsModal() {
            document.getElementById('terms-modal').style.display = 'block';
        }
        // Function to close the Terms and Conditions modal
        function closeTermsModal() {
            document.getElementById('terms-modal').style.display = 'none';
        }
        // Enable the close button when the user agrees to the terms
        function enableCloseButton() {
            const closeButton = document.getElementById('terms-close-btn');
            const agreeRadioButton = document.getElementById('terms-agree');
            
            // Enable the close button if the radio button is selected
            if (agreeRadioButton.checked) {
                closeButton.disabled = false;  // Enable button
                document.getElementById('terms-close').style.cursor = 'pointer'; // Change cursor to pointer
            } else {
                closeButton.disabled = true;  // Disable button
                document.getElementById('terms-close').style.cursor = 'not-allowed'; // Keep cursor as not-allowed
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
                errorMessage.textContent += 'Email must be a valid Email address (e.g., example@gmail.com)!';
                return false; // Prevent form submission
            }
            // Ensure terms and conditions checkbox is checked
            if (!termsCheckbox.checked) {
                errorMessage.textContent += 'You must agree to the terms and conditions.';
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
        background-color:#1b212f;
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
    /* Forgot Password Modal Styles */
    #forgot-password-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        z-index: 1000;
    }

    .forgot-password-modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        width: 300px;
        margin: 100px auto;
        position: relative;
    }
    #forgot-password-modal-error strong {
        text-align: center;
        display: block;
        color: red;
    }
    #forgot-password-modal-error p {
        text-align: center;
        display: block;
        color: red;
        font-size: 13px;
    }
    .forgot-password-close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 25px;
        cursor: pointer;
    }

    .forgot-password-modal-content h2 {
        text-align: center;
        padding-bottom: 5px;
    }

    .forgot-password-modal-content form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .forgot-password-modal-content input[type="email"] {
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .forgot-password-modal-content button {
        padding: 10px;
        background-color: #80bdff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .forgot-password-modal-content button:hover {
        background-color: #1b212f;
    }
    /* Style for the Terms and Conditions link */
    .terms-link {
        margin-left: -15px;
        text-decoration: underline;
    }

    .terms-link:hover {
        color: #80bdff;
    }
    .terms-modal-content {
        padding: 20px;
        background-color:#CBDCEB;
        border-radius: 8px;
        width: 500px;
        max-width: 90%;
        margin: 100px auto;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    .terms-close {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 20px;
        cursor: pointer;
    }

    #terms-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        z-index: 999999;
    }
    /* Basic styling for the modal */
    .terms-modal-content {
        padding: 20px;
        background-color: #CBDCEB;
        border-radius: 8px;
        width: 500px;
        max-width: 90%;
        margin: 100px auto;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        max-height: 70vh; /* Limit the height of the modal content */
        overflow-y: auto; /* Allow scrolling if content exceeds the height */
    }

    .terms-close {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 20px;
        cursor: not-allowed;
    }

    #terms-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        z-index: 999999;
    }

    #terms-close-btn {
        padding: 10px 20px;
        background-color: #738da9;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 15px;
    }

    #terms-close-btn:disabled {
        background-color: #ccc;
    }
</style>