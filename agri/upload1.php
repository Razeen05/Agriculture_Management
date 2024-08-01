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
        $result = pg_query_params($conn, "INSERT INTO product (name, imagepath, price,fid) VALUES ($1, $2, $3)",
            array($productName, $_FILES['productImage']['name'], $productPrice,$user_id));

        if ($result) {
            $_SESSION['message'] = "Product uploaded successfully!";
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
    <link rel="stylesheet" href="css/style.css">
    <title>Upload Products</title>
</head>
<body>
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
</html>
