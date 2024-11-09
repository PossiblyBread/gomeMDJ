<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promos Carousel</title>
</head>
<body>
    <div class="dash-cont-container">
        <section class="promos-section section-box">
            <?php include 'more/promos.php'; ?>
        </section>

        <section class="dash-cont-bottom-section section-box">
            <section class="dash-cont-left-section">
                <section class="dash-cont-left-top section-box">
                    <?php include 'more/add-product.php'; ?>
                </section>
                <section class="dash-cont-left-bottom section-box">
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
                                                <img src="<?php echo $row['images']; ?>" alt="Product Image" onclick="loadProductDetails(<?php echo $row['id']; ?>)">
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
                                        <td colspan="3">No products found.</td>
                                    </tr>
                                    <?php
                                }

                                mysqli_close($conn); // Close the database connection
                            ?>
                        </tbody>
                    </table>
                </section>
            </section>

            <section class="view-product-section section-box" id="viewProductSection">
                <!-- Loaded content will show here -->
            </section>
        </section>
    </div>

    <script>
        // Toggle delete mode to show/hide checkboxes and confirm delete button
        function toggleDeleteMode() {
            const deleteCheckboxColumn = document.querySelectorAll('.delete-checkbox-column');
            const confirmDeleteButton = document.getElementById('confirm-delete-button');
            const isDeleteMode = deleteCheckboxColumn[0].style.display === 'none';

            deleteCheckboxColumn.forEach(column => {
                column.style.display = isDeleteMode ? 'table-cell' : 'none';
            });
            confirmDeleteButton.style.display = isDeleteMode ? 'inline-block' : 'none';
        }

        // Confirm delete function to handle deletion of selected items
        function confirmDelete() {
            const selectedCheckboxes = document.querySelectorAll('.delete-checkbox:checked');
            const idsToDelete = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

            if (idsToDelete.length === 0) {
                alert("Please select at least one product to delete.");
                return;
            }

            if (confirm("Are you sure you want to delete the selected products?")) {
                fetch('config/delete-product.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: idsToDelete })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Selected products have been deleted successfully.");
                        location.reload(); // Reload the page to refresh the product list
                    } else {
                        alert("An error occurred while deleting products.");
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Function to load product details into the view-product-section
        function loadProductDetails(productId) {
            const viewSection = document.getElementById('viewProductSection');
            fetch(`more/display-product.php?id=${productId}`)
                .then(response => response.ok ? response.text() : Promise.reject("Failed to load product details"))
                .then(html => viewSection.innerHTML = html)
                .catch(error => console.error('There has been a problem with your fetch operation:', error));
        }
    </script>
</body>
</html>
<style>
/* General container styling */
.dash-cont-container {
    display: flex;
    flex-direction: column;
    position: absolute;
    bottom: 0;
    left: 150px; 
    width: calc(100% - 150px);
    height: 90%;
    box-sizing: border-box;
}

/* Box styling for sections */
.section-box {
    background-color: #6e89a0; 
    border-radius: 10px;
    padding: 20px; 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
    margin-bottom: 20px;
    margin-left: 20px;
    margin-right: 20px;
}

/* Promos section styling */
.promos-section {
    background-color: #f1f6fa; 
    flex: 0 0 50%; 
    display: flex;
    flex-direction: column;
    color: white;
    font-size: 1.5em;
    box-sizing: border-box;
}

.promos-header {
    align-self: flex-start;
    font-size: 1.8em;
    font-weight: bold;
}

/* Dashboard bottom section styling */
.dash-cont-bottom-section {
    display: flex;
    flex: 1;
}

/* Left section styling */
.dash-cont-left-section {
    display: flex;
    flex-direction: column;
    flex: 2;
}

/* Left top section styling */
.dash-cont-left-top {
    flex: 0 0 auto;
    background-color: #f1f6fa; 
}

/* Left bottom section styling */
.dash-cont-left-bottom {
    overflow-y: auto; 
    flex: 1; 
    padding: 20px;
    box-sizing: border-box;
    background-color: #f1f6fa; 
}

/* Product view section styling */
.view-product-section {
    background-color: #f1f6fa; 
    flex: 1;
    padding: 20px; 
    box-sizing: border-box;
}

/* Table styling */
table {
    width: 100%; 
    border-collapse: separate;
    border-spacing: 0; 
}

th, td {
    border: 1px solid #000; 
    padding: 8px;
    text-align: center; 
    border-radius: 10px; 
}

/* Ensure header cells have rounded corners */
th:first-child {
    border-top-left-radius: 10px;
}

th:last-child {
    border-top-right-radius: 10px; 
}

tbody tr:last-child td:first-child {
    border-bottom-left-radius: 10px; 
}

tbody tr:last-child td:last-child {
    border-bottom-right-radius: 10px; 
}

th {
    background-color: #f2f2f2;
}

/* Image styling */
img {
    width: 50px; 
    cursor: pointer;
}

/* Button styling */
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

/* New Styles for Delete Mode */
#delete-button {
    margin-left: 10px;
}

.delete-checkbox-column {
    display: none; 
}

/* Confirm Delete Button */
#confirm-delete-button {
    display: none;
}

</style>