<?php
session_start();

// Include your database connection file here
require 'db.php';
include 'nav.php';
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

$buyer_id = $_SESSION['bid'];

// Handle remove action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_cart_id'])) {
    $remove_cart_id = $_POST['remove_cart_id'];

    // Remove the product from the cart table
    $deleteResult = pg_query_params($conn, "DELETE FROM cart WHERE id = $1", array($remove_cart_id));

    if ($deleteResult) {
        $_SESSION['message'] = "";
    } else {
        $_SESSION['message'] = "Failed to remove product from cart!";
    }

    header("location: my_cart.php");
    exit();
}

// Retrieve products from the cart
$sql = "SELECT c.id as cart_id, p.id, p.name AS product_name, p.price, p.imagepath, f.name AS farmer_name, c.quantity, c.total_price
        FROM cart c
        JOIN product p ON c.product_id = p.id
        JOIN farmer f ON p.fid = f.id
        WHERE c.buyer_id = $1";

$result = pg_query_params($conn, $sql, array($buyer_id));

// Fetch the cart products
$cartProducts = array();
while ($row = pg_fetch_assoc($result)) {
    $cartProducts[] = $row;
}

// Calculate the grand total
$grandTotal = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart</title>
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
    padding: 50px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

.container div {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding:10px;
    overflow: hidden;
    margin:70px;
    margin-bottom: 30px;
    background-color: #fff;
    display: flex;
    flex-direction: column;
}

.container img {
    width: 50%;
    height: 300px;
}

.container h3 {
    padding: 15px;
    flex-grow: 1;
}

.container p {
    padding: 0 15px 15px 15px;
}

.container form {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.container form button {
    cursor: pointer;
    background-color: #dc3545;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 10px;
    transition-duration: 0.4s;
}

.container form button:hover {
    background-color: #c82333;
}

.container p a {
    text-decoration: none;
    color: #007BFF;
}

.container p a:hover {
    text-decoration: underline;
}
</style> <!-- Include your CSS file if needed -->
</head>
<body>

<?php
// Include your navigation/header file here

?>

<section id="main" class="wrapper style1 align-center">
    <div class="container">
        <h2>My Cart</h2>

        <?php
        // Display cart products
        foreach ($cartProducts as $product) {
            echo '<div>';
            
            echo '<img class="image fit" src="uploads/' . $product['imagepath'] . '" alt="' . $product['product_name'] . '" />';
            echo '<h3>' . $product['product_name'] . '</h3>';
            echo '<p><strong>Farmer:</strong> ' . $product['farmer_name'] . '</p>';
        
            echo '<p><strong>Price:</strong> $' . number_format($product['price'], 2) . '</p>';
            echo '<p><strong>Quantity:</strong> ' . $product['quantity'] . '</p>';
            echo '<p><strong>Total Price:</strong> INR' . number_format($product['total_price'], 2) . '</p>';
            
            // Remove button
            echo '<form action="my_cart.php" method="post">';
            echo '<input type="hidden" name="remove_cart_id" value="' . $product['cart_id'] . '">';
            echo '<button type="submit">Remove</button>';
            echo '</form>';
            
            echo '</div>';

            // Update the grand total within the loop
            $grandTotal += $product['total_price'];
        }

        // Display the grand total and the form for checkout
        if (!empty($cartProducts)) {
            echo '<p><strong>Grand Total:</strong> $' . number_format($grandTotal, 2) . '</p>';
            echo '<form action="checkout.php" method="post">';
            echo '<input type="hidden" name="grand_total" value="' . $grandTotal . '">';
            echo '<button type="submit">Proceed to Checkout</button>';
            echo '</form>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>

        <p><a href="disp.php">Continue Shopping</a></p>
    </div>
</section>

<?php
// Include your footer file here
include 'footer.php';
?>

</body>
</html>
