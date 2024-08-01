<?php
// Establish a connection to the PostgreSQL database
$host = 'localhost'; // Update with your database host
$port = '5432'; // Update with your database port
$dbname = 'ag'; // Update with your database name
$user = 'postgres'; // Update with your database username
$password = 'raz@2004'; // Update with your database password

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
session_start();

// Process form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $message = $_POST['message'];

    // Determine whether to use bid or fid based on the session variables
    if (isset($_SESSION['bid'])) {
        $id = $_SESSION['bid'];
    } elseif (isset($_SESSION['fid'])) {
        $id = $_SESSION['fid'];
    } else {
        // Redirect to login or homepage if neither buyer nor farmer
        header("Location: index.php");
        exit();
    }

    // Sanitize the data to prevent SQL injection
    $name = pg_escape_string($conn, $name);
    $email = pg_escape_string($conn, $email);
    $number = pg_escape_string($conn, $number);
    $message = pg_escape_string($conn, $message);

    // Insert data into the database
    $sql = "INSERT INTO contact_form (name, email, number, message, id) 
            VALUES ('$name', '$email', '$number', '$message', $id)";
    
    $result = pg_query($conn, $sql);

    if ($result) {
     header("Location:contact1.php");
     exit();
    }
}

// Close the database connection
pg_close($conn);
?>
