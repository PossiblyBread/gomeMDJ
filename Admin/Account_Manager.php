<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
include "../db_conn.php";

// Initialize search variables
$search_query = '';
$show_table = false;

// Check if the session already has search results, and if not, initialize it
if (!isset($_SESSION['search_results'])) {
    $_SESSION['search_results'] = [];
}

if (isset($_POST['search_button'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);

    if (!empty($search_query)) {
        // Only show table if there's a search query
        $sql = "SELECT * FROM `accounts` WHERE (`serial_num` = '$search_query' OR `email` = '$search_query')";

        $result = mysqli_query($conn, $sql);

        // Reset session with new results
        $_SESSION['search_results'] = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['search_results'][] = $row;
            }
            $show_table = true; // Set to true only if results are found
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Account Manager</title>
</head>

<body>
    <?php include 'side-nav.php'; ?>
    <div class="main-content">
        <h2>User Account Data</h2>
        <form method="post" action="">
            <div class="search-wrapper">
                <div class="search-container">
                    <input type="text" id="search-input" name="search_query" placeholder="Find by Serial Number or Email" value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" name="search_button">Search</button>
                </div>
            </div>
        </form>

        <div>
            <table class="accounts <?php echo $show_table ? 'show' : ''; ?>">
                <tr>
                    <th>Serial ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Edit Account</th>
                    <th>Validate User</th>
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
                                <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="edit-button">Edit</a>
                            </td>
                            <td>
                                <a href="validate_user.php?id=<?php echo $row['id']; ?>" class="validate-button">Validate</a>
                            </td>
                            <td><?php echo $row["date_created"] ?></td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='10'>No records found</td></tr>";
                }
                ?>
            </table>
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
    </div>
</body>

</html>
<style>
    /* Main content styles */
    body {
        margin-left: 150px;
    }

    .main-content {
        margin: 20px;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        margin-top: 0;
    }

    /* Hide the table by default */
    .accounts {
        display: none;
    }

    /* Show the table when there are search results */
    .accounts.show {
        display: table;
    }

    /* Search form styles */
    .search-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-container {
        flex: 1;
    }

    .search-container input {
        width: 300px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .search-container button {
        padding: 8px 12px;
        margin-left: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-container button:hover {
        background-color: #0056b3;
    }

    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
    }

    /* Centering buttons */
    td {
        text-align: center;
    }

    /* Button styles */
    .edit-button,
    .validate-button {
        display: inline-block;
        padding: 8px 12px;
        margin: 0 5px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .edit-button:hover {
        background-color: #218838;
    }

    .validate-button {
        background-color: #007bff;
    }

    .validate-button:hover {
        background-color: #0056b3;
    }
</style>