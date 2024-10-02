<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../styles/ledger_style.css"/>
    
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
    <div class="table-container">
        <h2>Financial Ledger</h2>
        <div class="search-wrapper">
            <div class="search-container-1">
                <input type="text" id="search-input-1" placeholder="Find Id">
                <button id="ID_search_button">Search</button>
            </div>
            <div class="search-container-2">
                <input type="text" id="search-input-2" placeholder="Find Name">
                <button id="Name_search_button">Search</button>
            </div>
            <div class="checkbox-container">
                <input type="checkbox" id="increment-checkbox">
                <label for="increment-checkbox">Enable Increment</label>
            </div>
        </div>
        <table class="acc_table">
            <thead>
                <tr>
                    <th>Account ID</th>
                    <th>Account Name</th>
                    <th>:3</th>
                </tr>
            </thead>
            <tbody>
                <tr class="main-row">
                    <td>1</td>
                    <td>ACC001</td>
                    <th><button class="show-button">Show</button></th>
                </tr>
                <tr class="expandable-content" style="display: none;">
                    <td colspan="3">
                        <table class="nested-table">
                            <thead>
                                <tr>
                                    <th>Remaining Balance</th>
                                    <th>Total Paid Balance</th>
                                    <th>Due</th>
                                    <th>Due Date</th>
                                    <th>Dues Sent</th>
                                    <th>Dues Remaining</th>
                                    <th>Due Status</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>$1,200.00</td>
                                    <td>$800.00</td>
                                    <td>$400.00</td>
                                    <td>2024-09-15</td>
                                    <td>$300.00</td>
                                    <td>$100.00</td>
                                    <td>Incomplete</td>
                                    <td>2024-08-26</td>
                                    <td>14:30</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr class="main-row">
                    <td>2</td>
                    <td>ACC002</td>
                    <th><button class="show-button">Show</button></th>
                </tr>
                <tr class="expandable-content" style="display: none;">
                    <td colspan="3">
                        <table class="nested-table">
                            <thead>
                                <tr>
                                    <th>Remaining Balance</th>
                                    <th>Total Paid Balance</th>
                                    <th>Due</th>
                                    <th>Due Date</th>
                                    <th>Dues Sent</th>
                                    <th>Dues Remaining</th>
                                    <th>Due Status</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>$750.00</td>
                                    <td>$500.00</td>
                                    <td>$250.00</td>
                                    <td>2024-10-01</td>
                                    <td>$250.00</td>
                                    <td>$0.00</td>
                                    <td>Settled</td>
                                    <td>2024-08-26</td>
                                    <td>15:00</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="../js/ledger_script.js"></script>
</body>
</html>
