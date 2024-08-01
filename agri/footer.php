<!DOCTYPE  html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<style>
   
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
            text-align:left;
            margin-bottom: 10px;
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
    .icon{
        color:white;
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
</style>
</head>
<body>
<footer class="footer">
    <section class="box-container">
        <div class="box">
            <h3>quick links</h3>
            <a href="home1.php"> <i class="fas fa-angle-right"></i> home</a>
            <a href="disp.php"> <i class="fas fa-angle-right"></i> shop</a>
            <a href="about.php"> <i class="fas fa-angle-right"></i> about</a>
            <a href="contact1.php"> <i class="fas fa-angle-right"></i> contact</a>
        </div>

        <div class="box">
            <h3>extra links</h3>
            <a href="my_cart.php"> <i class="fas fa-angle-right"></i> cart</a>
            <a href="order.php"> <i class="fas fa-angle-right"></i> orders</a>
            <a href="search.php"> <i class="fas fa-angle-right"></i> search</a>
            <a href="logout.php"> <i class="fas fa-angle-right"></i>logout</a>
        </div>

        <div class="box">
            <h3>contact info</h3>
            <p> <i class="fas fa-phone"></i> +123-456-7890 </p>
            <p> <i class="fas fa-envelope"></i> agri@gmail.com </p>
            <p> <i class="fas fa-map-marker-alt"></i>Chennai,05 </p>
        </div>

        <div class="box">
            <h3>follow us</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
            <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
            <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
            <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
        </div>
    </section>
    <p class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>Your Company</span> | all rights reserved! </p>
</footer>
</body>
</html>