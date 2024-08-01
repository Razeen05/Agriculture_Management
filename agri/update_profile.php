<?php
session_start();
if ($_SESSION['role']=='farmer') {
    include 'farmer_nav.php';
} else{
    include 'nav.php';
}
// Check if the user is logged in
if (!isset($_SESSION['bid']) && isset($_SESSION['fid'])) {
    $user_id = $_SESSION['fid'];
} elseif (!isset($_SESSION['fid']) && isset($_SESSION['bid'])) {
    $user_id = $_SESSION['bid'];
} else {
    // Redirect to login or homepage if neither buyer nor farmer
    header("Location: index.php");
    exit();
}

require 'db.php';
$user_role = $_SESSION['role'];

// Fetch user data based on the role (farmer or buyer)
if ($user_role === 'farmer') {
    $sql = "SELECT * FROM farmer WHERE id = $1";
} elseif ($user_role === 'buyer') {
    $sql = "SELECT * FROM buyer WHERE id = $1";
} else {
    // Invalid user role
    header("Location: index.php");
    exit();
}

$result = pg_query_params($conn, $sql, array($user_id));

if (!$result) {
    die("Error fetching user data: " . pg_last_error($conn));
}

$user_data = pg_fetch_assoc($result);

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $place = $_POST['place'];
    $mobile = $_POST['mobile'];
    $new_password = $_POST['new_password'];

    // Additional validation and sanitation can be added as needed

    // Update user data in the database
    if ($user_role === 'farmer') {
        $update_sql = "UPDATE farmer SET name = $1, email = $2, place = $3, mobile_number = $4, password = $5 WHERE id = $6";
    } elseif ($user_role === 'buyer') {
        $update_sql = "UPDATE buyer SET name = $1, email = $2, place = $3, mobile_number = $4, password = $5 WHERE id = $6";
    }

    $update_result = pg_query_params($conn, $update_sql, array($name, $email, $place, $mobile, $new_password, $user_id));

    if ($update_result) {
      
        header("Location: update_profile.php");
        exit();
    
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <style>
         body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 300px;
            padding: 16px;
            background-color: white;
            margin: 0 auto;
            margin-top: 100px;
            border: 1px solid black;
            border-radius: 4px;
        }

        .container h2 {
            text-align: center;
            color: teal;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container label {
            margin: 10px 0;
        }

        .container input[type="text"],
        .container input[type="email"],
        .container input[type="password"] {
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid grey;
            border-radius: 4px;
        }

        .container input[type="submit"] {
            cursor: pointer;
            background-color: teal;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
        }

        .container input[type="submit"]:hover {
            background-color: #008CBA;
            color: white;
        }</style>
    <!-- Add your CSS styles here -->
</head>
<body>

<?php
// Include your navigation/header file here
// include 'header.php';
?>

<section id="main" class="wrapper style1 align-center">
    <div class="container">
        <h2>Update Profile</h2>
        
        <form action="update_profile.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user_data['name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" required>

            <label for="place">Place:</label>
            <input type="text" id="place" name="place" value="<?php echo $user_data['place']; ?>" required>

            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" value="<?php echo $user_data['mobile_number']; ?>" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <!-- Add additional fields as needed -->

            <input type="submit" value="Update Profile">
        </form>
    </div>
</section>

<?php
if ($_SESSION['role']=='farmer') {
    include 'farmer_footer.php';
} else{
    include 'footer.php';
}
?>

</body>
</html>
