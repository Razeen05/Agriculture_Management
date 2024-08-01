<?php
session_start();
require 'db.php';

if ($_SESSION['role']=='farmer') {
    include 'farmer_nav.php';
} else{
    include 'nav.php';
}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = $_POST['search'];
    $searchTerm = pg_escape_string($conn, $searchTerm); // Sanitize the input

    // Fetch products based on the search term
    $sql = "SELECT p.id, p.name AS product_name, p.price, p.imagepath, f.name AS farmer_name
            FROM product p
            JOIN farmer f ON p.fid = f.id
            WHERE LOWER(p.name) LIKE LOWER('%$searchTerm%')";

    $result = pg_query($conn, $sql);
} else {
    $result = null; // Initialize result variable
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AgroCulture: Search Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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

        .view-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        .view-button:hover {
            background-color: #45a049;
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
</head>
<body>
<br><br><br>
<section id="main" class="wrapper style1 align-center">
    <center><div class="container">
        <h2>Search Results</h2>
        <br>

        <form action="search.php" method="post">
            <label for="search">SEARCH:</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" size="40" id="search" name="search" required><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" value="SEARCH">
        </form><br><br>
    </center>
        <?php
        if ($result && pg_num_rows($result) > 0) {
            echo '<div class="row">';
            while ($row = pg_fetch_assoc($result)) {
                echo '<div class="col-md-4">';
                echo '<div class="card">';
                echo '<img src="uploads/' . $row['imagepath'] . '" alt="' . $row['product_name'] . '" />';
                echo '<div class="card-body">';
                echo '<h2 class="title">' . $row['product_name'] . '</h2>';
                echo '<p><strong>Farmer:</strong> ' . $row['farmer_name'] . '</p>';
                echo '<p><strong>Price:</strong> $' . number_format($row['price'], 2) . '</p>';
                echo '<button class="view-button"onclick="redirectToDisplay()" >View in Products</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } elseif ($result) {
            echo '<center><p style="color:red;">No results found</p></center>';
        }
        ?>
    </div>
</section>
<script>
    function redirectToDisplay() {
        // Use document.location or window.location to redirect
        document.location.href = 'display.php';
        // Alternatively, you can use window.location.href = 'display.php';
    }
</script>

</body>
</html>
