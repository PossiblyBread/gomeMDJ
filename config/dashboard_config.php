<?php
    include "../db_conn.php";

    // Inserting a new account
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
        $h_password = mysqli_real_escape_string($conn, $_POST['h_password']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        // Insert new account with auto-updated 'date_created' and 'updated_at'
        $sql_insert = "INSERT INTO `accounts` (`id`, `last_name`, `first_name`, `email`, `phone_num`, `h_password`, `role`, `date_created`, `updated_at`) 
                        VALUES (NULL, '$last_name', '$first_name', '$email', '$phone_num', '$h_password', '$role', NOW(), NOW())";
        
        if (!mysqli_query($conn, $sql_insert)) {
            die("Error inserting record: " . mysqli_error($conn));
        } else {
            // Log the creation of a new account in the change_log
            $account_id = mysqli_insert_id($conn);
            $log_sql = "INSERT INTO `change_log` (`account_id`, `change_type`) VALUES ($account_id, 'Account created')";
            mysqli_query($conn, $log_sql);
        }
    }

    // Editing role
    if (isset($_POST['Save'])) {
        // Ensure the `id` is obtained from POST and sanitized
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
        
        // SQL query to update the role
        $sql = "UPDATE `accounts` SET `role` = ?, `updated_at` = NOW() WHERE `id` = ?";
        
        // Prepare statement to prevent SQL injection
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "si", $role, $id);
            
            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                // Log the role update in the change_log
                $log_sql = "INSERT INTO `change_log` (`account_id`, `change_type`) VALUES ($id, 'Role updated')";
                mysqli_query($conn, $log_sql);
                
                // Redirect to the dashboard after success
                header("Location: ../index.php");
                exit(); // Always exit after redirecting
            } else {
                echo "Failed: " . mysqli_stmt_error($stmt);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Failed to prepare statement: " . mysqli_error($conn);
        }
    }

    // Select all accounts
    $sql_select = "SELECT * FROM accounts";
    $result = mysqli_query($conn, $sql_select);
?>
