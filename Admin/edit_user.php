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
        $alert_message = "Invalid moderator password."; // Store the alert message
    } else {
        // Proceed with account update if the moderator password is correct
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
        $assigned_department = mysqli_real_escape_string($conn, $_POST['assigned_department']);
        $validation = mysqli_real_escape_string($conn, $_POST['validation']);

        // Update the accounts table
        $update_sql = "UPDATE `accounts` SET 
            `first_name`='$first_name', 
            `last_name`='$last_name', 
            `email`='$email', 
            `phone_num`='$phone_num', 
            `role`='$role',
            `assigned_department`='$assigned_department'
            WHERE `id`='$id'";

        if (mysqli_query($conn, $update_sql)) {
            $_SESSION['show_success_modal'] = true;
            header("Location: edit_user.php?id=$id");
            exit();
        } else {
            header("Location: edit_user.php?id=$id");
            exit();
        }
    }
}

// Handle password reset
if (isset($_POST['reset_password'])) {
    // Capture the moderator password and verify it
    $moderator_password = mysqli_real_escape_string($conn, $_POST['moderator_password']);
    if (!validateModeratorPassword($moderator_password)) {
        $alert_message = "Invalid moderator password."; // Store the alert message
    } else {
        // Proceed with password reset if the moderator password is correct
        $new_password = 'password1'; // Set the password to 'password1'
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password

        $reset_sql = "UPDATE `accounts` SET `h_password`='$hashed_password' WHERE `id`='$id'";

        if (mysqli_query($conn, $reset_sql)) {
            $alert_message = "Password reset to 'password1'."; // Store success message for alert
        } else {
            $alert_message = "Error resetting password: " . mysqli_error($conn); // Store error message for alert
        }
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
    <script>
        // Function to toggle the visibility of the assigned department field
        function toggleAssignedDepartment() {
            const role = document.querySelector('select[name="role"]').value;
            const assignedDepartmentField = document.querySelector('div#assigned_department_field');
            
            if (role === 'IT_Support') {
                assignedDepartmentField.style.display = 'block'; // Show the field
            } else {
                assignedDepartmentField.style.display = 'none'; // Hide the field
            }
        }

        // Run the toggle function when the page loads
        window.onload = function() {
            toggleAssignedDepartment();
            // Add event listener to role selection to toggle the department visibility
            document.querySelector('select[name="role"]').addEventListener('change', toggleAssignedDepartment);
        }
    </script>
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
            <input type="text" name="phone_num" value="<?php echo htmlspecialchars($account['phone_num']); ?>" required maxlength="11" minlength="11"  oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        <div class="form-group">
            <label for="role" class="required">Role:</label>
            <select name="role" required>
                <option value="user" <?php echo $account['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                <option value="IT_Support" <?php echo $account['role'] === 'IT_Support' ? 'selected' : ''; ?>>IT Support</option>
                <option value="Admin" <?php echo $account['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>

        <!-- Assigned Department Field (Initially Hidden) -->
        <div id="assigned_department_field" class="form-group" style="display: none;">
            <label for="assigned_department" class="required">Assigned Department:</label>
            <select name="assigned_department" required>
                <option value="" disabled selected>Select Department</option>
                <option value="Billing" <?php echo $account['assigned_department'] === 'Billing' ? 'selected' : ''; ?>>Billing</option>
                <option value="Mechanical" <?php echo $account['assigned_department'] === 'Mechanical' ? 'selected' : ''; ?>>Mechanical</option>
                <option value="Technical" <?php echo $account['assigned_department'] === 'Technical' ? 'selected' : ''; ?>>Technical</option>
                <option value="Assistance" <?php echo $account['assigned_department'] === 'Assistance' ? 'selected' : ''; ?>>Assistance</option>
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
    <!-- Success Modal -->
    <div id="SuccessModal" class="SuccessModal">
        <div class="modal-content">
            <span id="closeSuccessModal" class="close">&times;</span>
            <h2>Success!</h2>
            <p>The account was updated successfully.</p>
        </div>
    </div>
    <!-- Back Button -->
    <br><br>
    <a href="Account_Manager.php">
        <button type="button">Back to Account Manager</button>
    </a>
</div>
</body>
<script>
    // Listen for form submission
    document.querySelector("form").addEventListener("submit", function(event) {
        var phone_number = document.querySelector('input[name="phone_num"]').value;

        // Check if phone number length is exactly 11 characters
        if (phone_number.length !== 11) {
            alert("Phone number must be exactly 11 digits.");
            event.preventDefault(); // Prevent form submission
        }
    });
</script>

<script>
    // Function to toggle the visibility of the assigned department field
    function toggleAssignedDepartment() {
        const role = document.querySelector('select[name="role"]').value;
        const assignedDepartmentField = document.querySelector('div#assigned_department_field');
        
        if (role === 'IT_Support') {
            assignedDepartmentField.style.display = 'block'; // Show the field
        } else {
            assignedDepartmentField.style.display = 'none'; // Hide the field
        }
    }

    // Function to show the success modal
    function showUpdateSuccessModal() {
        var modal = document.getElementById("SuccessModal");
        modal.style.display = "block";
    }

    // Close the modal when the user clicks the 'X'
    function closeSuccessModal() {
        document.getElementById("SuccessModal").style.display = "none";
        window.location.href = "Account_Manager.php"; // Redirect to Account_Manager.php
    }

    // Close the modal if the user clicks outside of it
    function closeModalOnClick(event) {
        var successModal = document.getElementById("SuccessModal");
        if (event.target == successModal) {
            successModal.style.display = "none";
            window.location.href = "Account_Manager.php"; // Redirect to Account_Manager.php
        }
    }

    // Combine all onload functions
    window.onload = function() {
        toggleAssignedDepartment();
        document.querySelector('select[name="role"]').addEventListener('change', toggleAssignedDepartment);
        <?php if (isset($_SESSION['show_success_modal']) && $_SESSION['show_success_modal'] === true): ?>
            showUpdateSuccessModal();
            <?php unset($_SESSION['show_success_modal']); // Unset session variable to prevent it from reappearing ?>
        <?php endif; ?>
        document.getElementById("closeSuccessModal").onclick = closeSuccessModal;
        window.onclick = closeModalOnClick;
    }
</script>
</html>
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
    /* Modal Styles */
    .SuccessModal {
        display: none;
        position: fixed;
        z-index: 999999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .SuccessModal .modal-content {
        background-color: #add8e6; 
        margin: 200px auto 15% auto;
        max-width: 500px;
        padding: 15px;
        border: 2px solid #1b212f;
        width: 80%;
        border-radius: 15px;
        text-align: center;
    }

    .SuccessModal .close {
        margin-top: -10px;
        color: maroon;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .SuccessModal .close:hover,
    .SuccessModal .close:focus {
        color: red;
        text-decoration: none;
        cursor: pointer;
    }
</style>