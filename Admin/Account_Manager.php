<?php
session_start();
include "../db_conn.php";

// Initialize search variables
$search_id = '';
$search_name = '';
$show_table = false;
$increment = isset($_POST['increment']) ? $_POST['increment'] : false;

// Check if the session already has search results, and if not, initialize it
if (!isset($_SESSION['search_results'])) {
    $_SESSION['search_results'] = [];
}

if (isset($_POST['ID_search_button'])) {
    $search_id = mysqli_real_escape_string($conn, $_POST['search_id']);
    $show_table = true;
}

if (isset($_POST['Name_search_button'])) {
    $search_name = mysqli_real_escape_string($conn, $_POST['search_name']);
    $show_table = true;
}

$sql = "SELECT * FROM `accounts` WHERE 1=1";

if (!empty($search_id)) {
    $sql .= " AND `Serial_Num` = '$search_id'";
}

if (!empty($search_name)) {
    $sql .= " AND (`last_name` LIKE '%$search_name%' OR `first_name` LIKE '%$search_name%')";
}

$result = mysqli_query($conn, $sql);

// If "increment" is enabled, add the new results to the session
if ($increment && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['search_results'][] = $row;
    }
} else {
    // If "increment" is not enabled, reset the session with new results
    $_SESSION['search_results'] = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['search_results'][] = $row;
        }
    }
}
$show_table_class = $show_table && !empty($_SESSION['search_results']) ? '' : 'hidden';
// Handle role change confirmation
$message = '';
if (isset($_POST['confirm-role-change'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check password
    if (validateModeratorPassword($password)) {
        $update_sql = "UPDATE `accounts` SET `role` = '$role' WHERE `id` = '$id'";
        if (mysqli_query($conn, $update_sql)) {
            $message = 'Role updated successfully.';
        } else {
            $message = 'Error updating role.';
        }
    } else {
        $message = 'Invalid password.';
    }
}

function validateModeratorPassword($password) {
    // Check if the password is correct
    return $password === 'admin1234';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/account_manager_style.css"/>
    <title>Account Manager</title>
    <style>
        /* Hide the table by default */
        .accounts {
            display: none;
        }

        /* Show the table when there are search results */
        <?php if (!empty($_SESSION['search_results'])): ?>
        .accounts {
            display: table;
        }
        <?php endif; ?>
    </style>
</head>
<body>
    <nav class="right-navbar">
    <ul>
        <li><a href="Dashboard.php">Dashboard</a></li>
        <li><a href="admin_view.php" data-modal="home-modal">Home</a></li>
        <li><a href="Ledger.php">Ledger</a></li>
        <li><a href="upload_product.php">Add new Product</a></li>
        <li><a href="order_entry.php">Create new Order</a></li>
        <li><a href="Account_Manager.php">User Account Data</a></li>
        <li><a href="" data-modal="tickets-modal" data-url="itsupport.php">Tickets</a></li>
        <li><a href="" data-modal="logout-modal">Log Out</a></li>
    </ul>
    </nav>

    <div class="main-content">
    <h2>User Account Data</h2>
    <form method="post" action="">
        <div class="search-wrapper">
            <div class="search-container-1">
                <input type="text" id="search-input-1" name="search_id" placeholder="Find Id" value="<?php echo htmlspecialchars($search_id); ?>">
                <button type="submit" name="ID_search_button">Search</button>
            </div>
            <div class="search-container-2">
                <input type="text" id="search-input-2" name="search_name" placeholder="Find Name" value="<?php echo htmlspecialchars($search_name); ?>">
                <button type="submit" name="Name_search_button">Search</button>
            </div>
            <div class="checkbox-container">
                <input type="checkbox" id="increment-checkbox" name="increment" <?php if ($increment) echo 'checked'; ?>>
                <label for="increment-checkbox">Enable Increment</label>
            </div>
        </div>
    </form>

    <div class="<?php echo $show_table_class; ?>">
        <table class="accounts">
            <tr>
                <th>Serial ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <!-- <th>View Transaction History</th> -->
                <th>Role</th>
                <th>Date Created</th> 
            </tr>

            <?php
            if (!empty($_SESSION['search_results'])) {
                foreach ($_SESSION['search_results'] as $row) {
            ?>
                <tr>
                    <td><?php echo $row["Serial_Num"] ?></td>
                    <td><?php echo $row["last_name"] ?></td>
                    <td><?php echo $row["first_name"] ?></td>
                    <td><?php echo $row["email"] ?></td>
                    <td><?php echo $row["phone_num"] ?></td>
                    <!-- <td><a href="ledger.php"> ey</a></td> -->
                    <td>
                        <form id="role-form-<?php echo $row['id']; ?>" action="" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <select name="role" id="role-<?php echo $row['id']; ?>">
                                <?php
                                    $roles = ['User', 'IT Support', 'Admin'];
                                    foreach ($roles as $role) {
                                        $selected = ($role == $row["role"]) ? 'selected' : '';
                                        echo "<option value=\"$role\" $selected>$role</option>";
                                    }
                                ?>
                            </select>
                            <button type="button" onclick="openModal('<?php echo $row['id']; ?>')">Save</button>
                        </form>
                    </td>
                    <td><?php echo $row["date_time"] ?></td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </table>
    </div>

    <!-- Modal for role change confirmation -->
    <div id="roleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Confirm Role Change</h2>
            <form id="modal-form" action="" method="post">
                <input type="hidden" name="id" id="modal-id">
                <input type="hidden" name="role" id="modal-role">
                <label for="password">Moderator Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" name="confirm-role-change">Confirm</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            const roleSelect = document.getElementById('role-' + id);
            document.getElementById('modal-id').value = id;
            document.getElementById('modal-role').value = roleSelect.value;
            document.getElementById('roleModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('roleModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target === document.getElementById('roleModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>
