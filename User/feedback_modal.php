<?php

if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

$id = $_SESSION['id'];  // Assume user ID is stored in session
$validation_status = '';

// Fetch the user's validation status from the accounts table
$sql_validation = "SELECT `validation` FROM `accounts` WHERE `id` = '$id'";
$validation_result = mysqli_query($conn, $sql_validation);
if ($validation_result) {
    $row = mysqli_fetch_assoc($validation_result);
    $validation_status = $row['validation'];  // Get validation status
} else {
    die("Error fetching validation status.");
}

// Determine user type based on validation status
$user_type = ($validation_status === "Validated") ? "Validated User" : "Registered User";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if feedback fields are set and sanitize them
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : $user_type;
    $feedback_rating = isset($_POST['feedback_rating']) ? $_POST['feedback_rating'] : 0; // Default to 0 if not set
    $feedback_comment = isset($_POST['feedback_comment']) ? trim($_POST['feedback_comment']) : ''; // Default to empty string if not set

    // Ensure feedback rating is between 1 and 5
    if ($feedback_rating < 1 || $feedback_rating > 5) {
        $feedback_rating = 0; // Default to 0 if invalid
    }

    $stmt = $conn->prepare("INSERT INTO website_feedback (user_type, feedback_rating, feedback_comment) VALUES (?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("sis", $user_type, $feedback_rating, $feedback_comment); 
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Thank you for your feedback!"; // Updated thank you message
        } else {
            $_SESSION['message'] = "Error submitting feedback: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error preparing statement: " . $conn->error;
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!-- Feedback Modal -->
<div id="feedbackModal" class="modal">
    <div class="feedback-modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div class="feedback-form-container">
            <button class="feedback-close-btn" onclick="closeFeedbackModal()">&times;</button> 
            <h2>We Value Your Feedback</h2>
            <p>Please share your experience with the website!</p>
            <form id="feedback-form" method="POST" action="">
                <input type="hidden" name="user_type" value="<?php echo htmlspecialchars($user_type); ?>">
                    
                <div class="rating">
                    <?php
                    $selectedRating = isset($_POST['feedback_rating']) ? $_POST['feedback_rating'] : 0;
                    for ($i = 1; $i <= 5; $i++) {
                        $checked = ($i == $selectedRating) ? 'checked' : '';
                        echo '<label>
                                <input type="radio" name="feedback_rating" value="' . $i . '" ' . $checked . '>
                                <i class="star" data-value="' . $i . '">&#9733;</i>
                            </label>';
                    }
                    ?>
                </div>

                <textarea name="feedback_comment" placeholder="Leave a comment (optional)" rows="4" style="width: 94%;"><?php echo isset($_POST['feedback_comment']) ? htmlspecialchars($_POST['feedback_comment']) : ''; ?></textarea>

                <button type="submit" class="feedback-submit-btn">Submit Feedback</button>
            </form>

            <?php if ($message): ?>
                <p style="text-align: center; color: green;"><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Modal Styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 999; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    .feedback-modal-content {
        background: linear-gradient(135deg, #d0e7ff, #e6edf3); 
        margin: 150px auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
        max-width: 600px;
        border-radius: 10px;
        text-align: center;
        z-index: 9999;
    }
    .feedback-close-btn {
        background-color: transparent;
        margin-top: -150px;
        margin-right: -95%;
        background-color: #f44336;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 16px;
        cursor: pointer;
    }

    .feedback-close-btn:hover {
        background-color: darkred;
    }


    /* Feedback Form Container */
    .feedback-form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9fafb;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .feedback-form-container h2 {
        margin-bottom: 10px;
    }

    .feedback-form-container p {
        margin-bottom: 20px;
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
        transition: color 0.3s ease, transform 0.2s ease; /* Added transition for scaling and color change */
    }

    /* Hover Effect: Highlight stars up to the hovered one */
    .rating label:hover .star,
    .rating label:hover ~ label .star {
        color: #f59e0b; /* Golden color */
    }

    /* Scale the hovered star */
    .rating label:hover .star {
        transform: scale(1.3); /* Scale up the hovered star */
    }

    /* For when the radio button is selected (feedback is submitted) */
    .rating input:checked ~ label .star,
    .rating input:checked + label .star {
        color: #f59e0b; /* Selected color */
    }

    .rating input:checked + label .star,
    .rating input:checked ~ label .star {
        transform: scale(1.3); /* Keep stars scaled after selection */
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

    @media (max-width: 768px) {
        .feedback-modal-content{
            margin: 150px auto; /* 15% from the top and centered */
        }
        .feedback-form-container {
            width: 70%;
        }

        .rating .star {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 500px) {
        .feedback-form-container {
            width: 90%;
        }
    }
</style>

<script>
    function openModal() {
        document.getElementById("feedbackModal").style.display = "block";
    }
    // Function to close the modal
    function closeFeedbackModal() {
        document.getElementById("feedbackModal").style.display = "none";
    }

    // Close the modal if clicked outside
    window.onclick = function(event) {
        if (event.target == document.getElementById("feedbackModal")) {
            closeFeedbackModal();
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');

        stars.forEach(star => {
            star.addEventListener('mouseenter', function() {
                const ratingValue = parseInt(star.getAttribute('data-value'));
                stars.forEach((s, index) => {
                    s.style.color = index < ratingValue ? '#f59e0b' : '#ccc'; // Highlight stars up to hovered
                });
            });

            star.addEventListener('mouseleave', function() {
                const checkedRadio = document.querySelector('input[name="feedback_rating"]:checked');
                if (checkedRadio) {
                    const selectedValue = parseInt(checkedRadio.value);
                    stars.forEach((s, index) => {s.style.color = index < selectedValue ? '#f59e0b' : '#ccc'; // Highlight based on selected
                });
            } else {
                stars.forEach(s => s.style.color = '#ccc'); // Reset if no selection
            }
        });
    });
});
</script>