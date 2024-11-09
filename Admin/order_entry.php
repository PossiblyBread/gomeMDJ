<?php
include 'config/get-info.php'; // Adjust the path to your database connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Entry</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let apProductsCache = []; // Cache to hold products

        // Fetch all products when the page loads
        window.onload = function() {
            fetchProducts();
            openTab('apAccountDetails'); // Automatically open the first tab
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
                    apProductsCache = data.data; // Cache the products
                    populateProductDropdown(apProductsCache); // Populate dropdown with products
                } else {
                    console.error('Failed to fetch products:', data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
        }

        function searchAccount() {
            const apSearchValue = document.getElementById('apSearchInput').value;
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'search_value=' + encodeURIComponent(apSearchValue)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.type === 'account') {
                    document.getElementById('apSerialNum').value = data.data.serial_num;
                    document.getElementById('apName').value = data.data.first_name + ' ' + data.data.last_name;
                    document.getElementById('apEmail').value = data.data.email;
                    document.getElementById('apPhoneNum').value = data.data.phone_num;
                } else {
                    alert('No account found with that email or serial number.');
                }
            });
        }

        function searchProduct() {
            const apSearchValue = document.getElementById('apProductSearchInput').value.toLowerCase(); // Convert to lowercase
            const apDropdown = document.getElementById('apProductDropdown');

            // Filter the options based on the search value
            for (let i = 1; i < apDropdown.options.length; i++) { // Start from 1 to skip the default option
                const apOption = apDropdown.options[i];
                apOption.style.display = apOption.text.toLowerCase().includes(apSearchValue) ? 'block' : 'none';
            }
        }

        function fillProductDetailsFromDropdown() {
            const apDropdown = document.getElementById('apProductDropdown');
            const apSelectedProduct = apProductsCache.find(p => p.prod_serial_num === apDropdown.value);

            if (apSelectedProduct) {
                // Fill in product details
                document.getElementById('apProdSerialNum').value = apSelectedProduct.prod_serial_num;
                document.getElementById('apImages').src = apSelectedProduct.images;
                document.getElementById('apPModel').value = apSelectedProduct.p_model;
                document.getElementById('apPPrice').value = apSelectedProduct.p_price;
                document.getElementById('apAssessmentPPrice').value = apSelectedProduct.p_price; // Set price in assessment tab as well
            }
        }

        function populateProductDropdown(apProducts) {
            const apDropdown = document.getElementById('apProductDropdown');
            apDropdown.innerHTML = ''; // Clear previous options
            apDropdown.innerHTML = '<option value="">Select a Product</option>'; // Reset with a default option
            apProducts.forEach(product => {
                const apOption = document.createElement('option');
                apOption.value = product.prod_serial_num; // Use product serial number as value
                apOption.innerText = product.p_model; // Display product model
                apDropdown.appendChild(apOption);
            });
            apDropdown.onchange = fillProductDetailsFromDropdown; // Call fillProductDetails on change
        }
    </script>
</head>
<body>
    <?php include 'side-nav.php'; ?>
    <div class="apContainer">
        <h1>Order Entry</h1>

        <div class="apTabs">
            <button class="apTab" onclick="openTab('apAccountDetails')">Account Details</button>
            <button class="apTab" onclick="openTab('apProductDetails')">Product Details</button>
            <button class="apTab" onclick="openTab('apAssessmentTab')">Assessment</button>
        </div>

        <form id="apOrderForm" method="POST" action="config/upload-order.php"> <!-- Adjust action URL as necessary -->
            <div id="apAccountDetails" class="apTabContent">
                <div style="display: flex; align-items: center;">
                    <input type="text" id="apSearchInput" placeholder="Enter account email or serial number">
                    <button type="button" onclick="searchAccount()">Search Account</button>
                </div>

                <h2>Account Details</h2>
                <div class="apFormGroup">
                    <label for="apSerialNum">Serial Num:</label>
                    <input type="text" id="apSerialNum" name="serial_num" placeholder="Serial Number" readonly>
                </div>
                <div class="apFormGroup">
                    <label for="apName">Full Name:</label>
                    <input type="text" id="apName" name="user_name" placeholder="Full Name" readonly>
                </div>
                <div class="apFormGroup">
                    <label for="apEmail">Email:</label>
                    <input type="email" id="apEmail" name="email" placeholder="Email" readonly>
                </div>
                <div class="apFormGroup">
                    <label for="apPhoneNum">Phone Num:</label>
                    <input type="text" id="apPhoneNum" name="phone_num" placeholder="Phone Number" readonly>
                </div>
            </div>

            <div id="apProductDetails" class="apTabContent" style="display:none;">
                <h2>Product Details</h2>
                <div class="apFlexContainer">
                    <input type="text" id="apProductSearchInput" placeholder="Search for a Product Model" oninput="searchProduct()">
                    <select id="apProductDropdown" name="product_id">
                        <option value="">Select a Product</option>
                    </select>
                </div>
                <div class="apFormGroup">
                    <label for="apProdSerialNum">Product Serial Num:</label>
                    <input type="text" id="apProdSerialNum" name="prod_serial_num" placeholder="Product Serial Number" readonly>
                </div>
                <div class="apFormGroup">
                    <label for="apImages">Image Preview:</label>
                    <img id="apImages" src="" alt="Product Image" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg viewBox=\'0 0 120 120\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg id=\'SVGRepo_bgCarrier\' stroke-width=\'0\'%3E%3C/g%3E%3Cg id=\'SVGRepo_tracerCarrier\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3C/g%3E%3Cg id=\'SVGRepo_iconCarrier\'%3E%3Crect width=\'120\' height=\'120\' fill=\'%23EFF1F3\'%3E%3C/rect%3E%3Cpath fill-rule=\'evenodd\' clip-rule=\'evenodd\' d=\'M33.2503 38.4816C33.2603 37.0472 34.4199 35.8864 35.8543 35.875H83.1463C84.5848 35.875 85.7503 37.0431 85.7503 38.4816V80.5184C85.7403 81.9528 84.5807 83.1136 83.1463 83.125H35.8543C34.4158 83.1236 33.2503 81.957 33.2503 80.5184V38.4816ZM80.5006 41.1251H38.5006V77.8751L62.8921 53.4783C63.9172 52.4536 65.5788 52.4536 66.6039 53.4783L80.5006 67.4013V41.1251ZM43.75 51.6249C43.75 54.5244 46.1005 56.8749 49 56.8749C51.8995 56.8749 54.25 54.5244 54.25 51.6249C54.25 48.7254 51.8995 46.3749 49 46.3749C46.1005 46.3749 43.75 48.7254 43.75 51.6249ZM49 55.3749C47.4477 55.3749 46.25 54.1772 46.25 52.6249C46.25 51.0726 47.4477 49.8749 49 49.8749C50.5523 49.8749 51.75 51.0726 51.75 52.6249C51.75 54.1772 50.5523 55.3749 49 55.3749Z\' fill=\'%236A6A6A\'%3E%3C/path%3E%3C/g%3E%3C/svg%3E';">
                </div>
                <div class="apFormGroup">
                    <label for="apPModel">Product Model:</label>
                    <input type="text" id="apPModel" name="product_model" placeholder="Product Model" readonly>
                </div>
                <div class="apFormGroup">
                    <label for="apPPrice">Price:</label>
                    <input type="text" id="apPPrice" name="price" placeholder="Price" readonly>
                </div>
            </div>

            <div id="apAssessmentTab" class="apTabContent" style="display:none;">
                <h2>Assessment</h2>
                <div class="apFormGroup">
                    <label for="apAssessmentPPrice">Assessment Price:</label>
                    <input type="text" id="apAssessmentPPrice" name="assessment_price" placeholder="Assessment Price" readonly>
                </div>
                <!-- Add other assessment-related fields here -->
            </div>

            <button type="submit">Submit Order</button>
        </form>
    </div>

    <script>
        function openTab(tabName) {
            const apTabs = document.getElementsByClassName('apTabContent');
            for (let i = 0; i < apTabs.length; i++) {
                apTabs[i].style.display = 'none'; // Hide all tabs
            }
            document.getElementById(tabName).style.display = 'block'; // Show selected tab
        }
    </script>
</body>
</html>
<style>
    .apContainer {
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
    border-bottom: 2px solid #ccc;
    padding-bottom: 5px;
    color: #555; 
}

/* Form styles */
form {
    margin-bottom: 20px; 
}

/* Flex styles for label and input */
.apFormGroup {
    display: flex;
    align-items: center;
    padding-top: 10px;
    margin-bottom: 15px;
}

label {
    flex: 0 0 150px;
    font-weight: bold; 
    color: #444; 
}

/* Input fields */
input[type="text"],
input[type="email"],
select {
    flex: 1;
    padding: 10px;
    margin-left: 10px;
    border: 1px solid #ccc; 
    border-radius: 4px;
    box-sizing: border-box;
}

input[readonly] {
    background-color: #e9ecef;
    cursor: not-allowed; 
}

/* Flex styles for search bar and dropdown */
.apFlexContainer {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.apFlexContainer input[type="text"] {
    flex: 1; 
    margin-right: -10px; 
}

.apFlexContainer select {
    flex: 0 0 150px; 
}

/* Buttons */
button {
    padding: 10px 15px;
    background-color: #ccc;
    color: #333; 
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #bbb;
}

/* Image preview */
.apFormGroup img {
    display: block;
    margin-top: 10px;
    max-width: 150px; 
    max-height: 150px;
}

</style>