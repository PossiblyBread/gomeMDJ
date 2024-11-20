<?php
session_start();
include 'config/get-info.php'; // Adjust the path to your database connection file
// Ensure the account ID is passed
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM `accounts` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $sql);
    $account = mysqli_fetch_assoc($result);
    if (!$account) {
        die("Account not found.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Entry</title>
    <link rel="stylesheet" href="style.css">
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

        <form id="apOrderForm" method="POST" action="config/upload-order.php">
            <div id="apAccountDetails" class="apTabContent">
                <div style="display: flex; align-items: center;">
                    <input type="text" id="apSearchInput" placeholder="Enter account email or serial number">
                    <button type="button" onclick="searchAccount()">Search Account</button>
                </div>

                <h2>Account Details</h2>
                <div class="apFormGroup">
                    <label for="apSerialNum">Account Serial Num:</label>
                    <input type="text" id="apSerialNum" name="serial_num" placeholder="Serial Number" required>
                </div>
                <div class="apFormGroup">
                    <label for="apName">Full Name:</label>
                    <input type="text" id="apName" name="full_name" placeholder="Full Name" required>
                </div>
                <div class="apFormGroup">
                    <label for="apEmail">Email:</label>
                    <input type="email" id="apEmail" name="email" placeholder="Email" required>
                </div>
                <div class="apFormGroup">
                    <label for="apPhoneNum">Phone Num:</label>
                    <input type="text" id="apPhoneNum" name="phone_num" placeholder="Phone Number" required>
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
                    <input type="text" id="apProdSerialNum" placeholder="Product Serial Number">
                </div>
                <div class="apFormGroup">
                    <label for="apImages">Image Preview:</label>
                    <img id="apImages" src="../Icons_SVG_repository/imagePlaceholder.svg" alt="Product Image" style="width: 100px; height: auto;">
                </div>
                <div class="apFormGroup">
                    <label for="apPModel">Product Model:</label>
                    <input type="text" id="apPModel" name="p_model" placeholder="Product Model" required>
                </div>
                <div class="apFormGroup">
                    <label for="apPPrice">Price:</label>
                    <input type="text" id="apPPrice" name="p_price" placeholder="Product Price" required>
                </div>
            </div>

            <div id="apAssessmentTab" class="apTabContent" style="display:none;">
                <h2>Assessment</h2>
                <div class="apFormGroup">
                    <label for="paymentMethod">Payment Method:</label>
                    <div>
                        <input type="radio" id="payInFull" name="paymentMethod" value="full" checked onclick="updatePrice()"> Pay in Full
                        <input type="radio" id="installment" name="paymentMethod" value="installment" onclick="updatePrice()"> Installment
                    </div>
                </div>

                <!-- Installment specific fields -->
                <div id="installmentDetails" style="display: none;">
                    <h3>Installment Details</h3>
                    <div class="apFormGroup">
                        <label for="downPayment">Down Payment (10%):</label>
                        <input type="text" id="downPayment" name="downpayment" readonly>
                    </div>
                    <div class="apFormGroup">
                        <label for="remainingBalance">Remaining Balance:</label>
                        <input type="text" id="remainingBalance" name="remaining_balance" readonly>
                    </div>
                    <div class="apFormGroup">
                        <label for="monthlyPayment">Monthly Payment (2.79% P.A.):</label>
                        <input type="text" id="monthlyPayment" name="monthly_installment_price" readonly>
                    </div>
                </div>
                <!-- Assessment specific fields -->
                <div id="AssessmentDetails" style="display: none;">
                    <div class="apFormGroup">
                        <label for="apAssessmentPPrice">Assessment Price:</label>
                        <input type="text" id="apAssessmentPPrice" name="amount_paid" placeholder="Assessment Price" readonly>
                    </div>
                </div>
            </div>

            <button type="button" id="nextButton" onclick="nextTab()" style="display: inline;">Next</button>
            <button type="button" id="submitButton" onclick="showOrderConfirmation()" style="display: none;">Submit Order</button>
        </form>
    </div>

    <!-- Order Confirmation Modal -->
    <div id="orderConfirmationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Order Confirmation</h2>
            <div>
                <h3>Account Details:</h3>
                <p>Serial Num: <span id="confirmAccountSerialNum"></span></p>
                <p>Name: <span id="confirmAccountName"></span></p>
                <p>Email: <span id="confirmAccountEmail"></span></p>
                <p>Phone Num: <span id="confirmAccountPhone"></span></p>
            </div>
            <div>
                <h3>Product Details:</h3>
                <p>Product Serial Num: <span id="confirmProductSerialNum"></span></p>
                <p>Model: <span id="confirmProductModel"></span></p>
                <p>Price: <span id="confirmProductPrice"></span></p>
            </div>

            <button onclick="submitOrder()">Confirm Order</button>
            <button onclick="closeModal()">Cancel</button>
        </div>
    </div>
    <script>
        let apProductsCache = []; // Cache to hold products

        // Fetch all products when the page loads
        window.onload = function() {
            fetchProducts();
            openTab('apAccountDetails');
        };

        function fetchProducts() {
            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'fetch_all_products=1'
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched products data:', data);
                    if (data.success && data.type === 'product') {
                        apProductsCache = data.data;
                        populateProductDropdown(apProductsCache);
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
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
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
            for (let i = 1; i < apDropdown.options.length; i++) {
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
                // Ensure the image path is correct
                const imagePath = apSelectedProduct.Images ? `../uploads/${apSelectedProduct.Images}` : '../Icons_SVG_repository/imagePlaceholder.svg';
                document.getElementById('apImages').src = imagePath;

                document.getElementById('apPModel').value = apSelectedProduct.p_model;
                document.getElementById('apPPrice').value = apSelectedProduct.p_price;
                document.getElementById('apAssessmentPPrice').value = apSelectedProduct.p_price;
            }
        }

        function populateProductDropdown(apProducts) {
            const apDropdown = document.getElementById('apProductDropdown');
            apDropdown.innerHTML = '';
            apDropdown.innerHTML = '<option value="">Select a Product</option>';
            apProducts.forEach(product => {
                const apOption = document.createElement('option');
                apOption.value = product.prod_serial_num;
                apOption.innerText = product.p_model;
                apDropdown.appendChild(apOption);
            });
            apDropdown.onchange = fillProductDetailsFromDropdown;
        }

        // Function to handle tab switching
        function openTab(tabName) {
            const apTabs = document.getElementsByClassName('apTabContent');
            for (let i = 0; i < apTabs.length; i++) {
                apTabs[i].style.display = 'none';
            }
            document.getElementById(tabName).style.display = 'block';
            updateNextButton(tabName);
        }

        // Update the next/submit button visibility
        function updateNextButton(currentTab) {
            const nextButton = document.getElementById('nextButton');
            const submitButton = document.getElementById('submitButton');

            if (currentTab === 'apAccountDetails') {
                nextButton.style.display = 'inline';
                nextButton.innerText = 'Next';
                submitButton.style.display = 'none';
            } else if (currentTab === 'apProductDetails') {
                nextButton.style.display = 'inline';
                nextButton.innerText = 'Next';
                submitButton.style.display = 'none';
            } else if (currentTab === 'apAssessmentTab') {
                nextButton.style.display = 'none';
                submitButton.style.display = 'inline';
            }
        }

        // Function to handle the "Next" button click
        function nextTab() {
            const currentTab = document.querySelector('.apTabContent[style="display: block;"]');
            const currentTabId = currentTab.id;

            if (currentTabId === 'apAccountDetails') {
                openTab('apProductDetails');
            } else if (currentTabId === 'apProductDetails') {
                openTab('apAssessmentTab');
            }
        }
        // for the assessment tab
        function updatePrice() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            const fullPrice = parseFloat(document.getElementById('apPPrice').value);
            const assessmentPriceField = document.getElementById('apAssessmentPPrice');

            if (paymentMethod === 'full') {
                // If "Pay in Full" is selected, show the full price
                assessmentPriceField.value = fullPrice.toFixed(2);
            } else if (paymentMethod === 'installment') {
                const installmentPrice = fullPrice; // Example: 10% down payment
                assessmentPriceField.value = installmentPrice.toFixed(2);
            }
        }
        const annualRate = 2.79; // Fixed Interest Rate at 2.79%
        // Function to update price based on the payment method (full or installment)
        function updatePrice() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            const fullPrice = parseFloat(document.getElementById('apPPrice').value); // Product Price
            const assessmentPriceField = document.getElementById('apAssessmentPPrice');

            if (paymentMethod === 'full') {
                // If "Pay in Full" is selected, show the full price
                assessmentPriceField.value = fullPrice.toFixed(2);

                // Hide installment details fields
                document.getElementById("installmentDetails").style.display = "none";

                // Optionally, set other fields to 0 if needed (such as downpayment and remaining balance)
                document.getElementById('downPayment').value = '0.00';
                document.getElementById('remainingBalance').value = '0.00';
                document.getElementById('monthlyPayment').value = '0.00';
                document.getElementById("AssessmentDetails").style.display = "block";
                // Show the "Assessment Price" input field
                assessmentPriceField.style.display = "block";
            } else if (paymentMethod === 'installment') {
                const dp = fullPrice * 0.10; // Down payment is 10% of the full price
                const amountFinanced = fullPrice - dp; // Amount to be financed after down payment
                const monthlyRate = (annualRate / 100) / 12; // Convert annual rate to monthly rate
                const termMonths = 12; // Term for installment is 12 months

                // Calculate Monthly Payment using the loan formula (PMT formula)
                const monthlyPayment = (amountFinanced * monthlyRate) /
                    (1 - Math.pow(1 + monthlyRate, -termMonths));

                // Set values in the installment details fields
                document.getElementById('downPayment').value = dp.toFixed(2);
                document.getElementById('monthlyPayment').value = monthlyPayment.toFixed(2);

                // Calculate the remaining balance as monthly payment * 12 months
                const remainingBalance = monthlyPayment * 12;
                document.getElementById('remainingBalance').value = remainingBalance.toFixed(2);

                // Calculate the total price for installment: Down payment + (Monthly payment * 12)
                const totalPriceInstallment = dp + (monthlyPayment * 12);

                // Hide the "Assessment Price" field for installment
                assessmentPriceField.style.display = "none";

                // Show installment details
                document.getElementById("installmentDetails").style.display = "block";
                document.getElementById("AssessmentDetails").style.display = "none";
                // Set the "Assessment Price" to 0 for installment
                assessmentPriceField.value = '0.00';
            }
        }
        // Call updatePrice when the page loads to initialize the correct price
        window.onload = function() {
            fetchProducts();
            openTab('apAccountDetails');
            updatePrice(); // Initialize price calculation based on default selection (Pay in Full)
        };
        // Function to display the confirmation modal with order details
        function showOrderConfirmation() {
            const accountDetails = {
                serialNum: document.getElementById('apSerialNum').value,
                name: document.getElementById('apName').value,
                email: document.getElementById('apEmail').value,
                phoneNum: document.getElementById('apPhoneNum').value
            };

            const productDetails = {
                prodSerialNum: document.getElementById('apProdSerialNum').value,
                model: document.getElementById('apPModel').value
            };

            // Get payment method (full or installment)
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            let productPrice;

            if (paymentMethod === 'installment') {
                // If installment is selected, calculate the total price as Down Payment + Remaining Balance
                const downPayment = parseFloat(document.getElementById('downPayment').value);
                const remainingBalance = parseFloat(document.getElementById('remainingBalance').value);
                productPrice = (downPayment + remainingBalance).toFixed(2); // Sum of downpayment and remaining balance
            } else {
                // If full payment is selected, use the original product price
                productPrice = document.getElementById('apPPrice').value;
            }

            // Set account details in the modal
            document.getElementById('confirmAccountSerialNum').innerText = accountDetails.serialNum;
            document.getElementById('confirmAccountName').innerText = accountDetails.name;
            document.getElementById('confirmAccountEmail').innerText = accountDetails.email;
            document.getElementById('confirmAccountPhone').innerText = accountDetails.phoneNum;

            // Set product details in the modal
            document.getElementById('confirmProductSerialNum').innerText = productDetails.prodSerialNum;
            document.getElementById('confirmProductModel').innerText = productDetails.model;
            document.getElementById('confirmProductPrice').innerText = '₱' + productPrice; // Updated product price

            // Show modal
            document.getElementById('orderConfirmationModal').style.display = 'block';
        }


        // Function to close the confirmation modal
        function closeModal() {
            document.getElementById('orderConfirmationModal').style.display = 'none';
        }

        // Function to handle order submission
        function submitOrder() {
            document.getElementById('apOrderForm').submit();
        }
    </script>
</body>

</html>

<style>
    .apContainer {
        min-width: 800px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .apTabs {
        padding-bottom: 10px;
    }

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
    img {
        display: block;
        margin-top: 10px;
        max-width: 150px;
        max-height: 150px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 35%;
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>