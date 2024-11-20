<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); 
    exit("Access denied");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <div class="dashboard-container">
        <section class="promos-section section-box">
            <?php include 'more/promos.php'; ?>
        </section>
        <section class="content-section section-box">
            <section class="products-section">
                <section id="productsListSection" class="products-list section-box">
                    <button onclick="window.location.href='more/add-product.php'" class="toggle-button add-product-btn">
                        <span class="button-text">Add Product</span>
                        <span class="button-icon">+</span>
                    </button>
                    <h3 class="section-title">Product List</h3>
                    <div class="table-container">
                        <table class="products-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Serial Number</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query to fetch all products
                                $sql = "SELECT p.*, GROUP_CONCAT(pi.Images) AS all_images, GROUP_CONCAT(pi.image_type) AS image_types 
                                        FROM products_tb p 
                                        LEFT JOIN products_img_id pi ON p.products_id = pi.products_id 
                                        GROUP BY p.products_id 
                                        ORDER BY p.products_id DESC";

                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $images = !empty($row['all_images']) ? explode(',', $row['all_images']) : [];
                                        $imageTypes = !empty($row['image_types']) ? explode(',', $row['image_types']) : [];
                                        $coverImage = "path/to/default-image.jpg"; // Default image path

                                        foreach ($images as $index => $image) {
                                            if ($imageTypes[$index] === 'cover') {
                                                $coverImage = '../uploads/' . basename($image);
                                                break;
                                            }
                                        }
                                ?>
                                        <tr class="product-row">
                                            <td class="product-image">
                                                <img src="<?php echo $coverImage; ?>" alt="Product Image" loading="lazy">
                                            </td>
                                            <td class="product-serial"><?php echo htmlspecialchars($row['prod_serial_num']); ?></td>
                                            <td class="product-name"><?php echo htmlspecialchars($row['p_model']); ?></td>
                                            <td class="product-price">₱<?php echo number_format($row['p_price'], 2); ?></td>
                                            <td class="product-action">
                                                <button class="action-button" id="view" onclick="window.location.href='more/edit-product.php?id=<?php echo $row['products_id']; ?>'">Edit</button>
                                                <button class="action-button" id="delete" onclick="window.location.href='config/delete-product.php?id=<?php echo $row['products_id']; ?>'">Delete</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="no-products">No products found.</td>
                                    </tr>
                                <?php
                                }
                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </section>
        </section>
    </div>
    <style>
        .dashboard-container {
            display: flex;
            flex-direction: column;
            position: absolute;
            bottom: 0;
            left: 150px;
            width: calc(100% - 150px);
            height: 90%;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .section-box {
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
        }

        .toggle-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .add-product-btn {
            background-color: #4CAF50;
            color: white;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
        }

        .section-title {
            color: #2c3e50;
            font-size: 1.8em;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            max-height: 600px;
        }

        .products-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background: white;
        }

        th {
            background-color: #f8fafc;
            color: #2c3e50;
            font-weight: 600;
            text-transform: uppercase;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .product-image img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .action-button {
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .action-button#view {
            background-color: #4CAF50;
            
        }
        .action-button#delete {
            background-color: maroon;
            
        }

        @media (max-width: 768px) {
            .dashboard-container {
                left: 0;
                width: 100%;
            }

            .section-box {
                margin: 10px;
            }

            .section-title {
                font-size: 1.5em;
            }
        }
    </style>
</body>

</html>