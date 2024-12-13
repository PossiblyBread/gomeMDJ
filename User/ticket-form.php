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
            <!-- User Details (read-only) -->
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
                <option value="Assistance Request">Assistance Request</option>
            </select>

            <label class="ticket-form-label" for="description">Description</label>
            <textarea class="ticket-form-textarea" id="description" name="description" rows="4" required></textarea>

            <input type="hidden" name="t_status" value="new">
            <input type="hidden" id="severity" name="severity"> <!-- Hidden severity field -->

            <button class="ticket-form-submit-button" type="submit">Submit Ticket</button>
        </form>
        <div id="result" class="ticket-form-result"></div> <!-- Result display -->
    </div>
    
    <script>
        const form = document.getElementById('ticket-form');
        const result = document.getElementById('result');

        // Cooldown period (3 hours)
        const COOLDOWN_PERIOD = 3 * 60 * 60 * 1000; 
        let lastSubmissionTime = localStorage.getItem('lastSubmissionTime') || 0;

        // Keyword-based severity levels
        const severityRules = {
            "Technical": {
                1: [ "error", "failure", "outage", "down", "data loss"],  // Critical
                2: ["timeout", "disconnected", "slowness", "issue", "lag", , "unable to load"],  // High
                3: ["delayed response", "lag", "minor bug", "intermittent issue", "feature malfunction"],  // Medium
                4: ["feature request", "suggestion", "UI issue", "minor bug", "cosmetic issue"]  // Low
            },
            "Mechanical": {
                1: ["machine down", "broken", "overheating", "failure", "safety issue"],  // Critical
                2: ["repair needed", "malfunctioning", "part broken", "intermittent failure", "major malfunction"],  // High
                3: ["needs maintenance", "routine check", "minor repair", "slightly damaged"],  // Medium
                4: ["minor damage"]  // Low
            },
            "Billing": {
                1: ["overcharge", "payment failure", "billing error", "transaction error", "fraud", "chargeback"],  // Critical
                2: ["incorrect charge", "refund request", "payment dispute", "missing payment"],  // High
                3: ["unpaid invoice", "delayed invoice", "invoice query"],  // Medium
                4: ["billing question", "clarification", "invoice breakdown", "payment method query"]  // Low
            },
            "Assistance Request": {
                1: ["urgent", "emergency", "immediate help", "critical help needed"],  // Critical
                2: ["help needed", "assistance required", "urgent question", "need help", "time-sensitive issue"],  // High
                3: ["guide", "how to", "request info", "instruction needed", "tutorial request"],  // Medium
                4: ["general inquiry", "informational", "question", "follow-up"]  // Low
            }
        };

        // Fuzzy matching to determine severity
        function fuzzyMatch(description, keywords, threshold = 3) {
            for (const keyword of keywords) {
                if (levenshtein(description.toLowerCase(), keyword.toLowerCase()) <= threshold) {
                    return true;  // Match found within acceptable Levenshtein distance
                }
            }
            return false; // No match within threshold
        }

        // Levenshtein Distance function to calculate similarity between two strings
        function levenshtein(a, b) {
            const tmp = [];
            for (let i = 0; i <= b.length; i++) tmp[i] = [i];
            for (let j = 0; j <= a.length; j++) tmp[0][j] = j;

            for (let i = 1; i <= b.length; i++) {
                for (let j = 1; j <= a.length; j++) {
                    tmp[i][j] = b[i - 1] === a[j - 1] ?
                        tmp[i - 1][j - 1] :
                        Math.min(tmp[i - 1][j] + 1, tmp[i][j - 1] + 1, tmp[i - 1][j - 1] + 1);
                }
            }
            return tmp[b.length][a.length];
        }

        // Function to auto-assign severity
        function detectSeverity(ticketType, description) {
            const rules = severityRules[ticketType];
            for (const [severity, keywords] of Object.entries(rules)) {
                if (fuzzyMatch(description, keywords)) {
                    return severity;  // Return numeric severity (1-4)
                }
            }
            return 4;  // Default to 4 (Low severity) if no match is found
        }

        // Check cooldown on page load
        document.addEventListener('DOMContentLoaded', () => {
            const currentTime = Date.now();
            const timeElapsed = currentTime - lastSubmissionTime;

            if (timeElapsed < COOLDOWN_PERIOD) {
                const timeLeftInSeconds = Math.floor((COOLDOWN_PERIOD - timeElapsed) / 1000); // Remaining time in seconds
                const hours = Math.floor(timeLeftInSeconds / 3600);
                const minutes = Math.floor((timeLeftInSeconds % 3600) / 60);
                const seconds = timeLeftInSeconds % 60;
                const formattedTime = `${hours} hour${hours !== 1 ? 's' : ''}, ${minutes} minute${minutes !== 1 ? 's' : ''}, and ${seconds} second${seconds !== 1 ? 's' : ''}`;
                result.innerText = `Please wait ${formattedTime} before submitting another ticket.`;
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            const currentTime = Date.now();

            // Check if cooldown period has passed
            if (currentTime - lastSubmissionTime < COOLDOWN_PERIOD) {
                const timeLeftInSeconds = Math.floor((COOLDOWN_PERIOD - (currentTime - lastSubmissionTime)) / 1000); 
                const hours = Math.floor(timeLeftInSeconds / 3600);
                const minutes = Math.floor((timeLeftInSeconds % 3600) / 60);
                const seconds = timeLeftInSeconds % 60;
                const formattedTime = `${hours} hour${hours !== 1 ? 's' : ''}, ${minutes} minute${minutes !== 1 ? 's' : ''}, and ${seconds} second${seconds !== 1 ? 's' : ''}`;
                result.innerText = `Please wait ${formattedTime} before submitting another ticket.`;
                return;
            }

            lastSubmissionTime = currentTime; // Update last submission time
            localStorage.setItem('lastSubmissionTime', lastSubmissionTime); // Save to localStorage

            const formData = new FormData(form);
            const ticketType = formData.get('type');
            const description = formData.get('description');

            // Auto-assign severity
            const severity = detectSeverity(ticketType, description);
            document.getElementById('severity').value = severity; // Set the severity value in the hidden input

            const jsonObject = Object.fromEntries(formData);
            jsonObject.severity = severity;  // Add severity to the form data

            const json = JSON.stringify(jsonObject);

            result.innerText = "Submitting, please wait...";

            // Send data to Web3Forms API
            fetch('https://api.web3forms.com/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: json
            })
            .then(async (response) => {
                let web3Json = await response.json();
                if (response.status === 200) {
                    result.innerText = "Ticket has been sent successfully!";
                } else {
                    result.innerText = "Error: " + web3Json.message;
                }
            })
            .catch(error => {
                result.innerText = "Sending Ticket Failed!";
                console.error(error);
            });

            // Send data to your PHP script
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
                    result.innerText += "Ticket has been sent successfully!";
                } else {
                    result.innerText += "server error: " + phpJson.message;
                }
            })
            .catch(error => {
                result.innerText += "Failed to send ticket.";
                console.error(error);
            });
        });
    </script>
</body>
</html>

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