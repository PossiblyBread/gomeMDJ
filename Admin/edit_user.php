<?php
session_start();
include "../db_conn.php";

// Ensure the account ID is passed
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM `accounts` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $sql);
    $account = mysqli_fetch_assoc($result);
    if (!$account) {
        die("Account not found.");
    }
}

// Handle form submission for updating the account
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    // Capture the moderator password and verify it
    $moderator_password = mysqli_real_escape_string($conn, $_POST['moderator_password']);
    if (!validateModeratorPassword($moderator_password)) {
        echo "Invalid moderator password.";
        exit();
    }

    // Proceed with account update if the moderator password is correct
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $validation = mysqli_real_escape_string($conn, $_POST['validation']);

    // Update the accounts table
    $update_sql = "UPDATE `accounts` SET 
        `first_name`='$first_name', 
        `last_name`='$last_name', 
        `email`='$email', 
        `phone_num`='$phone_num', 
        `role`='$role'
        WHERE `id`='$id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "Account updated successfully.";
        header("Location: Account_Manager.php"); // Redirect back after successful update
        exit();
    } else {
        echo "Error updating account: " . mysqli_error($conn);
    }
}

// Handle password reset
if (isset($_POST['reset_password'])) {
    // Capture the moderator password and verify it
    $moderator_password = mysqli_real_escape_string($conn, $_POST['moderator_password']);
    if (!validateModeratorPassword($moderator_password)) {
        echo "Invalid moderator password.";
        exit();
    }

    // Proceed with password reset if the moderator password is correct
    $new_password = 'password1'; // Set the password to 'password1'
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password

    $reset_sql = "UPDATE `accounts` SET `h_password`='$hashed_password' WHERE `id`='$id'";

    if (mysqli_query($conn, $reset_sql)) {
        echo "Password reset to 'password1'.";
        header("Location: Account_Manager.php"); // Redirect back after password reset
        exit();
    } else {
        echo "Error resetting password: " . mysqli_error($conn);
    }
}

// Function to validate the moderator password
function validateModeratorPassword($password) {
    return $password === 'admin1234'; // Replace 'admin1234' with your actual moderator password
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <style>
        /* Red asterisk for required fields */
        .required::after {
            content: " *";
            color: red;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f2ff; /* Light blue background */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; 
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #d1d8e0; 
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 18px;
        }
        label {
            font-size: 12px;
            font-weight: bold;
            color: #444;
            display: block;
            margin-bottom: 6px;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input:focus, select:focus, button:focus {
            outline: none;
            border-color: #00aaff;
        }
        button[type="submit"][name="update_account"] {
            background-color: #28a745;  /* Green */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px;
            border-radius: 4px;
        }

        button[type="submit"][name="update_account"]:hover {
            background-color: #218838; /* Darker green */
        }

        /* Button for Reset Password */
        button[type="submit"][name="reset_password"] {
            background-color: #6c757d;  /* Gray */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px;
            border-radius: 4px;
        }

        button[type="submit"][name="reset_password"]:hover {
            background-color: #5a6268; /* Darker gray */
        }

        /* Blue button for Back */
        button[type="button"] {
            background-color: #007bff;  /* Blue */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px;
            border-radius: 4px;
        }

        button[type="button"]:hover {
            background-color: #0056b3; /* Darker blue */
        }

        .form-group {
            margin-bottom: 10px;
        }
        .form-group input[readonly] {
            background-color: #f4f7fa;
            cursor: not-allowed;
        }
        .validation-output {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Account</h2>

    <!-- Form to Update Account -->
    <form method="post">
        <div class="form-group">
            <label for="first_name" class="required">First Name:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($account['first_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="last_name" class="required">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($account['last_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email" class="required">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($account['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_num" class="required">Phone Number:</label>
            <input type="text" name="phone_num" value="<?php echo htmlspecialchars($account['phone_num']); ?>" required>
        </div>
        <div class="form-group">
            <label for="role" class="required">Role:</label>
            <select name="role" required>
                <option value="user" <?php echo $account['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                <option value="IT_Support" <?php echo $account['role'] === 'IT_Support' ? 'selected' : ''; ?>>IT Support</option>
                <option value="Admin" <?php echo $account['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="validation" class="required">Account Validation Status:</label>
            <input type="text" name="validation" value="<?php echo htmlspecialchars($account['validation'] === 'Validated' ? 'true' : 'false'); ?>" readonly>
            <span class="validation-output <?php echo $account['validation'] === 'Validated' ? 'true' : 'false'; ?>"></span>
        </div>

        <!-- Moderator Password Field -->
        <div class="form-group">
            <label for="moderator_password" class="required">Moderator Password:</label>
            <input type="password" name="moderator_password" required>
        </div>

        <button type="submit" name="update_account">Update Account</button>
    </form>

    <!-- Reset Password Button with Moderator Password Validation -->
    <form method="post">
        <div class="form-group">
            <label for="moderator_password_reset" class="required">Moderator Password:</label>
            <input type="password" name="moderator_password" required>
        </div>
        <button type="submit" name="reset_password" onclick="return confirm('Are you sure you want to reset the password to \'password1\'?')">Reset Password to 'password1'</button>
    </form>

    <!-- Back Button -->
    <br><br>
    <a href="Account_Manager.php">
        <button type="button">Back to Account Manager</button>
    </a>
</div>

</body>
</html>
