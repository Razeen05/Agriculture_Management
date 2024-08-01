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

$buyer_id = $_SESSION['bid'];

// Fetch orders from the checkout table
$sql = "SELECT c.id, c.name, c.number, c.email, c.payment_method, c.door_no, c.street, c.city,
               p.name AS product_name, c.product_ids, c.quantities, c.total_price, c.created_at
        FROM checkout c
        JOIN product p ON p.id = ANY(c.product_ids)
        WHERE c.buyer_id = $1
        ORDER BY c.created_at DESC"; // Order by created_at in descending order

$result = pg_query_params($conn, $sql, array($buyer_id));

// Fetch the order records
$orders = array();
$currentOrderId = null;

echo '<style>';
echo 'body { font-family: Arial, sans-serif; }';
echo '.orders { display: flex; flex-direction: column; gap: 20px; padding: 20px; margin-left:100px;margin-right:100px; box-sizing: border-box; }';
echo '.order { display: flex; flex-direction: column; gap: 10px; border: 1px solid #ccc; padding: 20px; box-sizing: border-box; }';
echo 'strong{background: linear-gradient(132deg, rgb(255, 0, 0) 33.64%, rgb(255, 213, 0) 100.00%);-webkit-text-fill-color: transparent; 
    -webkit-background-clip: text;}';
echo '.order p { margin: 0; }';
echo '</style>';


echo'<br>';

echo '<div class="orders">';
echo'<h1 style="text-align:center;">ORDERS</h1>';



while ($row = pg_fetch_assoc($result)) {
    $orderId = $row['id'];

    // Check if it's a new order
    if ($orderId !== $currentOrderId) {
        // Display order details
        if ($currentOrderId !== null) {
            echo '<p><strong>Total Price:</strong> $' . number_format($totalPrice, 2) . '</p>';
            echo '</div>'; // Close the previous order details
        }

        echo '<div class="order">';
       
        echo '<p><strong>Name:</strong> ' . $row['name'] . '</p>';
        echo '<p><strong>Number:</strong> ' . $row['number'] . '</p>';
        echo '<p><strong>Email:</strong> ' . $row['email'] . '</p>';
        echo '<p><strong>Payment Method:</strong> ' . $row['payment_method'] . '</p>';
        echo '<p><strong>Address:</strong> ' . $row['door_no'] . ', ' . $row['street'] . ', ' . $row['city'] . '</p>';
        echo '<p><strong>Order Date:</strong> ' . $row['created_at'] . '</p>';

        $totalPrice = 0;
        $currentOrderId = $orderId;
    }

    // Display product details
    $quantities = explode(',', trim($row['quantities'], '{}'));
    $productNames = explode(',', trim($row['product_name'], '{}'));
    
    // Loop through quantities and product names simultaneously
    foreach ($quantities as $key => $quantity) {
        // Check if the index exists in productNames array
        if (isset($productNames[$key])) {
            $productName = $productNames[$key];
            echo '<p><strong>Product Name:</strong> ' . $productName . '</p>';
            echo '<p><strong>Quantity:</strong> ' . $quantity . '</p>';
        }
    }
    
    // Accumulate total price for the order
    $totalPrice = $row['total_price'];
}

// Close the last order details
if ($currentOrderId !== null) {
    echo '<p><strong>Total Price:</strong> $' . number_format($totalPrice, 2) . '</p>';
    echo '</div>';
}

echo '</div>';
echo'<br><br><br>';
include 'footer.php'; // Close the orders container
?>
