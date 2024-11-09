<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Promotion</title>
</head>
<body>
    <h2>Upload a Promotion</h2>
    <form action="config/update-promo.php" method="post" enctype="multipart/form-data">
        <label for="p_name">Product Name:</label>
        <input type="text" name="p_name" id="p_name" required>
        <br><br>

        <label for="p_monthly">Monthly:</label>
        <input type="number" name="p_monthly" id="p_monthly" required>
        <br><br>

        <label for="p_year">Year:</label>
        <input type="number" name="p_year" id="p_year" required>
        <br><br>
        <label for="p_image">Choose an image to upload:</label>
        <input type="file" name="p_image" id="p_image" accept=".jpg, .jpeg, .png, .gif" required>
        <br><br>

        <button type="submit">Upload Promotion</button>
    </form>
</body>
</html>
