<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); include'nav.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 60%;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

.inputBox {
    margin-bottom: 20px;
}

.inputBox span {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.box {
    width: 90%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    text-decoration: none;
    background-color: teal;
    color: #fff;
    border-radius: 5px;
    transition: background-color 0.3s;
    cursor: pointer;
}

.btn:hover {
    background-color: #008CBA;
}

    </style>
</head>
<body>
    <br><br><br><br>
    <div class="container">
        <h2>Checkout</h2>
        <form action="process_checkout.php" method="post">
            <div class="inputBox">
                <span>Your name:</span>
                <input type="text" name="name" placeholder="Name" class="box" required>
            </div>
            <div class="inputBox">
                <span>Your number:</span>
                <input type="number" name="number" placeholder="Mobile number" class="box" required>
            </div>
            <div class="inputBox">
                <span>Your email:</span>
                <input type="email" name="email" placeholder="Email" class="box" required>
            </div>
            <div class="inputBox">
                <span>Payment method:</span>
                <select name="method" class="box" required>
                    <option value="cash on delivery">Cash on delivery</option>
                    <option value="credit card">Credit card</option>
                    <option value="paytm">Paytm</option>
                    <option value="paypal">GPay</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Door no:</span>
                <input type="text" name="flat" placeholder="Enter door/flat no" class="box" required>
            </div>
            <div class="inputBox">
                <span>Street name:</span>
                <input type="text" name="street" placeholder="Street name" class="box" required>
            </div>
            <div class="inputBox">
                <span>City:</span>
                <input type="text" name="city" placeholder="City" class="box" required>
            </div>

            <!-- Hidden input fields for quantities, product_ids, and grand_total -->
            <?php
            // Include your session_start and database connection here
            

            // Check if the user is logged in as a buyer
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'buyer') {
                header("location: login.php");
                exit();
            }

            // Check if the cart session variable is set
            if (!isset($_SESSION['bid']) || empty($_SESSION['bid'])) {
                // Redirect to the product display page if the cart is empty
                header("location: display.php");
                exit();
            }

            // Retrieve values from the session or wherever they are stored
            $quantities = $_SESSION['quantities'] ?? [];
            $product_ids = $_SESSION['product_ids'] ?? [];
            $grand_total = $_SESSION['grand_total'] ?? 0;

            // Output hidden fields
            foreach ($quantities as $quantity) {
                echo '<input type="hidden" name="quantities[]" value="' . $quantity . '">';
            }

            foreach ($product_ids as $product_id) {
                echo '<input type="hidden" name="product_ids[]" value="' . $product_id . '">';
            }

            echo '<input type="hidden" name="grand_total" value="' . $grand_total . '">';
            ?>

            <!-- Continue with the rest of your form -->
            <input type="submit" name="order" class="btn" value="Place Order">
        </form>
    </div>
</body>
</html>
