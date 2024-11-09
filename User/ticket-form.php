<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket Form</title>
</head>
<body>
    <!-- Support Form -->
    <div class="ticket-form-section">
        <h3 class="ticket-form-title">Submit a Support Request</h3>
        <form id="ticket-form">
            <input type="hidden" name="access_key" value="5bfb0bbd-0f6f-4e30-89c6-86e8cdfe0c6f">

            <label class="ticket-form-label" for="first_name">First Name</label>
            <input class="ticket-form-input" type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($userFirstName); ?>" readonly required>

            <label class="ticket-form-label" for="last_name">Last Name</label>
            <input class="ticket-form-input" type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($userLastName); ?>" readonly required>

            <label class="ticket-form-label" for="user_email">Email</label>
            <input class="ticket-form-input" type="text" id="user_email" name="user_email" value="<?php echo htmlspecialchars($userEmail); ?>" readonly required>
            
            <label class="ticket-form-label" for="phone_num">Phone Number</label>
            <input class="ticket-form-input" type="text" id="phone_num" name="phone_num" value="<?php echo htmlspecialchars($userPhoneNum); ?>" maxlength="11" pattern="\d{11}" title="Please enter an 11-digit phone number" required>

            <label class="ticket-form-label" for="type">Ticket Type</label>
            <select class="ticket-form-select" id="type" name="type" required>
                <option value="Technical">Technical</option>
                <option value="Mechanical">Mechanical</option>
                <option value="Billing">Billing</option>
                <option value="Assist_Req">Assistance Request</option>
            </select>

            <label class="ticket-form-label" for="description">Description</label>
            <textarea class="ticket-form-textarea" id="description" name="description" rows="4" required></textarea>
            <input type="hidden" name="t_status" value="new">
            <button class="ticket-form-submit-button" type="submit">Submit Ticket</button>
        </form>
        <div id="result" class="ticket-form-result"></div> <!-- Result display -->
    </div>
    
    <script>
        const form = document.getElementById('ticket-form');
        const result = document.getElementById('result');

        // Cooldown period in milliseconds (3 hours = 3 * 60 * 60 * 1000)
        const COOLDOWN_PERIOD = 3 * 60 * 60 * 1000; 
        let lastSubmissionTime = localStorage.getItem('lastSubmissionTime') || 0;

        document.getElementById('phone_num').addEventListener('input', function (e) {
            this.value = this.value.replace(/\D/g, ''); // Removes any non-numeric characters
        });

        document.addEventListener('DOMContentLoaded', () => {
            const currentTime = Date.now();
            const timeElapsed = currentTime - lastSubmissionTime;
            
            // Check if still in cooldown period
            if (timeElapsed < COOLDOWN_PERIOD) {
                const timeLeft = ((COOLDOWN_PERIOD - timeElapsed) / 1000).toFixed(0);
                result.innerHTML = `Please wait ${timeLeft} seconds before submitting another ticket.`;
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            const currentTime = Date.now();

            // Check if cooldown period has passed
            if (currentTime - lastSubmissionTime < COOLDOWN_PERIOD) {
                const timeLeft = ((COOLDOWN_PERIOD - (currentTime - lastSubmissionTime)) / 1000).toFixed(0);
                result.innerHTML = `Please wait ${timeLeft} seconds before submitting another ticket.`;
                return;
            }

            lastSubmissionTime = currentTime; // Update last submission time
            localStorage.setItem('lastSubmissionTime', lastSubmissionTime); // Save to localStorage

            const formData = new FormData(form);
            const jsonObject = Object.fromEntries(formData);
            const json = JSON.stringify(jsonObject);

            result.innerHTML = "Submitting, please wait...";

            // Send data to Web3Forms API
            fetch('https://api.web3forms.com/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: json
            })
            // Error and Success Messages from Web3Forms
            .then(async (response) => {
                let web3Json = await response.json();
                if (response.status === 200) {
                    result.innerHTML = "Ticket has been sent successfully!";
                } else {
                    result.innerHTML = "Error: " + web3Json.message;
                }
            })
            .catch(error => {
                result.innerHTML = "Sending Ticket Failed!";
                console.error(error);
            });

            // Send data to your PHP script
            // Error and Success for database table insert
            fetch('send-data.php', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: json
            })
            .then(async (response) => {
                const phpJson = await response.json();
                if (phpJson.success) {
                    result.innerHTML += "<br>Ticket has been sent successfully!";
                } else {
                    result.innerHTML += "<br>server error: " + phpJson.message;
                }
            })
            .catch(error => {
                result.innerHTML += "<br>Failed to send ticket.";
                console.error(error);
            });
        });
    </script>
    <style>
        /* ticket form starts*/
        .ticket-form-section {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
        }

        .ticket-form-title {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .ticket-form-label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .ticket-form-input,
        .ticket-form-textarea,
        .ticket-form-select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .ticket-form-submit-button {
            background-color: #666;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .ticket-form-submit-button:hover {
            background-color: #333;
        }

        .ticket-form-result {
            margin-top: 20px;
            font-size: 16px;
            text-align: center;
            color: #333;
        }
        /* ticket form end */
    </style>
</body>
</html>
