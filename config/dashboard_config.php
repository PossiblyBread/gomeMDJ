<?php
    include "../db_conn.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
        $h_password = mysqli_real_escape_string($conn, $_POST['h_password']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        $sql_insert = "INSERT INTO `accounts` (`id`, `last_name`, `first_name`, `email`, `phone_num`, `h_password`, `role`) 
                        VALUES (NULL, '$last_name', '$first_name', '$email', '$phone_num', '$h_password', '$role')";
        if (!mysqli_query($conn, $sql_insert)) {
            die("Error inserting record: " . mysqli_error($conn));
        }
    }
    //edit role
    if (isset($_POST['Save'])) {
        // Ensure the `id` is obtained from POST and is sanitized
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
    
        // SQL query to update the role
        $sql = "UPDATE `accounts` SET `role` = ? WHERE `id` = ?";
    
        // Prepare statement to prevent SQL injection
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "si", $role, $id);
    
            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                  // Redirect to the dashboard after success
                header("Location: ../Admin/Dashboard.php");
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

    
    $sql_select = "SELECT * FROM accounts";
    $result = mysqli_query($conn, $sql_select);

?>