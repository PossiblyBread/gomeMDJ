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

    <main>
        <!-- FAQ Section -->
        <div class="faq-section">
            <h3>Frequently Asked Questions</h3>

            <div class="faq-item">
                <h4>1. What is an e-bike?</h4>
                <p>An e-bike, or electric bike, is a bicycle equipped with an electric motor to assist with pedaling. It combines the features of a regular bike with electric power, allowing you to ride longer distances with less effort.</p>
            </div>
            <div class="faq-item">
                <h4>2. Are e-bikes allowed on the roads in the Philippines?</h4>
                <p>Yes, e-bikes are allowed on roads in the Philippines. However, regulations vary, so we recommend following local traffic laws and using bike lanes where possible. Some cities may have specific rules about speed limits and road access for e-bikes.</p>
            </div>
            <div class="faq-item">
                <h4>3. Do I need a license or registration for my e-bike?</h4>
                <p>The Land Transportation Office (LTO) in the Philippines may require registration and a valid driver’s license for certain types of e-bikes, especially those with higher power or speeds. We recommend checking with the LTO or your local government unit for specific requirements.</p>
            </div>
            <div class="faq-item">
                <h4>4. How long does the battery of an e-bike last?</h4>
                <p>The battery life depends on the model, usage, and terrain. On average, a full charge can last between 30 to 60 kilometers. Battery lifespan may range from 2-5 years with proper care.</p>
            </div>
            <div class="faq-item">
                <h4>5. How much time does it take to charge an e-bike?</h4>
                <p>Charging times vary, but most e-bike batteries take around 4-6 hours for a full charge. Some models offer faster-charging options.</p>
            </div>
            <div class="faq-item">
                <h4>6. Where can I charge my e-bike?</h4>
                <p>You can charge your e-bike at any standard power outlet, such as those found at home or in public charging stations. Just bring along your charger and plug it in when needed!</p>
            </div>
            <div class="faq-item">
                <h4>7. What’s the cost of an e-bike in the Philippines?</h4>
                <p>E-bike prices vary based on model, features, and brand. Typically, e-bikes in the Philippines range from PHP 20,000 to PHP 70,000 or more. Check our <a href="store.php">products</a> page for the latest pricing.</p>
            </div>
            <div class="faq-item">
                <h4>8. Do you offer financing or installment plans?</h4>
                <p>Yes, we offer financing options for select e-bike models. Payment terms may vary based on your chosen model and payment plan. Please contact our sales team for details on available installment plans.</p>
            </div>
            <div class="faq-item">
                <h4>9. How can I purchase an e-bike from your website?</h4>
                <p>To purchase, select your preferred model from our catalog, add it to your cart, and proceed to checkout. We offer various payment options, including credit card, debit card, and bank transfer.</p>
            </div>
            <div class="faq-item">
                <h4>10. Do you offer repairs and maintenance services?</h4>
                <p>Yes, we have authorized service centers and technicians across the Philippines to assist with repairs and maintenance. Contact our support team to schedule a service.</p>
            </div>
            <div class="faq-item">
                <h4>11. Can I test-ride an e-bike before buying?</h4>
                <p>Yes, test rides are available at select showrooms. Please check with our customer service to find a test-ride location near you.</p>
            </div>
        </div>
    </main>

    <?php include 'body/footer.php'; ?>

    <script src="js/script.js"></script>
</body>
</html>
<style>
/* Style for the FAQ links with permanent underline and glowing effect */
.faq-item a {
    text-decoration: underline; /* Always show the underline */
    color: #007BFF; /* Default color for the link */
    font-weight: bold; /* Make it bold for emphasis */
    position: relative; /* For positioning the glowing effect */
    transition: color 0.3s ease, text-shadow 0.3s ease; /* Smooth transitions */
}

/* Glowing effect on hover */
.faq-item a:hover {
    color: #00b3b3; /* Change color on hover (can be adjusted) */
    text-shadow: 0 0 8px #00b3b3, 0 0 15px #00b3b3, 0 0 25px #00b3b3; /* Glowing effect */
}

/* Optional: You can modify the underline color and thickness on hover if desired */
.faq-item a:hover {
    text-decoration-color: #00b3b3; /* Change underline color on hover */
    text-decoration-thickness: 2px; /* Thicker underline on hover */
}

/* If you want to add a custom animated underline, you can use the following */
.faq-item a:after {
    content: ''; /* Creates the underline */
    position: absolute;
    bottom: -2px; /* Adjusts the distance of the underline from the text */
    left: 0;
    width: 100%;
    height: 2px; /* Thickness of the underline */
    background-color: #00b3b3; /* Underline color */
    transform: scaleX(0); /* Initially no underline */
    transform-origin: bottom right; /* Start the animation from right */
    transition: transform 0.3s ease-out; /* Animate the underline */
}

.faq-item a:hover:after {
    transform: scaleX(1); /* Underline expands on hover */
    transform-origin: bottom left; /* Animation direction */
}

/* Indent for paragraphs inside .faq-item */
.faq-item p {
    text-indent: 40px; /* Add indentation to the first line of each paragraph */
    line-height: 1.6; /* Adjust line spacing for better readability */
}

</style>
