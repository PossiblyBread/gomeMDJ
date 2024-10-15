<!-- Needs additional content -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - My Website</title>
    <link rel="stylesheet" href="styles/styles.css">  <!-- Assuming the CSS styles from the template -->
</head>
<body>
    
    <?php include 'body/header.php'; ?>
    <?php include 'body/side-bar.php'; ?>
    
    <div id="overlay"></div>

    <!-- Main Content Section -->
    <main>
        <section class="about-section">
            <h2>About Us</h2>
            <p>Welcome to our company! We are passionate about delivering high-quality products and services to our customers. Our story began with a simple mission: to make life easier and better through innovation and dedication.</p>

            <div class="mission-section">
                <h3>Our Mission</h3>
                <p>Our mission is to provide exceptional products and outstanding customer service that enhances the lives of our customers. We believe in continuous improvement, innovation, and sustainability in all aspects of our business.</p>
            </div>

            <div class="team-section">
                <h3>Meet Our Team</h3>
                <div class="team-grid">
                    <div class="team-member">
                        <img src="team1.jpg" alt="Team Member 1">
                        <h4>Jane Doe</h4>
                        <p>CEO & Founder</p>
                        <p>Jane founded the company with a vision to revolutionize the industry. She is dedicated to leading the team and driving innovation.</p>
                    </div>
                    <div class="team-member">
                        <img src="team2.jpg" alt="Team Member 2">
                        <h4>John Smith</h4>
                        <p>Chief Technology Officer</p>
                        <p>John heads the technology department, ensuring that we stay ahead of trends and deliver cutting-edge solutions.</p>
                    </div>
                    <div class="team-member">
                        <img src="team3.jpg" alt="Team Member 3">
                        <h4>Emily Johnson</h4>
                        <p>Chief Marketing Officer</p>
                        <p>Emily leads the marketing efforts, building strong customer relationships and promoting our values.</p>
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
    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="modal-content">
            <h2>Login</h2>
            <form id="login-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
    <!-- Footer Section -->
    <?php include 'body/footer.php'; ?>

    <script src="js/script.js"></script>
</body>
</html>
<style>
/* About Page */
/* About Section */
.about-section {
    padding: 40px;
    max-width: 1200px;
    margin: 0 auto;
}

.about-section h2 {
    font-size: 36px;
    margin-bottom: 20px;
    text-align: center;
}

.about-section p {
    font-size: 18px;
    line-height: 1.6;
    text-align: justify;
}

.mission-section, .team-section, .values-section {
    margin-top: 40px;
}

.team-section {
    text-align: center;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.team-member {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.team-member img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.team-member h4 {
    margin: 15px 0 10px;
    font-size: 20px;
}

.team-member p {
    font-size: 16px;
    color: #555;
}

.values-section ul {
    list-style-type: none;
    padding-left: 0;
}

.values-section ul li {
    margin-bottom: 10px;
    font-size: 18px;
    color: #333;
}
</style>
