<?php
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

include "../db_conn.php";

// Insert or Update Account Function
function insertOrUpdateAccount($conn, $id, $account, $validated_data) {
    // Check if the record already exists in the `validated_tb` table
    $check_existing_sql = "SELECT * FROM `validated_tb` WHERE `id` = '$id'";
    $check_result = mysqli_query($conn, $check_existing_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Update existing record in validated_tb
        $update_validated_sql = "UPDATE `validated_tb` SET 
            `serial_num` = '" . mysqli_real_escape_string($conn, $account['serial_num']) . "',
            `given_name` = '$validated_data[given_name]',
            `middle_name` = '$validated_data[middle_name]',
            `last_name` = '$validated_data[last_name]',
            `marital_status` = '$validated_data[marital_status]',
            `birth_date` = '$validated_data[birth_date]',
            `phone_number` = '$validated_data[phone_number]',
            `tin_number` = '$validated_data[tin_number]',
            `email` = '$validated_data[email]',
            `present_address` = '$validated_data[present_address]',
            `permanent_address` = '$validated_data[permanent_address]'
            WHERE `id` = '$id'";

        if (mysqli_query($conn, $update_validated_sql)) {
            // Update validation status in accounts table
            $update_validation_sql = "UPDATE `accounts` SET `validation` = 'Validated' WHERE `id` = '$id'";
            if (mysqli_query($conn, $update_validation_sql)) {
                return true; // Success
            }
        }
    } else {
        // Insert new data into validated_tb
        $insert_validated_sql = "INSERT INTO `validated_tb` (
            `id`, `serial_num`, `given_name`, `middle_name`, `last_name`, 
            `marital_status`, `birth_date`, `phone_number`, `tin_number`, 
            `email`, `present_address`, `permanent_address`
        ) VALUES (
            '$id', '" . mysqli_real_escape_string($conn, $account['serial_num']) . "', 
            '$validated_data[given_name]', '$validated_data[middle_name]', 
            '$validated_data[last_name]', '$validated_data[marital_status]', 
            '$validated_data[birth_date]', '$validated_data[phone_number]', 
            '$validated_data[tin_number]', '$validated_data[email]', 
            '$validated_data[present_address]', '$validated_data[permanent_address]'
        )";

        if (mysqli_query($conn, $insert_validated_sql)) {
            // Update validation status in accounts table
            $update_validation_sql = "UPDATE `accounts` SET `validation` = 'Validated' WHERE `id` = '$id'";
            if (mysqli_query($conn, $update_validation_sql)) {
                return true; // Success
            }
        }
    }
    
    return false; // Failure
}

// Ensure the account ID is passed
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch the account details from the `accounts` table
    $account_sql = "SELECT * FROM `accounts` WHERE `id` = '$id'";
    $account_result = mysqli_query($conn, $account_sql);
    $account = mysqli_fetch_assoc($account_result);
    
    if (!$account) {
        die("Account not found.");
    }

    // Fetch existing validated data from `validated_tb` (if any) for pre-filling the form
    $validated_sql = "SELECT * FROM `validated_tb` WHERE `id` = '$id'";
    $validated_result = mysqli_query($conn, $validated_sql);
    $validated_data = mysqli_fetch_assoc($validated_result);

    if (!$validated_data) {
        // Initialize empty array if no validated data found
        $validated_data = array(
            'given_name' => '',
            'middle_name' => '',
            'last_name' => '',
            'marital_status' => '',
            'birth_date' => '',
            'phone_number' => '',
            'tin_number' => '',
            'email' => '',
            'present_address' => '',
            'permanent_address' => ''
        );
    }
}

$moderator_error = ""; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    $moderator_password = mysqli_real_escape_string($conn, $_POST['moderator_password']);
    if (!validateModeratorPassword($moderator_password)) {
        $moderator_error = "Invalid moderator password."; // Set error message
    } else {
        // Prepare data for insert or update
        $validated_data = array(
            'given_name' => mysqli_real_escape_string($conn, $_POST['given_name']),
            'middle_name' => mysqli_real_escape_string($conn, $_POST['middle_name']),
            'last_name' => mysqli_real_escape_string($conn, $_POST['last_name']),
            'marital_status' => mysqli_real_escape_string($conn, $_POST['marital_status']),
            'birth_date' => mysqli_real_escape_string($conn, $_POST['birth_date']),
            'phone_number' => mysqli_real_escape_string($conn, $_POST['phone_number']),
            'tin_number' => mysqli_real_escape_string($conn, $_POST['tin_number']),
            'email' => mysqli_real_escape_string($conn, $_POST['email']),
            'present_address' => mysqli_real_escape_string($conn, $_POST['present_address']),
            'permanent_address' => mysqli_real_escape_string($conn, $_POST['permanent_address']),
        );

        $result = insertOrUpdateAccount($conn, $id, $account, $validated_data);
        if ($result) {
            $_SESSION['show_success_modal'] = true;
            header("Location: validate_user.php?id=$id");
            exit();
        } else {
            header("Location: validate_user.php?id=$id");
            exit();
        }
    }
}


// Function to validate the moderator password
function validateModeratorPassword($password) {
    return $password === 'admin1234'; // Replace with your actual moderator password
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
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
        }
        label {
            font-size: 14px;
            font-weight: bold;
            color: #444;
            display: block;
            margin-bottom: 6px;
        }
        input, select, button {
            width: 97%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #5bc0de;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #31b0d5;
        }
        .required-asterisk {
            color: red;
            margin-left: 5px;
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
</head>
<body>

<div class="container">
    <h2>Edit User Account</h2>

    <form method="post">
        <!-- Display Serial Number from `accounts` (Read-Only) -->
        <div class="form-group">
            <label for="serial_num">Serial Number:</label>
            <input type="text" name="serial_num" value="<?php echo htmlspecialchars($account['serial_num']); ?>" readonly>
        </div>

        <!-- Pre-fill validated data fields -->
        <div class="form-group">
            <label for="given_name">Given Name:<span class="required-asterisk">*</span></label>
            <input type="text" name="given_name" value="<?php echo htmlspecialchars($validated_data['given_name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" value="<?php echo htmlspecialchars($validated_data['middle_name']); ?>">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:<span class="required-asterisk">*</span></label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($validated_data['last_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="marital_status">Marital Status:<span class="required-asterisk">*</span></label>
            <select name="marital_status" required>
                <option value="Single" <?php echo $validated_data['marital_status'] === 'Single' ? 'selected' : ''; ?>>Single</option>
                <option value="Married" <?php echo $validated_data['marital_status'] === 'Married' ? 'selected' : ''; ?>>Married</option>
            </select>
        </div>

        <div class="form-group">
            <label for="birth_date">Birth Date:<span class="required-asterisk">*</span></label>
            <input type="date" name="birth_date" value="<?php echo htmlspecialchars($validated_data['birth_date']); ?>" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number:<span class="required-asterisk">*</span></label>
            <input type="tel" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($validated_data['phone_number']); ?>" required maxlength="11" minlength="11"  oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>

        <div class="form-group">
            <label for="tin_number">TIN Number:</label>
            <input type="text" name="tin_number" value="<?php echo htmlspecialchars($validated_data['tin_number']); ?>">
        </div>

        <div class="form-group">
            <label for="email">Email:<span class="required-asterisk">*</span></label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($validated_data['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="present_address">Present Address:<span class="required-asterisk">*</span></label>
            <input type="text" name="present_address" value="<?php echo htmlspecialchars($validated_data['present_address']); ?>" required>
        </div>

        <div class="form-group">
            <label for="permanent_address">Permanent Address:<span class="required-asterisk">*</span></label>
            <input type="text" name="permanent_address" value="<?php echo htmlspecialchars($validated_data['permanent_address']); ?>" required>
        </div>

        <!-- Moderator Password -->
        <div class="form-group">
            <label for="moderator_password">Moderator Password:<span class="required-asterisk">*</span></label>
            <input type="password" name="moderator_password" required>
            <?php if (!empty($moderator_error)): ?>
                <span style="color: red; font-size: 12px;"><?php echo htmlspecialchars($moderator_error); ?></span>
            <?php endif; ?>
        </div>


        <button type="submit" name="update_account">Update Account</button>
    </form>
    <button onclick="window.location.href='Account_Manager.php';">Back</button>
    <!-- Success Modal -->
    <div id="SuccessModal" class="SuccessModal">
        <div class="modal-content">
            <span id="closeSuccessModal" class="close">&times;</span>
            <h2>Success!</h2>
            <p>The account was updated successfully.</p>
        </div>
    </div>
</div>

<script>
    // Listen for form submission
    document.querySelector("form").addEventListener("submit", function(event) {
        var phone_number = document.getElementById("phone_number").value;

        // Check if phone number length is exactly 11 characters
        if (phone_number.length !== 11) {
            alert("Phone number must be exactly 11 characters.");
            event.preventDefault(); // Prevent form submission
        }
    });
</script>
<script>
    // Function to show the success modal
    function showUpdateSuccessModal() {
        var modal = document.getElementById("SuccessModal");
        modal.style.display = "block";
    }

    // Close the modal when the user clicks the 'X'
    document.getElementById("closeSuccessModal").onclick = function() {
        document.getElementById("SuccessModal").style.display = "none";
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        var successModal = document.getElementById("SuccessModal");
        if (event.target == successModal) {
            successModal.style.display = "none";
        }
    }

    // On page load, check for session variable to show the modal
    window.onload = function() {
        <?php if (isset($_SESSION['show_success_modal']) && $_SESSION['show_success_modal'] === true): ?>
            showUpdateSuccessModal();
            <?php unset($_SESSION['show_success_modal']); // Unset session variable to prevent it from reappearing ?>
        <?php endif; ?>
    }
    // Close the modal when the user clicks the 'X'
    document.getElementById("closeSuccessModal").onclick = function() {
        document.getElementById("SuccessModal").style.display = "none";
        window.location.href = "Account_Manager.php"; // Redirect to Account_Manager.php
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        var successModal = document.getElementById("SuccessModal");
        if (event.target == successModal) {
            successModal.style.display = "none";
            window.location.href = "Account_Manager.php"; // Redirect to Account_Manager.php
        }
    }
    </script>
</body>
</html>
