<?php
session_start();
require 'db.php';
if (!isset($_SESSION['fid'])) {
    // Redirect to login or homepage if not a farmer
    
    header("Location: index.php");
    exit();
}
else{
    $user_id=$_SESSION['fid'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = dataFilter($_POST['productName']);
    $productPrice = dataFilter($_POST['productPrice']);

    $uploadDir = 'uploads/'; // Directory where images will be uploaded
    $uploadFile = $uploadDir . basename($_FILES['productImage']['name']);

    if (move_uploaded_file($_FILES['productImage']['tmp_name'], $uploadFile)) {
        // Image uploaded successfully, insert into database
        $result = pg_query_params($conn, "INSERT INTO product (name, imagepath, price,fid) VALUES ($1, $2, $3,$4)",
            array($productName, $_FILES['productImage']['name'], $productPrice,$user_id));

        if ($result) {
            $_SESSION['message'] = "";
        } else {
            $_SESSION['message'] = "Failed to upload product!";
        }
    } else {
        $_SESSION['message'] = "Failed to upload image!";
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
    <?php include 'farmer_nav.php'; ?>
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
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
        }

        button:hover {
            opacity: 0.8;
        }

        .message {
            margin-top: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
        }

        p {
            margin-top: 20px;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            
        }
    </style>
    <title>Upload Products</title>
</head>
<body>
<br><br><br>
    <div class="container">
        <h2>Upload Products</h2>

       

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="productName">Product Name:</label>
            <input type="text" name="productName" required>
            <label for="productPrice">Product Price:</label>
            <input type="number" name="productPrice" required>
            <label for="productImage">Product Image:</label>
            <input type="file" name="productImage" accept="image/*" required>
            <button type="submit">Upload Product</button>
        </form>
        <p><a href="display.php">View Products</a></p>
    </div>
  
</body>
<br><br><br>
<?php include 'farmer_footer.php'; ?>
</html>
