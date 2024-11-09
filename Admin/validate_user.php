<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
include "../db_conn.php";

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
        // If no existing validated data, initialize empty array
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

// Handle form submission to insert data into `validated_tb` and update the validation column in `accounts`
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    // Capture the moderator password and verify it
    $moderator_password = mysqli_real_escape_string($conn, $_POST['moderator_password']);
    if (!validateModeratorPassword($moderator_password)) {
        echo "Invalid moderator password.";
        exit();
    }

    // Proceed with inserting data into `validated_tb` and updating `accounts` if the moderator password is correct
    $given_name = mysqli_real_escape_string($conn, $_POST['given_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $marital_status = mysqli_real_escape_string($conn, $_POST['marital_status']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $tin_number = mysqli_real_escape_string($conn, $_POST['tin_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $present_address = mysqli_real_escape_string($conn, $_POST['present_address']);
    $permanent_address = mysqli_real_escape_string($conn, $_POST['permanent_address']);
    
    // Step 1: Insert the new data into the `validated_tb` table
    $insert_validated_sql = "INSERT INTO `validated_tb` (
        `id`, `serial_num`, `given_name`, `middle_name`, `last_name`, 
        `marital_status`, `birth_date`, `phone_number`, `tin_number`, 
        `email`, `present_address`, `permanent_address`
    ) VALUES (
        '$id', '" . mysqli_real_escape_string($conn, $account['serial_num']) . "', '$given_name', 
        '$middle_name', '$last_name', '$marital_status', '$birth_date', 
        '$phone_number', '$tin_number', '$email', '$present_address', '$permanent_address'
    )";

    if (mysqli_query($conn, $insert_validated_sql)) {
        // Step 2: Update the `accounts` table to set the `validation` column to 'Validated'
        $update_validation_sql = "UPDATE `accounts` SET `validation` = 'Validated' WHERE `id` = '$id'";

        if (mysqli_query($conn, $update_validation_sql)) {
            echo "Account data uploaded successfully and validation status updated.";
            header("Location: Account_Manager.php"); // Redirect after successful update
            exit();
        } else {
            echo "Error updating validation status: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting data into validated table: " . mysqli_error($conn);
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
            width: 100%;
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
            <label for="given_name">Given Name:</label>
            <input type="text" name="given_name" value="<?php echo htmlspecialchars($validated_data['given_name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" value="<?php echo htmlspecialchars($validated_data['middle_name']); ?>">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($validated_data['last_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="marital_status">Marital Status:</label>
            <select name="marital_status" required>
                <option value="Single" <?php echo $validated_data['marital_status'] === 'Single' ? 'selected' : ''; ?>>Single</option>
                <option value="Married" <?php echo $validated_data['marital_status'] === 'Married' ? 'selected' : ''; ?>>Married</option>
                <option value="Divorced" <?php echo $validated_data['marital_status'] === 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                <option value="Widowed" <?php echo $validated_data['marital_status'] === 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
            </select>
        </div>

        <div class="form-group">
            <label for="birth_date">Birth Date:</label>
            <input type="date" name="birth_date" value="<?php echo htmlspecialchars($validated_data['birth_date']); ?>" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" value="<?php echo htmlspecialchars($validated_data['phone_number']); ?>" required>
        </div>

        <div class="form-group">
            <label for="tin_number">TIN Number:</label>
            <input type="text" name="tin_number" value="<?php echo htmlspecialchars($validated_data['tin_number']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($validated_data['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="present_address">Present Address:</label>
            <input type="text" name="present_address" value="<?php echo htmlspecialchars($validated_data['present_address']); ?>" required>
        </div>

        <div class="form-group">
            <label for="permanent_address">Permanent Address:</label>
            <input type="text" name="permanent_address" value="<?php echo htmlspecialchars($validated_data['permanent_address']); ?>" required>
        </div>

        <!-- Moderator Password -->
        <div class="form-group">
            <label for="moderator_password">Moderator Password:</label>
            <input type="password" name="moderator_password" required>
        </div>

        <button type="submit" name="update_account">Update Account</button>
    </form>
</div>

</body>
</html>
