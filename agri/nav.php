<!doctype html>
<html>
    <head>
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
        .profile-icon {
            line-height: 60px;
            float: right;
            display: block;
            color: white;
            text-align: center;
            position:relative;
            left:350px;
            width:30px;
            padding: 14px 16px;
            text-decoration: none;
          
        }

        .profile-icon:hover {
            background-color: #ddd;
            color: black;
        }
        .search-icon {
            line-height: 60px;
            float: right;
            display: block;
            color: #f2f2f2;
            text-align: center;
            position:relative;
            left:330px;
            width:30px;
            padding: 14px 16px;
            text-decoration: none;
          
        }

        .search-icon:hover {
            background-color: #ddd;
            color: black;
        }
        .logout {
            line-height: 60px;
            float: right;
            display: block;
            color:white;
            
            text-align: center;
            position:relative;
            left:300px;
            width:50px;
            padding: 14px 16px;
            text-decoration: none;
          
        }

        .logout:hover {
            background-color: orange;
            color: white;
        }


</style>
    </head>
    <body>
    <nav>
    <ul>
        <a href="home1.php" class="nav-link">Home</a>
        <a href="disp.php" class="nav-link">Shop</a>
        <a href="my_cart.php" class="nav-link">Cart</a>
        <a href="order.php" class="nav-link">Orders</a>
        <a href="search.php" class="nav-link">Search Products</a>
        <a href="contact1.php" class="nav-link">Contact</a>
        <a href="logout.php" class="logout">Logout</a>
        <a href="search.php" class="search-icon"><i class="fa-solid fa-search"></i></a>
        <a href="update_profile.php" class="profile-icon"><i class="fa-solid fa-user"></i></a>
    </ul>
</nav>
</body>
    
</body>
</html>
