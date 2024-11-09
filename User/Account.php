<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

include "../db_conn.php";

// Check if user is logged in and their session exists
if (!isset($_SESSION['id'])) {
    die("Access denied. Please log in first.");
}

$id = $_SESSION['id'];  // Assume user ID is stored in session
$validation_status = '';

// Fetch the user's current password from the accounts table
$sql = "SELECT validation, h_password FROM `accounts` WHERE `id` = '$id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $validation_status = $row['validation'];  // Get validation status
    $current_hashed_password = $row['h_password'];  // Get the current hashed password
} else {
    die("Error fetching user data.");
}

// Fetch basic account information from the accounts table
$sql_account = "SELECT `serial_num`, `first_name`, `last_name`, `email`, `phone_num` FROM `accounts` WHERE `id` = '$id'";
$account_result = mysqli_query($conn, $sql_account);
if ($account_result) {
    $account_data = mysqli_fetch_assoc($account_result);
} else {
    die("Error fetching account data.");
}

// If the user is validated, fetch additional data from validated_tb
if ($validation_status === "Validated") {
    $sql_validated = "SELECT * FROM `validated_tb` WHERE `serial_num` = (SELECT `serial_num` FROM `accounts` WHERE `id` = '$id')";
    $validated_result = mysqli_query($conn, $sql_validated);
    if ($validated_result) {
        $validated_data = mysqli_fetch_assoc($validated_result);
    } else {
        die("Error fetching validated data.");
    }
}

// Handle change password form submission
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Check if current password matches the one in the database
    if (!password_verify($current_password, $current_hashed_password)) {
        $error_message = "Current password is incorrect!";
    } elseif ($new_password !== $confirm_new_password) {
        $error_message = "New passwords do not match!";
    } elseif (strlen($new_password) < 6) {
        $error_message = "New password must be at least 6 characters long!";
    } else {
        // Hash the new password and update it in the database
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql_update = "UPDATE `accounts` SET `h_password` = ? WHERE `id` = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("si", $new_hashed_password, $id);

        if ($stmt->execute()) {
            $success_message = "Password changed successfully!";
        } else {
            $error_message = "Failed to update password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../styles/styles2.css">
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
    
    <br><br><br>
    <main class="accounts">
        <div class="container">
            <h2>User Information</h2>

            <!-- Account details section -->
            <section class="account-details">
                <h3>Account Details</h3>
                <table>
                    <tr><th>Serial Number</th><td><?php echo htmlspecialchars($account_data['serial_num']); ?></td></tr>
                    <tr><th>First Name</th><td><?php echo htmlspecialchars($account_data['first_name']); ?></td></tr>
                    <tr><th>Last Name</th><td><?php echo htmlspecialchars($account_data['last_name']); ?></td></tr>
                    <tr><th>Email</th><td><?php echo htmlspecialchars($account_data['email']); ?></td></tr>
                    <tr><th>Phone Number</th><td><?php echo htmlspecialchars($account_data['phone_num']); ?></td></tr>
                </table>
            </section>

            <!-- Change Password Section -->
            <section class="change-password">
                <h3>Change Password</h3>

                <?php if (isset($error_message)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>

                <?php if (isset($success_message)): ?>
                    <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <label for="current_password">Current Password:</label>
                    <input type="password" name="current_password" id="current_password" required>

                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" id="new_password" required>

                    <label for="confirm_new_password">Confirm New Password:</label>
                    <input type="password" name="confirm_new_password" id="confirm_new_password" required>

                    <button type="submit" name="change_password">Change Password</button>
                </form>
            </section>

            <?php if ($validation_status === "Validated"): ?>
                <!-- Display validated user data -->
                <section class="validated-details">
                    <h3>User Details</h3>
                    <table>
                        <tr><th>Given Name</th><td><?php echo htmlspecialchars($validated_data['given_name']); ?></td></tr>
                        <tr><th>Middle Name</th><td><?php echo htmlspecialchars($validated_data['middle_name']); ?></td></tr>
                        <tr><th>Last Name</th><td><?php echo htmlspecialchars($validated_data['last_name']); ?></td></tr>
                        <tr><th>Marital Status</th><td><?php echo htmlspecialchars($validated_data['marital_status']); ?></td></tr>
                        <tr><th>Birth Date</th><td><?php echo htmlspecialchars($validated_data['birth_date']); ?></td></tr>
                        <tr><th>TIN Number</th><td><?php echo htmlspecialchars($validated_data['tin_number']); ?></td></tr>
                        <tr><th>Present Address</th><td><?php echo htmlspecialchars($validated_data['present_address']); ?></td></tr>
                        <tr><th>Permanent Address</th><td><?php echo htmlspecialchars($validated_data['permanent_address']); ?></td></tr>
                    </table>
                </section>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    <script>
        window.embeddedChatbotConfig = {
            chatbotId: "e8_c510p3vG8EPF2g33Vw",
            domain: "www.chatbase.co"
        }
    </script>
    <script
        src="https://www.chatbase.co/embed.min.js"
        chatbotId="e8_c510p3vG8EPF2g33Vw"
        domain="www.chatbase.co"
        defer>
    </script>

    </script>
    <script src="../js/script.js"></script>
</body>
</html>
<style>
/* Style for the account details section */
.account-details {
    background-color: #f9f9f9;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 50%; 
    margin-left: auto; 
    margin-right: auto; 
}

.account-details h3 {
    color: #333;
}

.account-details table {
    width: 100%;
    border-collapse: collapse;
}

.account-details th, .account-details td {
    padding: 10px;
    border: 1px solid #ddd;
}

/* Style for the validated details section */
.validated-details {
    background-color: #e6f7ff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 50%; 
    margin-top: 30px;
    margin-left: auto;
    margin-right: auto; 
}

.validated-details h3 {
    color: #007bff;
}

.validated-details table {
    width: 100%;
    border-collapse: collapse;
}

.validated-details th, .validated-details td {
    padding: 10px;
    border: 1px solid #ddd;
}

/* Style for the change password section */
.change-password {
    background-color: #f1f1f1;
    padding: 20px;
    margin-top: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 50%; 
    margin-left: auto;
    margin-right: auto; 
}

.change-password h3 {
    color: #333;
}

.change-password form {
    display: flex;
    flex-direction: column;
}

.change-password label {
    margin-top: 10px;
}

.change-password input {
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.change-password button {
    margin-top: 15px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

.change-password button:hover {
    background-color: #45a049;
}

.success-message, .error-message {
    margin-top: 10px;
    padding: 10px;
    border-radius: 4px;
    color: white;
}

.success-message {
    background-color: #4CAF50;
}

.error-message {
    background-color: #f44336;
}
@media (max-width: 7200px) {
    .account-details {
        margin-top: 30px;
        width: 80%;
    }
    .validated-details {
        width: 80%; /* Set width to 50% */
    }
}
</style>

