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
    <link rel="stylesheet" href="../assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
    <div id="overlay"></div>

    <br><br><br>
    <main class="accounts">
        <div class="container">
            <h2 class="page-title">User Information</h2>

            <!-- Account details section -->
            <section class="account-details card">
                <h3>Account Details</h3>
                <div class="table-wrapper">
                    <table>
                        <tr>
                            <th>Serial Number</th>
                            <td><?php echo htmlspecialchars($account_data['serial_num']); ?></td>
                        </tr>
                        <tr>
                            <th>First Name</th>
                            <td><?php echo htmlspecialchars($account_data['first_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td><?php echo htmlspecialchars($account_data['last_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($account_data['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td><?php echo htmlspecialchars($account_data['phone_num']); ?></td>
                        </tr>
                    </table>
                </div>
            </section>

            <?php if ($validation_status === "Validated"): ?>
                <!-- Display validated user data -->
                <section class="validated-details card">
                    <h3>User Details</h3>
                    <div class="table-wrapper">
                        <table>
                            <tr>
                                <th>Given Name</th>
                                <td><?php echo htmlspecialchars($validated_data['given_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Middle Name</th>
                                <td><?php echo htmlspecialchars($validated_data['middle_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td><?php echo htmlspecialchars($validated_data['last_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Marital Status</th>
                                <td><?php echo htmlspecialchars($validated_data['marital_status']); ?></td>
                            </tr>
                            <tr>
                                <th>Birth Date</th>
                                <td><?php echo htmlspecialchars($validated_data['birth_date']); ?></td>
                            </tr>
                            <tr>
                                <th>TIN Number</th>
                                <td><?php echo htmlspecialchars($validated_data['tin_number']); ?></td>
                            </tr>
                            <tr>
                                <th>Present Address</th>
                                <td><?php echo htmlspecialchars($validated_data['present_address']); ?></td>
                            </tr>
                            <tr>
                                <th>Permanent Address</th>
                                <td><?php echo htmlspecialchars($validated_data['permanent_address']); ?></td>
                            </tr>
                        </table>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Change Password Section -->
            <section class="change-password card">
                <h3>Change Password</h3>

                <?php if (isset($error_message)): ?>
                    <div class="message error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($success_message)): ?>
                    <div class="message success-message">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" class="password-form">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <div class="password-input">
                            <input type="password" name="current_password" id="current_password" required>
                            <button type="button" class="toggle-password">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <div class="password-input">
                            <input type="password" name="new_password" id="new_password" required>
                            <button type="button" class="toggle-password">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_new_password">Confirm New Password</label>
                        <div class="password-input">
                            <input type="password" name="confirm_new_password" id="confirm_new_password" required>
                            <button type="button" class="toggle-password">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" name="change_password" class="btn-submit">
                        <i class="fas fa-key"></i>
                        Change Password
                    </button>
                </form>
            </section>
        </div>
    </main>

    <!-- ai chat bot -->
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
    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
    <script src="../js/script.js"></script>
</body>

</html>

<style>
    :root {
        --primary-color: #4A90E2;
        --secondary-color: #82B1FF;
        --accent-color: #64B5F6;
        --success-color: #81C784;
        --error-color: #E57373;
        --text-primary: #2C3E50;
        --text-secondary: #546E7A;
        --background: #CBDCEB;
        --card-bg: #FFFFFF;
        --border-color: #E0E6ED;
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
        --transition-speed: 0.3s;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background-color: var(--background);
        color: var(--text-primary);
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .page-title {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 2rem;
        text-align: center;
        font-weight: 600;
    }

    .card {
        background: var(--card-bg);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        transition: transform var(--transition-speed), box-shadow var(--transition-speed);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .card h3 {
        color: var(--text-primary);
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }

    .table-wrapper {
        overflow-x: auto;
        border-radius: 10px;
        box-shadow: var(--shadow-sm);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }

    th,
    td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    th {
        background-color: rgba(74, 144, 226, 0.1);
        color: var(--text-primary);
        font-weight: 500;
    }

    tr:hover {
        background-color: rgba(74, 144, 226, 0.05);
    }

    .password-form {
        max-width: 500px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .password-input {
        position: relative;
    }

    .form-group input {
        width: 100%;
    }

    input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        transition: all var(--transition-speed);
    }

    input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    .toggle-password {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        padding: 0.5rem;
    }

    .btn-submit {
        width: 100%;
        padding: 1rem;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background var(--transition-speed);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-submit:hover {
        background: var(--accent-color);
    }

    .message {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .error-message {
        background-color: rgba(229, 115, 115, 0.1);
        color: var(--error-color);
        border: 1px solid var(--error-color);
    }

    .success-message {
        background-color: rgba(129, 199, 132, 0.1);
        color: var(--success-color);
        border: 1px solid var(--success-color);
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        .page-title {
            font-size: 2rem;
        }

        .card {
            padding: 1.5rem;
        }

        table {
            font-size: 0.9rem;
        }

        th,
        td {
            padding: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.75rem;
        }

        .card h3 {
            font-size: 1.25rem;
        }

        input,
        .btn-submit {
            font-size: 0.9rem;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Accessibility */
    :focus {
        outline: 3px solid var(--primary-color);
        outline-offset: 2px;
    }

    /* Print styles */
    @media print {
        .change-password {
            display: none;
        }
    }
</style>