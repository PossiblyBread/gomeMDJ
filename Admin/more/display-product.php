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
        <input type="text" id="prod_serial_num" name="prod_serial_num" value="<?php echo htmlspecialchars($product['prod_serial_num']); ?>" required>

        <label for="p_model">Product Name:</label>
        <input type="text" id="p_model" name="p_model" value="<?php echo htmlspecialchars($product['p_model']); ?>" required>

        <label for="images">Image:</label>
        <input type="file" id="images" name="images" accept="image/*">

        <label for="p_wheels">Wheels:</label>
        <input type="text" id="p_wheels" name="p_wheels" value="<?php echo htmlspecialchars($product['p_wheels']); ?>" required>

        <label for="p_motor_power">Motor Power:</label>
        <input type="text" id="p_motor_power" name="p_motor_power" value="<?php echo htmlspecialchars($product['p_motor_power']); ?>" required>

        <label for="p_battery">Battery:</label>
        <input type="text" id="p_battery" name="p_battery" value="<?php echo htmlspecialchars($product['p_battery']); ?>" required>

        <label for="p_max_speed">Max Speed:</label>
        <input type="text" id="p_max_speed" name="p_max_speed" value="<?php echo htmlspecialchars($product['p_max_speed']); ?>" required>

        <label for="p_range">Range:</label>
        <input type="text" id="p_range" name="p_range" value="<?php echo htmlspecialchars($product['p_range']); ?>" required>

        <label for="p_max_load">Max Load:</label>
        <input type="text" id="p_max_load" name="p_max_load" value="<?php echo htmlspecialchars($product['p_max_load']); ?>" required>

        <label for="p_charging_time">Charging Time:</label>
        <input type="text" id="p_charging_time" name="p_charging_time" value="<?php echo htmlspecialchars($product['p_charging_time']); ?>" required>

        <label for="p_other_features">Other Features:</label>
        <textarea id="p_other_features" name="p_other_features"><?php echo htmlspecialchars($product['p_other_features']); ?></textarea>

        <label for="p_price">Price:</label>
        <input type="text" id="p_price" name="p_price" value="<?php echo htmlspecialchars($product['p_price']); ?>" required>

        <label for="p_variants">Variants:</label>
        <input type="text" id="p_variants" name="p_variants" value="<?php echo htmlspecialchars($product['p_variants']); ?>">

        <button type="submit" class="dis-prod-button">Update Product</button>
    </form>

    <form action="config/delete-product.php?id=<?php echo $product['id']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
        <button type="submit" class="dis-prod-delete-button">Delete Product</button>
    </form>
</div>

</body>
</html>
