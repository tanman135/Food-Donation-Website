<?php
session_start();
include 'db.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$query = "SELECT * FROM donations WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$donations = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $donation_id = $_GET['delete'];
    $delete_query = "DELETE FROM donations WHERE donation_id = $donation_id AND user_id = '$user_id'";
    mysqli_query($conn, $delete_query);
    header("Location: dashboard.php"); // Refresh the page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
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

    <!-- Container for main content -->
    <div class="container">
        <!-- Welcome Message -->
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

        <!-- User Donations List -->
        <h3>Your Donations:</h3>
        <?php if ($donations): ?>
            <ul>
                <?php foreach ($donations as $donation): ?>
                    <li>
                        Donation ID: <?php echo htmlspecialchars($donation['donation_id']); ?>, 
                        Item Name: <?php echo htmlspecialchars($donation['item_name']); ?>, 
                        Quantity: <?php echo htmlspecialchars($donation['quantity']); ?>, 
                        Date: <?php echo htmlspecialchars($donation['donation_date']); ?>
                        <a href="?delete=<?php echo $donation['donation_id']; ?>" onclick="return confirm('Are you sure you want to delete this donation?');">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>You have not made any donations yet.</p>
        <?php endif; ?>

        <!-- Button to Make a New Donation -->
        <h3>Make a New Donation:</h3>
        <a href="make_donation.php" class="donate-button">Go to Make Donation Page</a>
    </div>
</body>
</html>
