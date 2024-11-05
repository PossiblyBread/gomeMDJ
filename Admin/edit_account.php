<?php
session_start();
include "../db_conn.php";

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

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
        header("Location: account_manager.php"); // Redirect back after successful update
        exit();
    } else {
        echo "Error updating account: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Account</title>
</head>
<body>
    <h2>Edit Account</h2>
    
    <form method="post">
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($account['first_name']); ?>" required>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($account['last_name']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($account['email']); ?>" required>
        <input type="text" name="phone_num" value="<?php echo htmlspecialchars($account['phone_num']); ?>" required>
        <select name="role" required>
            <option value="user" <?php echo $account['role'] === 'user' ? 'selected' : ''; ?>>User</option>
            <option value="IT_Support" <?php echo $account['role'] === 'IT_Support' ? 'selected' : ''; ?>>IT Support</option>
            <option value="Admin" <?php echo $account['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
        </select>
        <button type="submit">Update Account</button>
    </form>
</body>
</html>
