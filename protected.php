<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARNING!</title>
    <meta charset="UTF-8">
</head>
<header style="text-align: center; background-color: #1b212f;">
    <img src="Images/Logo.png" alt="MDJ Logo" style="max-width: 90px; vertical-align: middle;">
    <h1 style="display: inline-block; margin-left: 15px; margin-top: 20px; font-size: 63px; color: #d0e7ff;">MDJ</h1>
</header>

<body>
    <div class="content-container">
        <h1>Oops!</h1>
        <div class="protection-message">
            <p><strong>This page is protected and restricted</strong></p>
            <p>Access to this page is limited to authorized users only. Please ensure you are following the correct procedure.</p>
        </div>
    </div>
</body>

</html>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body,
    html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }

    /* Body background and font */
    body {
        font-family: Arial, sans-serif;
        background-color: #d0e7ff;
    }

    /* Full-width header with no spacing */
    header {
        text-align: center;
        background-color: #1b212f;
        width: 100%;
        height: 125px;
        padding: 10px 0;
    }

    /* Styling for the logo and title */
    header img {
        max-width: 150px;
        vertical-align: middle;
    }

    header h1 {
        display: inline-block;
        margin-left: 15px;
        font-size: 63px;
        /* 75% larger than previous size (36px * 1.75) */
        color: #d0e7ff;
        vertical-align: middle;
    }

    /* Main content container */
    .content-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        text-align: center;
    }

    /* Heading and instructions */
    h1 {
        font-size: 63px;
        /* 75% larger than previous size (36px * 1.75) */
        margin-bottom: 20px;
        color: #333;
    }

    p {
        font-size: 35px;
        /* 75% larger than previous size (20px * 1.75) */
        color: #666;
        margin-bottom: 30px;
    }

    /* Protection message styling */
    .protection-message {
        font-size: 35px;
        /* 75% larger than previous size (20px * 1.75) */
        color: #444;
        margin-top: 30px;
    }

    .protection-message p {
        color: #555;
    }

    .protection-message strong {
        font-weight: bold;
        color: #333;
    }

    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        header h1 {
            font-size: 49px;
            /* 75% larger for mobile */
        }

        .content-container {
            padding: 15px;
            margin: 10px;
            max-width: 95%;
            /* Make the form width more flexible */
        }

        h1 {
            font-size: 49px;
            /* 75% larger for mobile */
        }

        p {
            font-size: 28px;
            /* 75% larger for mobile */
        }
    }

    @media (max-width: 480px) {
        header img {
            max-width: 120px;
            /* Logo size adjustment for small screens */
        }

        header h1 {
            font-size: 42px;
            /* 75% larger for mobile */
        }
    }
</style>