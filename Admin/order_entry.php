<?php
include '../body/admin/config/get-info.php'; // Adjust the path to your database connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Entry</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let productsCache = []; // Cache to hold products

        // Fetch all products when the page loads
        window.onload = function() {
            fetchProducts();
            openTab('accountDetails'); // Automatically open the first tab
        };

        function fetchProducts() {
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'fetch_all_products=1' // Request to fetch all products
            })
            .then(response => response.json())
            .then(data => {
                console.log('Fetched products data:', data); // Log fetched data
                if (data.success && data.type === 'product') {
                    productsCache = data.data; // Cache the products
                    populateProductDropdown(productsCache); // Populate dropdown with products
                } else {
                    console.error('Failed to fetch products:', data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
        }

        function searchAccount() {
            const searchValue = document.getElementById('search-input').value;
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'search_value=' + encodeURIComponent(searchValue)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.type === 'account') {
                    document.getElementById('serial_num').value = data.data.serial_num;
                    document.getElementById('name').value = data.data.first_name + ' ' + data.data.last_name;
                    document.getElementById('email').value = data.data.email;
                    document.getElementById('phone_num').value = data.data.phone_num;
                } else {
                    alert('No account found with that email or serial number.');
                }
            });
        }

        function searchProduct() {
            const searchValue = document.getElementById('product-search-input').value.toLowerCase(); // Convert to lowercase
            const dropdown = document.getElementById('product-dropdown');

            // Filter the options based on the search value
            for (let i = 1; i < dropdown.options.length; i++) { // Start from 1 to skip the default option
                const option = dropdown.options[i];
                option.style.display = option.text.toLowerCase().includes(searchValue) ? 'block' : 'none';
            }
        }

        function fillProductDetailsFromDropdown() {
            const dropdown = document.getElementById('product-dropdown');
            const selectedProduct = productsCache.find(p => p.prod_serial_num === dropdown.value);

            if (selectedProduct) {
                // Fill in product details
                document.getElementById('prod_serial_num').value = selectedProduct.prod_serial_num;
                document.getElementById('images').src = selectedProduct.images;
                document.getElementById('p_model').value = selectedProduct.p_model;
                document.getElementById('p_price').value = selectedProduct.p_price;
                document.getElementById('assessment_p_price').value = selectedProduct.p_price; // Set price in assessment tab as well
            }
        }

        function populateProductDropdown(products) {
            const dropdown = document.getElementById('product-dropdown');
            dropdown.innerHTML = ''; // Clear previous options
            dropdown.innerHTML = '<option value="">Select a Product</option>'; // Reset with a default option
            products.forEach(product => {
                const option = document.createElement('option');
                option.value = product.prod_serial_num; // Use product serial number as value
                option.innerText = product.p_model; // Display product model
                dropdown.appendChild(option);
            });
            dropdown.onchange = fillProductDetailsFromDropdown; // Call fillProductDetails on change
        }
    </script>
</head>
<body>
    <?php include '../body/admin/side-nav.php'; ?>
    <div class="container">
        <h1>Order Entry</h1>

        <div class="tabs">
            <button class="tab" onclick="openTab('accountDetails')">Account Details</button>
            <button class="tab" onclick="openTab('productDetails')">Product Details</button>
            <button class="tab" onclick="openTab('assessmentTab')">Assessment</button>
        </div>

        <form id="orderForm" method="POST" action="../body/admin/config/upload-order.php"> <!-- Adjust action URL as necessary -->
            <div id="accountDetails" class="tab-content">
                <div style="display: flex; align-items: center;">
                    <input type="text" id="search-input" placeholder="Enter account email or serial number">
                    <button type="button" onclick="searchAccount()">Search Account</button>
                </div>

                <h2>Account Details</h2>
                <div class="form-group">
                    <label for="serial_num">Serial Num:</label>
                    <input type="text" id="serial_num" name="serial_num" placeholder="Serial Number" readonly>
                </div>
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="user_name" placeholder="Full Name" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email" readonly>
                </div>
                <div class="form-group">
                    <label for="phone_num">Phone Num:</label>
                    <input type="text" id="phone_num" name="phone_num" placeholder="Phone Number" readonly>
                </div>
            </div>

            <div id="productDetails" class="tab-content" style="display:none;">
                <h2>Product Details</h2>
                <div class="flex-container">
                    <input type="text" id="product-search-input" placeholder="Search for a Product Model" oninput="searchProduct()">
                    <select id="product-dropdown" name="product_id">
                        <option value="">Select a Product</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="prod_serial_num">Product Serial Num:</label>
                    <input type="text" id="prod_serial_num" name="prod_serial_num" placeholder="Product Serial Number" readonly>
                </div>
                <div class="form-group">
                    <label for="images">Image Preview:</label>
                    <img id="images" src="" alt="Product Image" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg viewBox=\'0 0 120 120\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg id=\'SVGRepo_bgCarrier\' stroke-width=\'0\'%3E%3C/g%3E%3Cg id=\'SVGRepo_tracerCarrier\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3C/g%3E%3Cg id=\'SVGRepo_iconCarrier\'%3E%3Crect width=\'120\' height=\'120\' fill=\'%23EFF1F3\'%3E%3C/rect%3E%3Cpath fill-rule=\'evenodd\' clip-rule=\'evenodd\' d=\'M33.2503 38.4816C33.2603 37.0472 34.4199 35.8864 35.8543 35.875H83.1463C84.5848 35.875 85.7503 37.0431 85.7503 38.4816V80.5184C85.7403 81.9528 84.5807 83.1136 83.1463 83.125H35.8543C34.4158 83.1236 33.2503 81.957 33.2503 80.5184V38.4816ZM80.5006 41.1251H38.5006V77.8751L62.8921 53.4783C63.9172 52.4536 65.5788 52.4536 66.6039 53.4783L80.5006 67.4013V41.1251ZM43.75 51.6249C43.75 54.5244 46.1005 56.8749 49 56.8749C51.8995 56.8749 54.25 54.5244 54.25 51.6249C54.25 48.7254 51.8995 46.3749 49 46.3749C46.1005 46.3749 43.75 48.7254 43.75 51.6249Z\' fill=\'%23687787\'%3E%3C/path%3E%3C/g%3E%3C/svg%3E';">            
                </div>
                <div class="form-group">
                    <label for="p_model">Product Model:</label>
                    <input type="text" id="p_model" name="p_model" placeholder="Product Model" readonly>
                </div>
                <div class="form-group">
                    <label for="p_price">Product Price:</label>
                    <input type="text" id="p_price" name="product_price" placeholder="Product Price" readonly>
                </div>
            </div>

            <div id="assessmentTab" class="tab-content" style="display:none;">
                <h2>Assessment</h2>
                
                <div class="form-group">
                    <label for="assessment_p_price">Assessment Price:</label>
                    <input type="text" id="assessment_p_price" name="assessment_price" placeholder="Assessment Price" readonly>
                </div>

                <div class="form-group">
                    <label>Payment Option:</label>
                    <label>
                        <input type="radio" name="payment_option" value="full" onclick="updatePrice()"> Full Payment
                    </label>
                    <label>
                        <input type="radio" name="payment_option" value="installment" onclick="updatePrice()"> Installment
                    </label>
                </div>

                <div class="form-group" id="installment-details" style="display:none;">
                    <label for="installment_months">Number of Months:</label>
                    <input type="number" id="installment_months" name="installment_months" placeholder="Enter number of months" min="1" onchange="updatePrice()">
                </div>

                <div class="form-group">
                    <label for="final_price">Final Price:</label>
                    <input type="text" id="final_price" name="due_to_be_paid" placeholder="Final Price" readonly>
                </div>

                <input type="hidden" id="user_id" name="user_id" value="<!-- Your user ID here -->">
                <input type="hidden" id="user_name" name="user_name" value="<!-- Your user name here -->">
            </div>

            <button type="submit">Submit Order</button>
        </form>
    </div>

    <script>
        function openTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.style.display = 'none'; // Hide all tabs
            });
            document.getElementById(tabName).style.display = 'block'; // Show the selected tab
        }

        document.getElementById('orderForm').onsubmit = function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Gather data from the form
            const formData = new FormData(this);

            // Send form data to the server
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order submitted successfully!');
                    // Optionally, you could reset the form or redirect
                    this.reset();
                } else {
                    alert('Failed to submit order: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error submitting form:', error);
                alert('An error occurred. Please try again.');
            });
        };
        function updatePrice() {
            const basePrice = parseFloat(document.getElementById('p_price').value) || 0; // Get the base price from the product details
            const paymentOption = document.querySelector('input[name="payment_option"]:checked');
            const finalPriceField = document.getElementById('final_price');
            const installmentMonthsField = document.getElementById('installment_months');
            
            if (paymentOption) {
                if (paymentOption.value === 'full') {
                    finalPriceField.value = basePrice.toFixed(2); // Set final price to base price
                    installmentMonthsField.value = ''; // Clear the installment months input
                    document.getElementById('installment-details').style.display = 'none'; // Hide installment details
                } else if (paymentOption.value === 'installment') {
                    document.getElementById('installment-details').style.display = 'block'; // Show installment details
                    const months = parseInt(installmentMonthsField.value) || 0;
                    if (months > 0) {
                        const installmentPrice = basePrice * Math.pow(1.02, months); // Calculate price with 2% increase per month
                        finalPriceField.value = installmentPrice.toFixed(2.79); // Set final price based on installment
                    } else {
                        finalPriceField.value = ''; // Clear final price if no months are selected
                    }
                }
            }
        }
    </script>
</body>
</html>
<style>
    /* General styles */
.container {
    max-width: 800px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Headings */
h1 {
    text-align: center;
    color: #333;
}

h2 {
    margin-top: 20px;
    margin-bottom: 10px;
    border-bottom: 2px solid #ccc; /* Light gray border */
    padding-bottom: 5px;
    color: #555; /* Dark gray color */
}

/* Form styles */
form {
    margin-bottom: 20px; /* Space between forms */
}

/* Flex styles for label and input */
.form-group {
    display: flex;
    align-items: center;
    padding-top: 10px;
    margin-bottom: 15px; /* Space between each form group */
}

label {
    flex: 0 0 150px; /* Fixed width for labels */
    font-weight: bold; /* Bold for visibility */
    color: #444; /* Darker gray for labels */
}

/* Input fields */
input[type="text"],
input[type="email"],
select {
    flex: 1; /* Allow inputs to take the remaining space */
    padding: 10px;
    margin-left: 10px; /* Space between label and input */
    border: 1px solid #ccc; /* Light gray border */
    border-radius: 4px;
    box-sizing: border-box; /* Ensures padding is included in width */
}

input[readonly] {
    background-color: #e9ecef; /* Light gray for readonly fields */
    cursor: not-allowed; /* Change cursor for readonly fields */
}

/* Flex styles for search bar and dropdown */
.flex-container {
    display: flex;
    align-items: center; /* Align items vertically centered */
    margin-bottom: 15px; /* Space below the container */
}

.flex-container input[type="text"] {
    flex: 1; /* Allow the search input to take remaining space */
    margin-right: -10px; /* Space between search input and dropdown */
}

.flex-container select {
    flex: 0 0 150px; /* Fixed width for the dropdown */
}


/* Buttons */
button {
    padding: 10px 15px;
    background-color: #ccc; /* Light gray */
    color: #333; /* Dark text for contrast */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #bbb; /* Darker gray on hover */
}

/* Image preview */
img {
    display: block;
    margin-top: 10px;
    max-width: 150px; /* Limit image size */
    max-height: 150px;
}

</style>