<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h2 {
            margin-bottom: 1rem;
            color: #555;
        }
        .section {
            margin-bottom: 2rem;
        }
        .section label {
            display: block;
            margin-bottom: 0.5rem;
            color: #666;
        }
        .section select, .section button, .save-button {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .section button, .save-button {
            background-color: #5552ac;
            color: white;
            cursor: pointer;
        }
        .section button:hover, .save-button:hover {
            background-color: #444199;
        }
        .tutorial-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .tutorial-section label {
            margin: 0;
            color: #666;
            flex: 1;
        }

        .tutorial-section input[type="checkbox"] {
            margin-left: 0.5rem; /* Adjust this value as needed */
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 2rem;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-content h2 {
            margin-bottom: 1rem;
            color: #333;
        }
        .modal-content label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }
        .modal-content input {
            width: calc(100% - 1rem);
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .modal-content button {
            width: 100%;
            padding: 0.5rem;
            background-color: #5552ac;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .modal-content button:hover {
            background-color: #444199;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Settings</h1>
        
        <div class="section">
            <h2>Personalization</h2>
            <label for="font-size">Font Size</label>
            <select id="font-size" name="font-size">
                <option value="12">12</option>
                <option value="14">14</option>
                <option value="16">16</option>
                <option value="18">18</option>
                <option value="20">20</option>
                <option value="22">22</option>
                <option value="24">24</option>
            </select>
            
            <label for="theme">Theme/Color</label>
            <select id="theme" name="theme">
                <option value="light">Light</option>
                <option value="dark">Dark</option>
                <option value="dark">Monotone Gray</option>
                <option value="blue">Cool Blue</option>
                <option value="green">Fiery Red</option>
            </select>
        </div>
        
        <div class="section">
            <h2>Change Password</h2>
            <button type="button" id="change-password-btn">Change Password</button>
        </div>
        
        <div class="section tutorial-section">
            <label for="tutorial-guide">Tutorial Guide</label>
            <input type="checkbox" id="tutorial-guide" name="tutorial-guide">
        </div>
        
        <button class="save-button" type="button" id="save-changes-btn">Save Changes</button>
        <button class="save-button" type="button" id="back-btn" style="background-color: #ccc; color: #333;">Back</button>
    </div>
    
    <!-- The Modal -->
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Change Password</h2>
            
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new-password" placeholder="New Password">
            
            <label for="confirm-password">Confirm New Password</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm New Password">
            
            <button type="button" class="save-button">Save New Password</button>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("passwordModal");

        // Get the button that opens the modal
        var btn = document.getElementById("change-password-btn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Save Changes button functionality
        document.getElementById("save-changes-btn").onclick = function() {
            console.log("Save Changes button clicked"); // Debugging message
            window.location.href = "Guest.html"; // Replace with the desired path
        }

        // Back button functionality
        document.getElementById("back-btn").onclick = function() {
            console.log("Guest.html"); // Debugging message
            window.history.back();
        }
    </script>
</body>
</html>
