<?php
session_start();
include "db_conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - My Website</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Assuming the CSS styles from the template -->
</head>

<body>

    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
    <div id="overlay"></div>
    <br><br><br>
    <!-- Main Content Section -->
    <main>
        <section class="about-section">
            <h2>About Us</h2>
            <section class="MDJ">
                <section class="MDJ-motto">
                    <strong><p>"At MDJ eBike Store, we’re reshaping the future of transportation with innovative, eco-friendly solutions that make every journey simpler, faster, and more affordable. With every ride, we’re moving closer to a future where technology and nature work hand in hand. Explore our website for detailed information on our eBikes, promotions, and features like personalized customer accounts and seamless inquiry handling. Experience the freedom of smart travel with MDJ eBikes your step towards a cleaner, more sustainable tomorrow."</p></strong>
                </section>
                <section class="MDJ-image">
                    <h2>-Marco P. De Jesus</h2>
                    <img src="Images/MDJ.png">
                </section>
            </section>
            <hr>
            <p>Welcome to gomemdj, where we’re revolutionizing urban mobility with our innovative e-bike solutions! Our mission is to provide a sustainable, efficient, and enjoyable way to navigate your city. We proudly offer a fleet of state-of-the-art electric bikes designed for comfort and performance, perfect for commuting, running errands, or exploring. With our user-friendly ticketing system, you can effortlessly reserve and pay for your e-bike, while our 24/7 chatbot support ensures you receive assistance whenever you need it. Join us in making sustainable transportation accessible to everyone and experience the freedom of riding an e-bike today!</p>

            <div class="mission-section">
                <h3>Our Mission</h3>
                <p>Empowering eco-friendly transportation with reliable, affordable, and quality e-bikes for everyone. Our mission is to make sustainable mobility accessible, enhancing your journey towards a greener future."</p>
            </div>
            <div class="team-section">
                <h3>Meet Our Team</h3>
                <div class="team-grid">
                    <div class="team-member">
                        <img src="Images/adrian.png">
                        <h4>Adrian Adona</h4>
                        <h5>Developer</h5>
                    </div>
                    <div class="team-member">
                        <img src="Images/francis.png">
                        <h4>John Francis Marquez</h4>
                        <h5>Researcher</h5>
                    </div>
                    <div class="team-member">
                        <img src="Images/vivien.png">
                        <h4>Vivien De Luna</h4>
                        <h5>Project Manager</h5>
                    </div>
                    <div class="team-member">
                        <img src="Images/kent.png">
                        <h4>Kent Ian Molinyawe</h4>
                        <h5>Senior Developer</h5>
                    </div>
                    <div class="team-member">
                        <img src="Images/kyle.png">
                        <h4>Christian Kyle Vicencio</h4>
                        <h5>Assistant Project Manager</h5>
                    </div>
                </div>
            </div>

            <div class="values-section">
                <h3>Our Values</h3>
                <ul>
                    <li><strong>Innovation:</strong> We constantly strive to innovate and improve our offerings.</li>
                    <li><strong>Customer Focus:</strong> Our customers are at the heart of everything we do.</li>
                    <li><strong>Integrity:</strong> We believe in conducting our business with honesty and transparency.</li>
                    <li><strong>Teamwork:</strong> Collaboration is key to our success, and we value the contributions of every team member.</li>
                </ul>
            </div>
        </section>
    </main>
    <script>
        window.embeddedChatbotConfig = {
            chatbotId: "e8_c510p3vG8EPF2g33Vw",
            domain: "www.chatbase.co"
        }
    </script>
    <script
        src="https://www.chatbase.co/embed.min.js"
        chatbotId="e8_c510p3vG8EPF2g33Vw"
        domain="www.chatbase.co"
        defer>
    </script>

    </script>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>
<style>
/* Default Flexbox Layout for Desktop */
.MDJ {
    display: flex;
    justify-content: flex-start;  
    gap: 20px;  
}

/* The motto section stays on the left (default flex behavior) */
.MDJ-motto {
    position: relative;
    flex: 60%; /* Increased from 50% to 60% */
    margin-top: 70px;
}
.MDJ-motto p {
    font-size: 30px;
    text-indent: 40px;
    font-style: italic;  /* Makes the text italic */
}
/* The image section will be aligned to the right */
.MDJ-image {
    flex: 40%;  /* Decreased from 50% to 40% to maintain overall layout */
    display: flex;
    justify-content: flex-end;  /* Aligns the image to the right */
    margin-right: 70px;
    position: relative; /* Set position to relative for absolute positioning of h2 */
}

.MDJ-image img {
    height: 95%;
    padding: 2px;
    width: auto;
    border-radius: 50px;
    border: 2px solid #ccc;  /* Adds a border */
    flex-grow: 1;  /* Allows the image to grow and take available space */
    box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.2);
}

/* Position the h2 at the bottom right and allow it to extend freely to the left */
.MDJ-image h2 {
    position: absolute; /* Change to absolute positioning */
    bottom: 0; /* Align to the bottom */
    margin-bottom: 10px;
    margin-right: 475px; /* Remove default margins */
    white-space: nowrap; /* Prevent text wrapping */
    font-size: 50px;
    font-style: italic; 
}
.about-section {
    padding: 10px;
    max-width: 1200px;
    margin: 0 auto;
}

.about-section h2 {
    font-size: 36px;
    margin-bottom: 20px;
    text-align: center;
}

.about-section p {
    font-size: 25px;
    line-height: 1.6;
    text-align: justify;
    text-indent: 40px;
}

.mission-section, .team-section, .values-section {
    margin-top: 40px;
    font-size: 40px;
}

.team-section {
    text-align: center;
}

.team-grid {
    display: flex;
    justify-content: space-between; /* Distribute the team members evenly across the row */
    gap: 20px;  /* Space between the team members */
    margin-top: 20px;
}

.team-member {
    background-color: #20779f;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    flex-basis: 18%; /* Ensures the team members take up about 18% of the row */
    box-sizing: border-box;
}

.team-member img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}
.team-member h4 {
    margin: 15px 0 10px;
    font-size: 25px;
    font-weight: bolder;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Adding a subtle shadow */
}
.team-member h5 {
    margin: 15px 0 10px;
    font-size: 15px;
    color: white;
    text-decoration: underline;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Adding a subtle shadow */
}
.team-member p {
    font-size: 16px;
    color: white;
    text-align: center;
}

.values-section ul {
    list-style-type: none;
    padding-left: 0;
}

.values-section ul li {
    margin-bottom: 10px;
    font-size: 30px;
    color: #333;
}

/* Responsive adjustments for smaller screens */
@media (max-width: 768px) {
    .about-section {
        text-align: center  ;
    }

    .about-section h2 {
        font-size: 28px; /* Reduce title font size on smaller screens */
    }

    .about-section p {
        font-size: 16px; /* Smaller font for paragraphs */
    }

    .team-grid {
        flex-direction: column; /* Stack team members vertically */
        align-items: center; /* Center team members horizontally */
    }

    .team-member {
        flex-basis: 80%; /* Team members take up more width */
        margin-bottom: 20px; /* Space between stacked items */
    }
}

/* Very small screens (e.g., phones in portrait mode) */
@media (max-width: 480px) {
    .about-section h2 {
        font-size: 24px; /* Smaller heading for very small screens */
    }

    .about-section p {
        font-size: 14px; /* Even smaller text on very small screens */
    }

    .team-grid {
        flex-direction: column; /* Stack members vertically */
        align-items: center;
    }

    .team-member {
        flex-basis: 90%; /* Team members take up most of the width */
        margin-bottom: 15px; /* More space between stacked items */
    }
}

@media (max-width: 700px) {
    .MDJ-image img {
        align-items: center;
        text-align: center;
        width: 70%;  
        height: auto;
        min-width: 300px;
        margin-left: 50px;
    }
}
@media (max-width: 1000px) {
    .MDJ {
        flex-direction: column;  /* Stacks the sections vertically */
        align-items: center;  /* Centers the items */
    }
    /* Adjust the image and name layout */
    .MDJ-image {
        flex-direction: column;  /* Stack the image and name vertically */
    }
    .MDJ-motto, .MDJ-image {
        flex: 1 1 100%;  /* Each section takes up 100% width */
        text-align: center;  /* Centers the text in the motto */
    }
    .MDJ-image img {
        align-items: center;
        text-align: center;
        width: 70%;  /* Slightly smaller image for better fit on mobile */
        height: auto;
        min-width: 200px;
        margin-left: 90px;
    }

    .MDJ-image h2 {
        margin-left: 50px;
        margin-top: 10px;  /* Add some space between the image and the name */
        font-size: 1.5em;  /* Adjust font size if necessary */
        position: relative; /* Change to relative positioning */
        bottom: auto; /* Reset bottom positioning */
        margin-bottom: 0; /* Reset margin-bottom */
        margin-right: 0; /* Reset margin-right */
        white-space: nowrap; /* Prevent text wrapping */
        width: auto; /* Allow width to adjust */
    }
}
/* Mobile Layout: Stack the sections vertically */
@media (max-width: 700px) {
    .MDJ-image img {
        margin-left: 70px;
    }
    .MDJ-image h2 {
        margin-left: 50px;
        margin-top: 10px;  /* Add some space between the image and the name */
        font-size: 1.5em;  /* Adjust font size if necessary */
        position: relative; /* Change to relative positioning */
        bottom: auto; /* Reset bottom positioning */
        margin-bottom: 0; /* Reset margin-bottom */
        margin-right: 0; /* Reset margin-right */
        white-space: nowrap; /* Prevent text wrapping */
        width: auto; /* Allow width to adjust */
    }
}

</style>