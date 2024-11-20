<?php
include("../config/update-product.php");
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']); // Get the product ID from the URL

    // Fetch product details from the database
    $sql = "SELECT * FROM products_tb WHERE id = $productId"; // Retrieve the specific product
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error fetching product details: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result); // Fetch the product details
    } else {
        die("Product not found.");
    }
} else {
    die("No product ID provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #444;
        }
        .dis-prod-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #555;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #666;
            text-align: left;
        }
        input[type="text"],
        input[type="file"],
        textarea {
            width: 97%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        input[type="text"]:focus,
        textarea:focus {
            border-color: #aaa;
            outline: none;
            background-color: #fff;
        }
        .dis-prod-button, .dis-prod-delete-button {
            background-color: #888;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        .dis-prod-delete-button {
            background-color: #d9534f;
        }
        .dis-prod-button:hover {
            background-color: #666;
        }
        .dis-prod-delete-button:hover {
            background-color: #c9302c;
        }
        .dis-prod-current-image {
            width: 100%; 
            height: auto; 
            object-fit: cover; 
            margin: 20px 0;
        }
        .required-asterisk {
            color: red;
            margin-left: 5px;
        }
    </style>
</head>
<body>

<div class="dis-prod-container">
    <h1>Edit Product</h1>

    <form action="config/update-product.php?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
        <?php if (!empty($product['images'])): ?>
            <img src="<?php echo htmlspecialchars($product['images']); ?>" alt="Current Product Image" class="dis-prod-current-image">
        <?php else: ?>
            <p>No image available for this product.</p>
        <?php endif; ?>

        <label for="prod_serial_num">Serial Number:</label>
        <input type="text" id="prod_serial_num" name="prod_serial_num" value="<?php echo htmlspecialchars($product['prod_serial_num']); ?>" readonly required>

        <label for="p_model">Product Name:<span class="required-asterisk">required*</span></label>
        <input type="text" id="p_model" name="p_model" value="<?php echo htmlspecialchars($product['p_model']); ?>" required>

        <label for="p_price">Price:<span class="required-asterisk">required*</span></label>
        <input type="text" id="p_price" name="p_price" value="<?php echo htmlspecialchars($product['p_price']); ?>" required>

        <label for="images">Image:<span class="required-asterisk">required*</span></label>
        <input type="file" id="images" name="images" accept="image/required*">
       
        <label for="p_wheels">Wheel Count: <span class="required-asterisk">required*</span></label>
        <select class="ap-select" name="p_wheels" id="p_wheels" required>
            <option value="" disabled selected>Select wheel count</option>
            <option value="2 wheels" <?php echo ($product['p_wheels'] == '2 wheels') ? 'selected' : ''; ?>>2 Wheels</option>
            <option value="3 wheels" <?php echo ($product['p_wheels'] == '3 wheels') ? 'selected' : ''; ?>>3 Wheels</option>
            <option value="4 wheels" <?php echo ($product['p_wheels'] == '4 wheels') ? 'selected' : ''; ?>>4 Wheels</option>
        </select>



        <label for="p_motor_power">Motor Power:<span class="required-asterisk">required*</span></label>
        <input type="text" id="p_motor_power" name="p_motor_power" value="<?php echo htmlspecialchars($product['p_motor_power']); ?>" required>

        <label for="p_battery">Battery:<span class="required-asterisk">required*</span></label>
        <input type="text" id="p_battery" name="p_battery" value="<?php echo htmlspecialchars($product['p_battery']); ?>" required>

        <label for="p_max_speed">Max Speed:<span class="required-asterisk">required*</span></label>
        <input type="text" id="p_max_speed" name="p_max_speed" value="<?php echo htmlspecialchars($product['p_max_speed']); ?>" required>

        <label for="p_range">Range:<span class="required-asterisk">required*</span></label>
        <input type="text" id="p_range" name="p_range" value="<?php echo htmlspecialchars($product['p_range']); ?>" required>

        <label for="p_max_load">Max Load:<span class="required-asterisk">required*</span></label>
        <input type="text" id="p_max_load" name="p_max_load" value="<?php echo htmlspecialchars($product['p_max_load']); ?>" required>

        <label for="p_charging_time">Charging Time:<span class="required-asterisk">required*</span></label>
        <input type="text" id="p_charging_time" name="p_charging_time" value="<?php echo htmlspecialchars($product['p_charging_time']); ?>" required>

        <label for="p_other_features">Other Features:<span class="required-asterisk"></span></label>
        <textarea id="p_other_features" name="p_other_features"><?php echo htmlspecialchars($product['p_other_features']); ?></textarea>

        <label for="p_variants">Variants:</label>
        <input type="text" id="p_variants" name="p_variants" value="<?php echo htmlspecialchars($product['p_variants']); ?>">

        <label for="p_availability">Availability:</label>
        <select class="ap-select" name="p_availability" id="p_availability" required>
            <option value="" disabled selected>Unit Availabiltity</option>
            <option value="Available" <?php echo ($product['p_availability'] == 'Available') ? 'selected' : ''; ?>>Available</option>
            <option value="Unavailable" <?php echo ($product['p_availability'] == 'Unavailable') ? 'selected' : ''; ?>>Unavailable</option>
            <option value="Out of Stock" <?php echo ($product['p_availability'] == 'Out of Stock') ? 'selected' : ''; ?>>Out of Stock</option>
            <option value="Coming Soon!" <?php echo ($product['p_availability'] == 'Coming Soon!') ? 'selected' : ''; ?>>Coming Soon!</option>
        </select>

        <button type="submit" class="dis-prod-button">Update Product</button>
    </form>

    <form action="config/delete-product.php?id=<?php echo $product['id']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
        <button type="submit" class="dis-prod-delete-button">Delete Product</button>
    </form>
</div>

</body>
</html>
