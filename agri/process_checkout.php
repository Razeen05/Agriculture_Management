<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];

    // Assuming you have the buyer's ID stored in a session variable
    if (!isset($_SESSION['bid'])) {
        // Redirect or handle the case where the buyer is not logged in
        header("Location: login.php");
        exit();
    }

    $buyer_id = $_SESSION['bid'];

    // Database connection parameters
    $host = 'localhost';
    $dbname = 'ag';
    $user = 'postgres';
    $password = 'raz@2004';

    // Establish a database connection
    $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

    if (!$conn) {
        die("Database connection failed");
    }

    // Fetch product_ids, quantities, and grandtotal from the cart table
    $cartQuery = "SELECT product_id, quantity, total_price FROM cart WHERE buyer_id = $1";
    $cartResult = pg_query_params($conn, $cartQuery, array($buyer_id));

    $product_ids = [];
    $quantities = [];
    $grandTotal = 0;

    while ($cartRow = pg_fetch_assoc($cartResult)) {
        $product_ids[] = $cartRow['product_id'];
        $quantities[] = $cartRow['quantity'];
        $grandTotal += $cartRow['total_price'];
    }

    // Convert arrays to PostgreSQL array syntax
    $product_ids_str = '{' . implode(',', $product_ids) . '}';
    $quantities_str = '{' . implode(',', $quantities) . '}';

    // Insert checkout information into the database
    $insertQuery = "INSERT INTO checkout (buyer_id, name, number, email, payment_method, door_no, street, city, product_ids, quantities, total_price)
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)";

    $insertParams = array(
        $buyer_id,
        $name,
        $number,
        $email,
        $method,
        $flat,
        $street,
        $city,
        $product_ids_str,
        $quantities_str,
        $grandTotal
    );

    $insertResult = pg_query_params($conn, $insertQuery, $insertParams);

    if ($insertResult) {
        // Delete the cart entries for the specific buyer
        $deleteCartQuery = "DELETE FROM cart WHERE buyer_id = $1";
        $deleteCartResult = pg_query_params($conn, $deleteCartQuery, array($buyer_id));

        if ($deleteCartResult) {
            // Redirect to a thank you page after successful insertion and deletion
            header("Location: checkout.php");
            exit();
        } else {
            // Display an error message or handle the error accordingly
            echo "Error: Unable to delete cart information.";
        }
    } else {
        // Display an error message or handle the error accordingly
        echo "Error: Unable to save checkout information.";
    }

    // Close the database connection
    pg_close($conn);
}
?>
