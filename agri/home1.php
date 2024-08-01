<!DOCTYPE html>
<html lang="en">
<head>
<?php 
session_start();
if ($_SESSION['role']=='farmer') {
    include 'farmer_nav.php';
} else{
    include 'nav.php';
}
?>
    <meta charset="UTF-8">
    <title>Your Home Page Title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body, h1, h2, p, form, input {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            /* Add padding-top to accommodate fixed navigation bar */
            padding-top: 60px; /* Adjust this value based on the height of your navigation bar */
        }

        nav {
            position: fixed;
            width: 100%;
            top: 0;
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
            background: url(uploads/onions.jpg) no-repeat;
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

        .box-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .box {
            min-height: 325px;
            flex: 1;
            max-width: 200px;
            margin: 10px;
            padding: 15px;
            
            border-radius: 8px;
            display: flex;
            flex-direction: column;
        }

        .box h3 {
            font-size: 1.5rem;
            color: white;
            margin-bottom: 10px;
            text-align:left;
        }

        .box p {
            margin-bottom: 10px;
            color: white;
            text-align:left;
        }

        .credit {
            margin-top: 20px;
            padding: 20px 0;
            border-top: 1px solid #fff;
        }

        .products-heading {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .products-heading h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 10px;
        }
        .box a {
        text-align:left;
        color: #fff;
        text-decoration: none;
        display: block;
        margin-bottom: 5px;
    }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }
        /* Reset some default styles */

/* Define CSS variables for reusability */

    </style>
</head>
<body>


<div class="home-bg">
    <section class="home">
        <div class="content">
            <span style="background: linear-gradient(132deg, rgb(250, 170, 0) 0.00%, rgb(237, 19, 19) 15.85%, rgb(213, 74, 255) 100.00%);
            -webkit-text-fill-color: transparent; 
            -webkit-background-clip: text; 
            ">Shop us for better health1.</span>
            <h3 style="
  
            font-size: 40px; 
            font-family: Arial, Helvetica, sans-serif; 
            background: linear-gradient(69deg, rgb(251, 251, 255) 0.00%, rgb(220, 227, 252) 27.81%, rgb(215, 223, 252) 100.00%);
            -webkit-text-fill-color: transparent; 
            -webkit-background-clip: text; ">Reach For A Healthier You With Organic Foods</h3>
            <p></p>
            <a href="#1" class="btn">about us</a>
        </div>
    </section>
</div>

<!-- Display "Our Products" Heading and "See All" Button -->
<div class="products-heading">
    <h2>Our Products</h2>
    <div><a href="display.php" class="btn">See All</a></div>
</div>

<!-- Display Top Three Products -->
<section class="box-container">
    <?php
    require 'db.php';
    $topProductsSql = "SELECT p.id, p.name AS product_name, p.price, p.imagepath, f.name AS farmer_name
                        FROM product p
                        JOIN farmer f ON p.fid = f.id
                        ORDER BY p.price DESC
                        LIMIT 3";

    $topProductsResult = pg_query($conn, $topProductsSql);

    while ($row = pg_fetch_assoc($topProductsResult)) {
        echo '<div class="box">';
        echo '<img src="uploads/' . $row['imagepath'] . '" alt="' . $row['product_name'] . '">';
        echo '<h2>' . $row['product_name'] . '</h2>';
        echo '<p></p>';
        echo '<p></p>';
        echo '</div>';
    }
    ?>
</section>
<hr style="position:relative;bottom:90px;z-index:-1;">
<center><h1 id='1' class="about" style="position:relative;bottom:80px;z-index:-1;">ABOUT US</h1></center>
<section >
        <div >
            <div >
                <center><img src="about-img-1.png" alt="" width="300px" height="400px"style="position:relative;bottom:50px;z-index:-1;"></center>
                <center ><h2 style="position:relative;bottom:30px;z-index:-1;">WHAT WE PROVIDE?</h3></center>
                <center><h3>We provide Healthy fruits, vegetables, Chicken, Meat, and Fish products. Our products are officially verified by Food Safety and Standard Authorities of India (FSSAI).</h3></center>
                <center><a href="contact1.php" class="btn">Contact</a></center>
            </div>
            <br><br>

            
    </section>
<?php if ($_SESSION['role']=='farmer') {
    include 'farmer_footer.php';
} else{
    include 'footer.php';
}
?>
</body>
</html>
