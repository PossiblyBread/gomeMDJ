<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

include_once "../db_conn.php";

// Number of items to display per page
$items_per_page = 15;

// Get the current page from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the OFFSET based on the current page
$offset = ($page - 1) * $items_per_page;

// Query to fetch the feedback data for the current page
$sql = "SELECT id, user_type, feedback_rating, feedback_comment FROM website_feedback LIMIT $items_per_page OFFSET $offset";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error retrieving feedback: " . mysqli_error($conn));
}

// Query to count total number of feedback entries
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM website_feedback");
$total_row = mysqli_fetch_assoc($total_result);
$total_feedback = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_feedback / $items_per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>

    <!-- Styles -->
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f4f8; /* Light blue-gray background */
        color: #333;
        display: flex;
        justify-content: flex-start; /* Align items to the start of the page */
        height: 100vh; /* Ensure full viewport height */
    }

    /* Sidebar - Side navigation */
    #side-nav {
        position: fixed;
        left: 0;
        top: 0;
        width: 150px;
        height: 100%;
        background-color: #1f3a6b; /* Dark Blue */
        color: white;
        padding-top: 20px;
        padding-left: 10px;
    }

    #side-nav a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 12px;
        margin: 5px 0;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    #side-nav a:hover {
        background-color: #3c70a2; /* Light Blue Hover */
    }

    /* Main content */
    .main-content {
        margin-left: 150px; /* Add left margin to accommodate the side-nav */
        padding: 20px;
        width: calc(100% - 150px); /* Adjust width of main content */
        display: flex;
        flex-direction: column;
        justify-content: flex-start; /* Keep items aligned at the top */
    }

    h3 {
        color: #2c5272; /* Muted blue */
        margin-bottom: 20px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: separate; /* Change from collapse to separate for rounded corners */
        border-spacing: 0; /* Ensure there is no spacing between cells */
        margin-bottom: 20px;
        border: 1px solid #c1d7e3; /* Add an outer border */
        border-radius: 12px; /* Round the edges of the table */
        overflow: hidden; /* Clip content inside rounded edges */
    }

    th, td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #4b7fa1; /* Medium Blue for header */
        color: white;
        border-bottom: 1px solid #c1d7e3; /* Maintain the appearance of rows */
    }

    td {
        border-bottom: 1px solid #c1d7e3; /* Light Blue border for rows */
    }

    tr:last-child td {
        border-bottom: none; /* Remove bottom border for the last row */
    }

    tr:nth-child(even) {
        background-color: #e8f2fb; /* Very light blue for even rows */
    }

    tr:nth-child(odd) {
        background-color: #f1f8fd; /* Light blue for odd rows */
    }


    /* Pagination */
    .pagination {
        margin-top: 20px;
        display: inline-block;
        text-align: center;
        width: 100%;
    }

    .pagination a {
        margin: 0 5px;
        padding: 8px 16px;
        color: #1f3a6b; /* Dark blue text */
        text-decoration: none;
        border: 1px solid #c1d7e3; /* Light Blue border */
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .pagination a:hover {
        background-color: #3c70a2; /* Light Blue Hover */
    }

    .pagination a.active {
        background-color: #4b7fa1; /* Medium blue for active page */
        color: white;
    }

    .pagination a.prev, .pagination a.next {
        font-weight: bold;
    }
</style>

</head>
<body>

    <!-- Side Navigation (included as side-nav.php) -->
    <?php include 'side-nav.php'; ?>

    <div class="main-content">
        <h3>User Feedback</h3>

        <table>
            <thead>
                <tr>
                    <th>User Type</th>
                    <th>Feedback Rating</th>
                    <th>Feedback Comment</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_type']) ?></td>
                        <td><?= htmlspecialchars($row['feedback_rating']) ?></td>
                        <td><?= htmlspecialchars($row['feedback_comment']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="prev">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="next">Next</a>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
