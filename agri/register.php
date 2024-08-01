<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = dataFilter($_POST['name']);
    $email = dataFilter($_POST['email']);
    $password = dataFilter($_POST['password']);
    $phone = dataFilter($_POST['phone']);
    $place = dataFilter($_POST['place']);
    $role = dataFilter($_POST['role']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email format!";
        header("location: register.php");
        exit();
    }

    // Validate phone number
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $_SESSION['message'] = "Invalid phone number format! (10 digits only)";
        header("location: register.php");
        exit();
    }

    // Choose the appropriate table based on the selected role
    $table = ($role == 'farmer') ? 'farmer' : 'buyer';

    $result = pg_query_params($conn, "INSERT INTO $table (name, email, password, mobile_number, place) VALUES ($1, $2, $3, $4, $5)",
        array($name, $email, $password, $phone, $place));

    if ($result) {
        $_SESSION['message'] = "Registration successful!";
        header("location: login.php");
    } else {
        $_SESSION['message'] = "Registration failed!";
    }
}

function dataFilter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <center><h2 style="color:black;">REGISTER</h2></center>
        <form action="register.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" pattern="[0-9]{10}" title="Please enter a 10-digit phone number" required>
            <label for="place">Place:</label>
            <input type="text" name="place" required>
            
            <!-- Add a role selection -->
            <label for="role">Select Role:</label>
            <select name="role" required>
                <option value="farmer">Farmer</option>
                <option value="buyer">Buyer</option>
            </select>
            <br><br>
            <button style="background-color:#4CAF50;" type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
