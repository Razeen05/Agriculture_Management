<?php
session_start();
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div class="container">
        <center><h1 style="color:black;">LOGIN</h1></center>
        
        <!-- Display error message -->
        <div class="error-message">
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']); // Clear the message after displaying it
            }
            ?>
        </div>
        
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button style="background-color:#4CAF50;" type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = dataFilter($_POST['email']);
        $password = dataFilter($_POST['password']);

        // Check if both email and password are provided
        if (!empty($email) && !empty($password)) {
            // Check if the user exists in the farmer table
            $farmerResult = pg_query_params($conn, "SELECT * FROM farmer WHERE email=$1", array($email));

            if ($farmerResult) {
                $row = pg_fetch_assoc($farmerResult);
                // Compare plain text password directly
                if ($row && $password === $row['password']) {
                    $_SESSION['fid'] = $row['id'];
                    $_SESSION['fname'] = $row['fname'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = 'farmer';
                    echo '<script>
                            swal("Success", "Login Successful!", "success")
                                .then((value) => {
                                    window.location.href = "home1.php";
                                });
                          </script>';
                    exit();
                }
            }

            // If not in farmer table, check the buyer table
            $buyerResult = pg_query_params($conn, "SELECT * FROM buyer WHERE email=$1", array($email));

            if ($buyerResult) {
                $row = pg_fetch_assoc($buyerResult);
                // Compare plain text password directly
                if ($row && $password === $row['password']) {
                    $_SESSION['bid'] = $row['id'];
                    $tempBname = isset($row['bname']) ? $row['bname'] : null;
        
        // Assign the temporary variable to the session
        $_SESSION['bname'] = $tempBname;
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = 'buyer';
                    echo '<script>
                            swal("Success", "Login successful!", "success")
                                .then((value) => {
                                    window.location.href = "home1.php";
                                });
                          </script>';
                    exit();
                }
            }

            echo '<script>
                    swal("Error", "Invalid email or password!", "error")
                        .then((value) => {
                            window.location.href = "login.php";
                        });
                  </script>';
        } else {
            echo '<script>
                    swal("Error", "Both email and password are required!", "error")
                        .then((value) => {
                            window.location.href = "login.php";
                        });
                  </script>';
        }
    }

    function dataFilter($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
</body>
</html>
