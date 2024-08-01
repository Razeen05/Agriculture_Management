<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AgroCulture: Display Products</title>
    <style>
        /* Reset some browser styles */
        body, h1, h2, p, form, input {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .row::after {
            content: "";
            display: table;
            clear: both;
        }

        .col-md-4 {
            flex: 0 0 calc(33.33% - 30px);
            margin: 15px;
            box-sizing: border-box;
        }

        h1, h2 {
            color: #333;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Custom Styling */
        .content-block {
            position: relative;
            padding: 40px 0;
        }

        .content-block img {
            width: 100%;
            height: auto;
        }

        .content-block h2 {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            text-align: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 10px 20px;
        }

        /* Card Styles */
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card img {
            width: 100%;
            height: auto;
        }

        .card-body {
            padding: 15px;
            flex-grow: 1;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .add-to-cart-form {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .quantity-container {
            display: flex;
            align-items: center;
            width: 150px;
        }

        input[type="number"] {
            margin-right: 10px;
            width: 550px;
        }

        @media (max-width: 768px) {
            .col-md-4 {
                flex: 0 0 calc(50% - 30px);
            }
        }

        @media (max-width: 480px) {
            .col-md-4 {
                flex: 0 0 100%;
            }
        }
    </style>
    <!-- Include your CSS file if needed -->
</head>
<body>

<?php
require 'db.php';

$query = "SELECT p.id, p.name AS product_name, p.price, p.imagepath, f.name AS farmer_name
          FROM product p
          JOIN farmer f ON p.fid = f.id
          ORDER BY p.price DESC
          LIMIT 3";

$result = pg_query($query);

if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}
?>

<section id="main" class="wrapper style1 align-center">
    <div class="container">
        <h2>Product Catalog</h2>

        <div class="row">
            <?php
            // Display products
            while ($row = pg_fetch_assoc($result)) {
                echo '<div class="col-md-4">';
                echo '<div class="card">';
                echo '<img src="uploads/' . $row['imagepath'] . '" alt="' . $row['product_name'] . '" />';
                echo '<div class="card-body">';
                echo '<h2 class="title">' . $row['product_name'] . '</h2>';
                echo '<p><strong>Farmer:</strong> ' . $row['farmer_name'] . '</p>';
                echo '<p><strong>Price:</strong> $' . number_format($row['price'], 2) . '</p>';
                echo '<div class="add-to-cart-form">';
                echo '<form action="disp.php" method="post">';
                echo '<label for="quantity">Quantity:</label>';
                echo '<div class="quantity-container">';
                echo '<input type="number" id="quantity" name="quantity"  min="1" required>';
                echo '<center><input type="hidden" name="product_id" value="' . $row['id'] . '"></center>';
                echo '</div>';
                echo'<br>';
                echo '<center><input type="submit" value="Add to Cart"></center>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<footer class="footer">
    <section class="box-container">
        <!-- Your footer code here -->
    </section>
    <p class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>Your Company</span> | all rights reserved! </p>
</footer>
</body>
</html>
