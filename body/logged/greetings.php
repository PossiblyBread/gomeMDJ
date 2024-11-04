<?php
// Assuming user data has already been set in the session during the login process
if (!isset($_SESSION['first_name']) || !isset($_SESSION['last_name'])) {
    header("Location: index.php?error=Unauthorized access");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9; /* Light background color for friendliness */
            margin: 0;
            padding: 0;
        }

        .greeting-modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 100; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
        }

        .greeting-modal-content {
            background-color: #ffffff; /* White background for the modal */
            margin: 250px auto; /* Center the modal */
            padding: 30px;
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Soft shadow */
            width: 70%; /* Responsive width */
            max-width: 500px; /* Max width for larger screens */
            text-align: center; /* Center text */
        }

        .greeting-close-btn {
            color: #ff6f61; /* Friendly close button color */
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .greeting-close-btn:hover,
        .greeting-close-btn:focus {
            color: #ff3d3d; /* Darker red on hover */
            text-decoration: none;
            cursor: pointer;
        }

        .greeting-heading {
            color: #333; /* Darker text for readability */
            margin: 0 0 10px; /* Margin below heading */
        }

        .greeting-paragraph {
            color: #666; /* Slightly lighter text color */
            font-size: 16px; /* Friendly font size */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('greetingPopup');
            const closeButton = document.querySelector('.greeting-close-btn');

            // Check if the modal has already been shown
            if (!sessionStorage.getItem('modalShown')) {
                // Show the modal
                modal.style.display = 'block';
                // Set the session storage item to indicate the modal has been shown
                sessionStorage.setItem('modalShown', 'true');
            }

            // Close the modal when the close button is clicked
            closeButton.onclick = function() {
                modal.style.display = 'none';
            };

            // Close the modal when clicking outside of it
            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            };
        });
    </script>
</head>
<body>
    <div id="greetingPopup" class="greeting-modal">
        <div class="greeting-modal-content">
            <span class="greeting-close-btn">&times;</span>
            <h2 class="greeting-heading">Welcome, <?php echo htmlspecialchars($_SESSION['first_name']) . ' ' . htmlspecialchars($_SESSION['last_name']); ?>!</h2>
            <p class="greeting-paragraph">You have successfully logged in.</p>
        </div>
    </div>
</body>
</html>
