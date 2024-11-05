<?php
session_start();
require 'vendor/autoload.php'; // Include PHPMailer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donate_food";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['donate'])) {
    $user_id = $_SESSION['user_id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO donations (user_id, item_name, quantity, donation_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("isi", $user_id, $item_name, $quantity);

    if ($stmt->execute()) {
        $email = $_SESSION['email'];
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 't.mangaonkar@somaiya.edu';
            $mail->Password   = 'mitn ayxf eada cqea';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('t.mangaonkar@somaiya.edu', 'Food Donation');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Donation Confirmation';
            $mail->Body    = "Thank you for your donation of <strong>$item_name</strong> (Quantity: $quantity). Your generosity is greatly appreciated.";

            $mail->send();
            $message = "Donation successful! A confirmation email has been sent.";
        } catch (Exception $e) {
            $message = "Donation was successful, but email could not be sent. Error: {$mail->ErrorInfo}";
        }

        header("Location: dashboard.php"); // Redirect after donation
        exit();
    } else {
        $message = "There was an error processing your donation. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>
<!-- HTML for donation form remains the same -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Donation</title>
    <link rel="stylesheet" href="make_donation.css">
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <h1>Make a Donation</h1>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form action="make_donation.php" method="POST">
            <label for="item_name">Donation Item:</label>
            <input type="text" id="item_name" name="item_name" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <button type="submit" name="donate">Donate</button>
        </form>
    </div>
</body>
</html>
