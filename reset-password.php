<?php
    $mysqli = require __DIR__ . "/db_conn.php"; //database connect
    
    $token = $_GET["token"];

    $token_hash = hash("sha256", $token);

    $sql = "SELECT * FROM accounts
            WHERE reset_token_hash = ?";

    $stmt = $mysqli = $conn->prepare($sql);

    $stmt->bind_param("s", $token_hash);

    $stmt->execute();

    $result = $stmt->get_result();

    $accounts = $result->fetch_assoc();

    if ($accounts === null) {
        die("token not found");
    }

    if (strtotime($accounts["reset_token_expires_at"]) <= time()) {
        die("token has expired");
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <meta charset="UTF-8">
</head>
<header style="text-align: center; background-color: #1b212f;">
    <img src="Images/Logo.png" alt="MDJ Logo" style="max-width: 100px; vertical-align: middle;">
    <h1 style="display: inline-block; margin-left: 15px; font-size: 24px; color: #d0e7ff;">MDJ</h1>
</header>
    <body>
    

    <form method="post" action="process-reset-password.php" onsubmit="return validatePassword()">
        <h1>Reset Password</h1>
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        
        <div>
            <label for="h_password">Password:</label>
            <input type="password" name="h_password" id="h_password" placeholder="Password" required maxlength="32" oninput="checkPasswordStrength()">
            <div id="password-strength" style="height: 5px; width: 100%; margin-top: 5px;"></div>
            <div id="password-strength-message"></div>
        </div>

        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required maxlength="32">
        </div>

        <div id="error-message" style="color: red; margin-top: 10px;"></div>
        
        <button type="submit">Update Password</button>
    </form>

    <script>
        function validatePassword() {
            const password = document.getElementById('h_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorMessage = document.getElementById('error-message');
           
            // Clear previous error message
            errorMessage.textContent = '';
            
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
            
            return true; // Allow form submission
        }

        // Password strength checker function
        function checkPasswordStrength() {
            const password = document.getElementById('h_password').value;
            const strengthBar = document.getElementById('password-strength');
            const strengthMessage = document.getElementById('password-strength-message');
            
            let strength = 0;
            let message = '';

            if (password.length >= 8) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/\d/.test(password)) strength += 1;
            if (/[!@#$%^&*]/.test(password)) strength += 1;

            switch (strength) {
                case 1:
                    strengthBar.style.backgroundColor = 'red';
                    message = 'Weak';
                    break;
                case 2:
                    strengthBar.style.backgroundColor = 'orange';
                    message = 'Fair';
                    break;
                case 3:
                    strengthBar.style.backgroundColor = 'yellow';
                    message = 'Good';
                    break;
                case 4:
                    strengthBar.style.backgroundColor = 'green';
                    message = 'Strong';
                    break;
                default:
                    strengthBar.style.backgroundColor = '';
                    message = '';
                    break;
            }

            strengthBar.style.width = `${strength * 25}%`;
            strengthMessage.textContent = message;
        }
    </script>
</body>
</html>
<style>
/* Global reset for margins and padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Resetting margin and padding for the whole body and html */
body, html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
}

/* Body background and font */
body {
    font-family: Arial, sans-serif;
    background-color: #d0e7ff;
}

/* Full-width header with no spacing */
header {
    text-align: center;
    background-color: #1b212f;
    width: 100%;
    height: 125px;
    padding: 10px 0;
}

/* Styling for the logo and title */
header img {
    max-width: 150px;
    vertical-align: middle;
}

header h1 {
    display: inline-block;
    margin-left: 15px;
    font-size: 24px;
    color: #d0e7ff;
    vertical-align: middle;
}

/* Form container */
form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
    margin: 40px auto; /* Center form horizontally */
    min-width: 300px;
}

/* Form heading */
form h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

/* Form input and label styling */
form div {
    margin-bottom: 15px;
    text-align: left;
    display: flex;
    flex-direction: column;
}

form label {
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 14px;
}

form input {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
}

form input:focus {
    border-color: #5b9bd5;
}

/* Password strength indicator */
#password-strength {
    height: 5px;
    width: 100%;
    margin-top: 5px;
    background-color: #e0e0e0;
    border-radius: 3px;
}

#password-strength-message {
    font-size: 12px;
    margin-top: 5px;
    color: #f44336;
}

/* Error message */
#error-message {
    color: red;
    font-size: 14px;
}

/* Submit button styling */
button {
    background-color: #80bdff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:active {
    background-color:#00254a;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    header h1 {
        font-size: 20px;  /* Adjust font size for mobile */
    }

    form {
        padding: 15px;
        margin: 10px;
        max-width: 95%;  /* Make the form width more flexible */
    }

    form h1 {
        font-size: 20px;
    }

    form label {
        font-size: 12px; /* Smaller labels on mobile */
    }

    form input {
        font-size: 14px;  /* Slightly smaller font size for inputs */
    }

    button {
        font-size: 14px;  /* Smaller button text for mobile */
        padding: 8px 16px;  /* Adjust button padding */
    }
}

@media (max-width: 480px) {
    header img {
        max-width: 120px;  /* Logo size adjustment for small screens */
    }

    header h1 {
        font-size: 18px; /* Further reduce header font size */
    }

    button {
        font-size: 14px;  /* Ensure button text fits on small screens */
        padding: 8px 12px;  /* Adjust button padding for smaller screens */
    }
}

</style>