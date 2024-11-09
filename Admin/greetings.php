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
            background-color: #f4f4f9; 
            margin: 0;
            padding: 0;
        }

        .greeting-modal {
            display: none;
            position: fixed; 
            z-index: 9999999; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .greeting-modal-content {
            background: linear-gradient(to bottom left, #87CEEB, #C0C0C0); 
            margin: 250px auto; 
            padding: 30px;
            border-radius: 10px; 
            border: 3px solid #003366; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); 
            width: 70%; 
            max-width: 500px; 
            text-align: center;
        }

        .greeting-close-btn {
            color: #ff6f61;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .greeting-close-btn:hover,
        .greeting-close-btn:focus {
            color: #ff3d3d; 
            text-decoration: none;
            cursor: pointer;
        }

        .greeting-heading {
            color: #000; 
            margin: 0 0 10px; 
        }

        .greeting-paragraph {
            color: #333; 
            font-size: 16px;
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
