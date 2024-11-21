<?php
if (!isset($_SESSION['time_left'])) {
    $_SESSION['time_left'] = 300; // Reset timer to 5 minutes (300 seconds)
}

if (isset($_POST['reset_timer']) && $_POST['reset_timer'] === 'true') {
    $_SESSION['time_left'] = 900; // Reset timer to 15 minutes
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize user inputs
    $user_type = filter_var($_POST['user_type'], FILTER_SANITIZE_STRING);
    $feedback_rating = filter_var($_POST['feedback_rating'], FILTER_SANITIZE_NUMBER_INT);
    $feedback_comment = filter_var($_POST['feedback_comment'], FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("INSERT INTO website_feedback (user_type, feedback_rating, feedback_comment) VALUES (?, ?, ?)");
    
    // Check if statement prepared successfully
    if ($stmt) {
        $stmt->bind_param("sis", $user_type, $feedback_rating, $feedback_comment);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Feedback submitted successfully!";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error; // Capture error message
        }
        $stmt->close(); // Close the statement
    } else {
        $_SESSION['message'] = "Prepare failed: " . $conn->error; // Capture prepare error
    }

    $conn->close(); // Close the connection

    // Reset timer after submission
    $_SESSION['time_left'] = 900;

    // Redirect to prevent resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Retrieve success/error message
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear the message after displaying it
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Feedback</title>
</head>
<body>

    <!-- Timer Display (hidden) -->
    <div id="timer">Time Left: 2:00</div>

    <!-- Feedback Form Modal (Initially hidden) -->
    <div id="feedbackFormModal" class="feedback-form-modal" style="display: none;">
        <div class="feedback-form">
            <!-- Close Button Inside the Modal -->
            <button class="close-btn" id="closeBtn">&times;</button>
            
            <h2>We Value Your Feedback</h2>
            <p>Please Share Your Experience With The Website!</p>

            <!-- Feedback Form -->
            <form id="feedback-form" method="POST" action="">
                <input type="hidden" name="user_type" value="Guest">
                <div class="rating">
                    <label>
                        <input type="radio" name="feedback_rating" value="1" required>
                        <i class="star" data-value="1">&#9733;</i>
                    </label>
                    <label>
                        <input type="radio" name="feedback_rating" value="2">
                        <i class="star" data-value="2">&#9733;</i>
                    </label>
                    <label>
                        <input type="radio" name="feedback_rating" value="3">
                        <i class="star" data-value="3">&#9733;</i>
                    </label>
                    <label>
                        <input type="radio" name="feedback_rating" value="4">
                        <i class="star" data-value="4">&#9733;</i>
                    </label>
                    <label>
                        <input type="radio" name="feedback_rating" value="5">
                        <i class="star" data-value="5">&#9733;</i>
                    </label>
                </div>

                <!-- Optional feedback comment -->
                <textarea name="feedback_comment" placeholder="Leave a comment (optional)" rows="4" style="width: 100%;"></textarea>

                <button type="submit" class="feedback-submit-btn">Submit Feedback</button>
            </form>

            <!-- Display success or error message after redirect -->
            <?php if ($message): ?>
                <p style="text-align: center; color: green;"><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- JavaScript to handle the timer and feedback form -->
    <script>
        // Timer countdown logic
        let timeLeft = <?php echo $_SESSION['time_left']; ?>; // Get the remaining time from PHP session
        const timerDisplay = document.getElementById('timer');
        const feedbackFormModal = document.getElementById('feedbackFormModal');
        const closeBtn = document.getElementById('closeBtn');

        const timerInterval = setInterval(() => {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Update the timer display
            timerDisplay.textContent = `Time Left: ${minutes}:${seconds}`;

            if (timeLeft === 0) {
                clearInterval(timerInterval);
                showFeedbackForm(); // Show the feedback form modal when time is up
            }

            // Save the remaining time back to the session every second (AJAX or form submission)
            timeLeft--;
            
            // Make an AJAX call to update the session with the remaining time
            fetch('feedback_timer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'time_left=' + timeLeft
            });
        }, 1000);

        // Function to show the feedback form modal
        function showFeedbackForm() {
            feedbackFormModal.style.display = 'flex';
        }

        // Close the modal when the close button is clicked
        closeBtn.addEventListener('click', () => {
            feedbackFormModal.style.display = 'none';
        });
        
    </script>
</body>
</html>
<style>
    /* Feedback Form Modal */
    .feedback-form-modal {
        display: none; /* Initially hidden */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .feedback-form {
        position: relative; /* Added to allow absolute positioning for close button */
        width: 400px;
        padding: 20px;
        background: linear-gradient(135deg, #d0e7ff, #e6edf3); 
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .feedback-form h2 {
        margin-bottom: 10px;
    }

    /* Rating Stars */
    .rating {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .rating input {
        display: none; /* Hide the radio buttons */
    }

    .rating .star {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .rating .star:hover,
    .rating .star:hover ~ .star {
        color: #f59e0b; /* Hover color */
    }

    .rating input:checked ~ .star {
        color: #f59e0b; /* Selected color */
    }

    /* Feedback Comment Box */
    textarea {
        width: 100%;
        resize: vertical;
        margin-bottom: 20px;
        padding: 10px;
    }

    /* Submit Button */
    .feedback-submit-btn {
        padding: 10px 20px;
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
        display: block;
        margin: 20px auto;
    }

    .feedback-submit-btn:hover {
        background-color: #2563eb;
    }

    /* Timer and Modal Styles */
    #timer {
        display: none; /* Hide the timer */
    }

    /* Close Button Styles */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #f44336;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        font-size: 16px;
        cursor: pointer;
    }

    .close-btn:hover {
        background-color: #d32f2f;
    }

    @media (max-width: 768px) {
        .feedback-form {
            width: 70%;
        }

        .rating .star {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 500px) {
        .feedback-form {
            width: 90%;
        }
    }
</style>