<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

include "../config/home_config.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    
</head>
<body>
    <?php include '../body/logged/header.php'; ?>
    <?php include '../body/logged/side-bar.php'; ?>
    <main class="accounts">
        <div class="accounts-container">
            <h1>User Profile</h1>
            <form id="profile-form" class="accounts-form">
                <div class="accounts-field">
                    <label for="username">Username:</label>
                    <input type="text" id="username" value="JohnDoe" class="accounts-input">
                </div>
                <div class="accounts-field">
                    <label for="email">Email:</label>
                    <input type="email" id="email" value="johndoe@example.com" class="accounts-input">
                </div>
                <div class="accounts-field">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" value="123-456-7890" class="accounts-input">
                </div>
                <div class="accounts-buttons">
                    <button type="button" id="edit-btn" class="accounts-button">Edit Profile</button>
                    <button type="submit" id="save-btn" class="accounts-button" disabled>Save Changes</button>
                </div>
            </form>
            <div class="accounts-transaction-history">
                <h2>Transaction History</h2>
                <table class="accounts-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="transactions">
                        <tr>
                            <td>2023-10-01</td>
                            <td>$50.00</td>
                            <td>Completed</td>
                        </tr>
                        <tr>
                            <td>2023-10-02</td>
                            <td>$30.00</td>
                            <td>Completed</td>
                        </tr>
                        <tr>
                            <td>2023-10-03</td>
                            <td>$20.00</td>
                            <td>Pending</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="accounts-dues">
                <h2>Dues:</h2>
                <p>No outstanding dues.</p>
            </div>
        </div>
    </main>

    <?php include '../body/logged/footer.php'; ?>
</body>
</html>
<style>
    .accounts {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    color: #333;
    padding: 20px;
}

.accounts-container {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.accounts-form {
    margin-bottom: 20px;
}

.accounts-field {
    margin-bottom: 15px;
}

.accounts-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}

.accounts-buttons {
    display: flex;
    justify-content: space-between;
}

.accounts-button {
    padding: 10px 15px;
    border: none;
    border-radius: 3px;
    background-color: #ccc;
    cursor: pointer;
}

.accounts-button:hover {
    background-color: #bbb;
}

.accounts-transaction-history {
    margin-top: 20px;
}

.accounts-table {
    width: 100%;
    border-collapse: collapse;
}

.accounts-table th, .accounts-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}

.accounts-table th {
    background-color: #e0e0e0;
}

.accounts-dues {
    margin-top: 20px;
}
</style>