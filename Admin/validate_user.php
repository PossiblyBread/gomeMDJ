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

// Handle form submission for validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validation = mysqli_real_escape_string($conn, $_POST['validation']);
    $valid_id = $_FILES['valid_id'];

    // Handle file upload
    if ($valid_id['error'] === 0) {
        $valid_id_ext = pathinfo($valid_id['name'], PATHINFO_EXTENSION);
        $valid_id_path = 'valid_id/' . uniqid('', true) . '.' . $valid_id_ext;

        if (move_uploaded_file($valid_id['tmp_name'], $valid_id_path)) {
            // Update the additional_info table
            $given_name = mysqli_real_escape_string($conn, $_POST['given_name']);
            $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
            $last_name_extra = mysqli_real_escape_string($conn, $_POST['last_name_extra']);
            $present_address = mysqli_real_escape_string($conn, $_POST['present_address']);
            $permanent_address = mysqli_real_escape_string($conn, $_POST['permanent_address']);

            // Validate all fields are filled
            if ($validation === 'Validated' && empty($given_name) || empty($middle_name) || empty($last_name_extra) || empty($present_address) || empty($permanent_address)) {
                echo "Please fill all fields for validated accounts.";
            } 
            else {
                // Insert or update additional validation details
                $update_sql_additional = "INSERT INTO `additional_info` (`account_id`, `given_name`, `middle_name`, `last_name`, `present_address`, `permanent_address`, `valid_id`) VALUES 
                    ('$id', '$given_name', '$middle_name', '$last_name_extra', '$present_address', '$permanent_address', '$valid_id_path') 
                    ON DUPLICATE KEY UPDATE 
                    `given_name`='$given_name', 
                    `middle_name`='$middle_name', 
                    `last_name`='$last_name_extra', 
                    `present_address`='$present_address', 
                    `permanent_address`='$permanent_address', 
                    `valid_id`='$valid_id_path'";

                if (mysqli_query($conn, $update_sql_additional)) {
                    echo "Validation information updated successfully.";
                    header("Location: account_manager.php");
                    exit();
                } else {
                    echo "Error updating validation information: " . mysqli_error($conn);
                }
            }
        } else {
            echo "Failed to upload valid ID.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Validation Information</title>
    <script>
        function toggleValidationFields() {
            var validationSelect = document.getElementById('validation');
            var validationFields = document.getElementById('validation-fields');
            validationFields.style.display = validationSelect.value === 'Validated' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <h2>Validation Information</h2>

    <form method="post" enctype="multipart/form-data">
        <select name="validation" id="validation" required onchange="toggleValidationFields()">
            <option value="Pending" <?php echo $account['validation'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="Validated" <?php echo $account['validation'] === 'Validated' ? 'selected' : ''; ?>>Validated</option>
        </select>

        <div id="validation-fields" style="display: <?php echo $account['validation'] === 'Validated' ? 'block' : 'none'; ?>;">
            <input type="text" name="given_name" placeholder="Given Name" required>
            <input type="text" name="middle_name" placeholder="Middle Name" required>
            <input type="text" name="last_name_extra" placeholder="Last Name" required>
            <input type="text" name="present_address" placeholder="Present Address" required>
            <input type="text" name="permanent_address" placeholder="Permanent Address" required>
            <input type="file" name="valid_id" accept="image/*" required>
        </div>

        <button type="submit">Submit Validation</button>
    </form>
</body>
</html>
