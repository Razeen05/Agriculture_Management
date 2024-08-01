<!DOCTYPE html>
<html>
<head>
    <?php session_start();
    if ($_SESSION['role']=='farmer') {
    include 'farmer_nav.php';
} else{
    include 'nav.php';
} ?>
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="text"], input[type="email"], input[type="tel"], textarea {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
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
        }
        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<br><br><br>
    <div class="container">
        <center><h1><strong>FEEDBACK</strong></h1></center>
        <form action="contact.php" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="number">Number</label>
            <input type="tel" id="number" name="number" required>

            <label for="message">Message</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>
    <br><br>
    <?php if ($_SESSION['role']=='farmer') {
    include 'farmer_footer.php';
} else{
    include 'footer.php';
} ?>
</body>
</html>