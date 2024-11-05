<?php
session_start();

// Destroy the user's session
session_unset();
session_destroy();

// Redirect to the login page or home page
header("Location: login.php");
exit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="style6.css">
</head>
<body>
    <div class="container">
        <h1>You have successfully logged out</h1>
        <p>Thank you for visiting. Click below to go to the login page:</p>
        <a href="login.php" class="button">Login</a>
    </div>
</body>
</html>
