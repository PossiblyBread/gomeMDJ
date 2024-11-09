<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); 
include_once PROJECT_ROOT . "/db_conn.php";

    if (isset($_POST['submit'])) {
        $user_id = $_POST['user_id']; 
        $user_name = $_POST['user_name'];
        $product_id = $_POST['product_id']; 
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price']; 
        $due_date = $_POST['due_date']; 
        $due_to_be_paid = $_POST['due_to_be_paid']; 
        $due_paid = $_POST['due_paid'];
        $due_missed = $_POST['due_missed']; 
        $due_paid_date = $_POST['due_paid_date']; 
        $dues_remaining = $_POST['dues_remaining']; 
        $due_status = $_POST['due_status']; 
       
        $sql = "INSERT INTO `ledger_tb` (`id`, `user_id`, `user_name`, `product_id`, `product_name`, `product_price`, 
                        `due_date`, `due_to_be_paid`, `due_paid`, `due_missed`, `due_paid_date`, `dues_remaining`, `due_status`) 
                     VALUES (NULL, '$user_id', '$user_name', '$product_id', '$product_name', '$product_price', '$due_date', 
                        '$due_to_be_paid', '$due_paid_date', '$due_missed', '$due_paid_date', '$dues_remaining', '$due_status')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
                header("Location: order_entry.php? msg=Order Created Successfully!");
            exit; 
        } else {
            echo "Failed: " . mysqli_error($conn);
        }   
    }

?>