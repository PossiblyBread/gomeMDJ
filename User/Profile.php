<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <form id="profile-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" value="JohnDoe" disabled class="short-input">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" value="johndoe@example.com" disabled class="short-input">
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" value="123-456-7890" disabled class="short-input">
            </div>
            <div class="button-group">
                <button type="button" id="edit-btn">Edit Profile</button>
                <button type="submit" id="save-btn" disabled>Save Changes</button>
            </div>
        </form>
        <div class="transaction-history">
            <h2>Transaction History</h2>
            <table>
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
        <div class="dues">
            <h2>Dues:</h2>
            <p>No outstanding dues.</p>
        </div>
    </div>
    
</body>
</html>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

h2 {
    color: #444;
    margin-top: 30px;
    margin-bottom: 10px;
}

.form-group {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

label {
    margin-right: 10px; /* Set margin for label */
    font-weight: bold;
    width: 100px; /* Fixed width for labels for vertical alignment */
}

input[type="text"],
input[type="email"] {
    padding: 6px; /* Reduced padding further for smaller input */
    border: 1px solid #ccc;
    border-radius: 5px;
    flex-grow: 1; /* Allow input fields to grow */
    margin-left: 10px; /* Space between label and input */
    width: 75px; /* Set a smaller width for input fields (50% reduction) */
}

.button-group {
    display: flex;
    justify-content: center; /* Center buttons */
    margin-top: 20px; /* Space above buttons */
}

button {
    padding: 10px 15px;
    margin-right: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button#edit-btn {
    background-color: #007bff;
    color: white;
}

button#save-btn {
    background-color: #28a745;
    color: white;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}

</style>