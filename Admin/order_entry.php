<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Purchase Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="purchase-details">
        <div class="customer-info">
            <span class="label">Customer ID:</span>
            <input type="text" id="customer-id" name="customer-id">
        </div>
        <div class="customer-info">
            <span class="label">Customer Name:</span>
            <input type="text" id="customer-name" name="customer-name">
        </div>
        <div class="product-info">
            <span class="label">Product Name:</span>
            <input type="text" id="product-name" name="product-name">
        </div>
        <div class="product-info">
            <span class="label">Price:</span>
        </div>
        <div class="payment-info">
            <span class="label">Payment Type:</span>
            <div class="payment-options">
                <input type="radio" id="full-payment" name="payment-type" value="full-payment" checked>
                <label for="full-payment">Full Payment</label><br>
                <input type="radio" id="installment" name="payment-type" value="installment">
                <label for="installment">Installment</label>
                <div class="installment-details">
                    <label>Months:</label>
                    <div class="radio-group">
                        <input type="radio" id="radio-months-3" name="installment-period" value="3">
                        <label for="radio-months-3">3</label>

                        <input type="radio" id="radio-months-6" name="installment-period" value="6">
                        <label for="radio-months-6">6</label>

                        <input type="radio" id="radio-months-9" name="installment-period" value="9">
                        <label for="radio-months-9">9</label>
                    </div>

                    <label>Year/s:</label>
                    <div class="radio-group">
                        <input type="radio" id="radio-years-1" name="installment-period" value="12">
                        <label for="radio-years-1">1</label>

                        <input type="radio" id="radio-years-2" name="installment-period" value="24">
                        <label for="radio-years-2">2</label>

                        <input type="radio" id="radio-years-3" name="installment-period" value="36">
                        <label for="radio-years-3">3</label>
                    </div>
                </div>
            </div>
        </div>
        <button type="pay-update" class="btn btn-success" name="Submit">Register</button> 
        <button class="back-button" onclick="window.history.back();">Back</button>
    </div>
</body>
</html>
<style>body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
}

.purchase-details {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: auto;
}

.product-info, .customer-info, .payment-info {
    margin-bottom: 15px;
}

.label {
    font-weight: bold;
    display: inline-block;
    width: 120px;
}

.value {
    display: inline-block;
    color: #333;
}

.payment-options {
    margin-top: 10px;
}

.installment-details {
    margin-top: 10px;
    display: none; /* This hides the installment options by default */
}

.radio-group {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.radio-group input[type="radio"] {
    margin-right: 5px;
    margin-left: 10px; /* Adds spacing between the label and the next radio button */
}

.payment-options input[type="radio"]:checked + label {
    font-weight: bold;
}

#installment:checked ~ .installment-details {
    display: block; /* This shows the installment options when 'Installment' is selected */
}

</style>