
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        table {
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td {
            border: 1px solid #000; 
            padding: 8px; 
            text-align: left;
        }
        th {
            background-color: #f2f2f2; 
        }
        img {
            width: 50px; 
            cursor: pointer; 
        }
        .button {
            background-color: #555; 
            color: white;
            border: none; 
            padding: 5px 10px; 
            border-radius: 4px; 
            cursor: pointer; 
        }
        .button:hover {
            background-color: #333; 
        }
        /* Modal styles */
        .modal {
            display: none; 
            position: fixed;
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.9); 
            padding-top: 60px; 
        }
        .modal-content {
            margin: 50px auto auto 385px;
            display: block;
            width: 30%;
            height: auto;
        }
        .close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h3>Product List</h3>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include ("config/upload-product.php");

                // Fetch products from the database
                $sql = "SELECT * FROM products_tb ORDER BY id DESC"; // Retrieve all products
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die("Error fetching products: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td>
                                <img src="<?php echo $row['images']; ?>" alt="Product Image" onclick="openModal('<?php echo $row['images']; ?>')">
                            </td>
                            <td><?php echo $row['p_model']; ?></td>
                            <td>
                                <a href="more/edit-product.php?id=<?php echo $row['id']; ?>">
                                    <button class="button">View</button>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">No products found.</td>
                    </tr>
                    <?php
                }

                mysqli_close($conn); // Close the database connection
            ?>
        </tbody>
    </table>

    <!-- Modal Structure -->
    <div id="imageModal" class="modal" onclick="closeModal()">
        <span class="close" onclick="closeModal(event)">&times;</span>
        <img class="modal-content" id="modalImage" alt="Product Image">
    </div>

    <script>
        // Function to open the modal
        function openModal(imageSrc) {
            const modal = document.getElementById("imageModal");
            const modalImage = document.getElementById("modalImage");
            modal.style.display = "block"; // Show the modal
            modalImage.src = imageSrc; // Set the source of the image
        }

        // Function to close the modal
        function closeModal(event) {
            if (event) {
                event.stopPropagation(); // Prevent the click event from bubbling up to the modal
            }
            const modal = document.getElementById("imageModal");
            modal.style.display = "none"; // Hide the modal
        }
    </script>

</body>
</html>
