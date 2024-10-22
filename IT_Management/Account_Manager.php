<?php
session_start();
include "../db_conn.php";

// Initialize search variables
$search = '';
$show_table = false;
$increment = isset($_POST['increment']) ? $_POST['increment'] : false;

// Check if the session already has search results, and if not, initialize it
if (!isset($_SESSION['search_results'])) {
    $_SESSION['search_results'] = [];
}

if (isset($_POST['search_button'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $show_table = true;
}

$sql = "SELECT * FROM accounts WHERE 1=1";

if (!empty($search)) {
    // Search for an exact match with either serial number or email
    $sql .= " AND (serial_num = '$search' OR email = '$search')";
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

// Only show table if search has been performed and there are results
$show_table_class = (!empty($_SESSION['search_results']) && $show_table) ? '' : 'acc-man-hidden'; // Use acc-man-hidden for consistency
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Manager</title>
    <style>
        /* Centered main content */
        .acc-man-main-content {
            max-width: 800px; /* Consistent width for the content area */
            margin: 0 auto; /* Center the content */
            padding: 20px; /* Consistent padding */
            margin-left: 200px;
            text-align: center;
        }

        /* Search bar styling */
        .acc-man-search-wrapper {
            display: flex; /* Flexbox for horizontal alignment */
            justify-content: center; /* Center items */
            align-items: center; /* Align items vertically */
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 300px;
            padding: 10px; /* Consistent padding */
            border: 1px solid #ccc;
            border-radius: 5px; /* Rounded corners for consistency */
            margin-right: 10px; /* Space between search input and button */
        }

        button {
            padding: 10px 15px; /* Consistent padding */
            border: 1px solid #ccc;
            background-color: #d3d3d3;
            cursor: pointer;
            border-radius: 5px; /* Rounded corners for consistency */
        }

        button:hover {
            background-color: #ccc;
        }

        /* Checkbox for increment */
        .acc-man-checkbox-container {
            margin-left: 10px; /* Space between button and checkbox */
        }

        /* Table styling */
        table {
            width: 100%; /* Full width for consistency */
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #eaeaea;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 10px; /* Consistent padding */
        }

        th {
            background-color: #d3d3d3;
        }

        /* Hide the table initially */
        .acc-man-hidden {
            display: none;
        }

        /* Modal styling */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px; /* Place the modal content 60px from the top */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 5px; /* Rounded corners for consistency */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include '../body/IT/side-nav.php'; ?>

    <div class="acc-man-main-content">
        <h2>User Account Data</h2>
        <form method="post" action="">
            <div class="acc-man-search-wrapper">
                <input type="text" id="search-input" name="search" placeholder="Find by Serial Number or Name" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" name="search_button">Search</button>
                <div class="acc-man-checkbox-container">
                    <input type="checkbox" id="increment-checkbox" name="increment" <?php if ($increment) echo 'checked'; ?>>
                    <label for="increment-checkbox">Enable Increment</label>
                </div>
            </div>
        </form>

        <div class="<?php echo $show_table_class; ?>">
            <table class="acc-man-accounts">
                <tr>
                    <th>Serial Number</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Date Created</th> 
                </tr>

                <?php
                if (!empty($_SESSION['search_results'])) {
                    foreach ($_SESSION['search_results'] as $row) {
                ?>
                    <tr>
                        <td><?php echo $row["serial_num"] ?></td>
                        <td><?php echo $row["last_name"] ?></td>
                        <td><?php echo $row["first_name"] ?></td>
                        <td><?php echo $row["email"] ?></td>
                        <td><?php echo $row["phone_num"] ?></td>
                        <td>
                            <form id="role-form-<?php echo $row['id']; ?>" action="" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <select name="role" id="role-<?php echo $row['id']; ?>">
                                    <?php
                                        $roles = ['user', 'IT_Support', 'Admin'];
                                        foreach ($roles as $role) {
                                            $selected = ($role == $row["role"]) ? 'selected' : '';
                                            echo "<option value=\"$role\" $selected>$role</option>";
                                        }
                                    ?>
                                </select>
                                <button type="button" onclick="openModal('<?php echo $row['id']; ?>')">Save</button>
                            </form>
                        </td>
                        <td><?php echo $row["date_created"] ?></td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </table>
        </div>
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
