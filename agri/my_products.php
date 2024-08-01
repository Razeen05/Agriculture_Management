<?php
session_start();
require 'db.php';
include 'farmer_nav.php';
// Check if the farmer ID is set in the session
if (isset($_SESSION['fid'])) {
    $farmerId = $_SESSION['fid'];

    // Fetch products created by the logged-in farmer
    $result = pg_query_params($conn, "SELECT * FROM product WHERE fid = $1", array($farmerId));
echo'<br><br><br><br>';
    // Display the products
    if ($result) {
        echo '<div class="container">';

        echo '<h2>My Products</h2>';

        echo '<div class="content-container">';
        
        // Back to Home Button
        echo '<p >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="home1.php" class="back-to-home-btn">Back to Home</a></p>';

        echo '<div class="product-cards">';

        while ($row = pg_fetch_assoc($result)) {
            echo '<div class="card">';
            echo '<img src="uploads/' . $row['imagepath'] . '" alt="' . $row['name'] . '" />';
            echo '<div class="card-body">';
            echo '<h2>' . $row['name'] . '</h2>';
            echo '<p>Price: $' . number_format($row['price'], 2) . '</p>';
            // Add other details you want to display
            echo '</div>';
            echo '</div>';
        }

        echo '</div>'; // Close the product-cards div
        echo '</div>'; // Close the content-container div
        echo '</div>'; // Close the container div
    } else {
        echo "Error fetching products.";
    }
} else {
    echo "Invalid farmer ID!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        nav {
            overflow: hidden;
            background-color: #333;
        }

        nav a {
            line-height: 60px;
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }

        nav a.active {
            background-color: #4CAF50;
            color: white;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .home-bg {
            background: url(homeg.jpg) no-repeat;
            background-size: cover;
        }

        .home-bg .home {
            display: flex;
            align-items: center;
            min-height: 60vh;
        }

        .home-bg .home .content {
            width: 50rem;
        }

        .home-bg .home .content span {
            color: white;
            font-size: 2.5rem;
        }

        .home-bg .home .content h3 {
            font-size: 3rem;
            text-transform: uppercase;
            margin-top: 1.5rem;
            color: black;
        }

        .home-bg .home .content p {
            font-size: 1.6rem;
            padding: 1rem 0;
            line-height: 2;
            color: gray;
        }

        .home-bg .home .content a {
            display: inline-block;
            width: auto;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Center the items horizontally */
            align-items: center; /* Center the items vertically */
            margin-top: 20px;
        }

        .content-container {
            width: 100%;
        }

        .back-to-home-btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-bottom: 20px;
        }

        .back-to-home-btn:hover {
            background-color: #45a049;
        }

        .product-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            margin: 10px;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            width: 350px;
        }

        .card img {
            width: 100%;
            height: auto;
        }

        .card-body {
            padding: 15px;
            flex-grow: 1;
        }

        .card h2 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .card p {
            margin-bottom: 10px;
            color: #666;
        }
    </style>
    <br><br><br>
    <title>My Products</title>
</head>
<body>
</body>
<?php include 'farmer_footer.php' ?>
</html>
