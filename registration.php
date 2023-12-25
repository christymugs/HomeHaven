<?php
include('db.php');

$registrationMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        $registrationMessage = "Registration successful! <a href='login.php'>Login here</a>.";

    } else {
        $registrationMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <header>
    <div>
        <img src="homehavenlogo.png" alt="HomeHaven Logo">
        <nav>
            <ul>
                <li><a href="index-hs.html">Home</a></li>
                <li><a href="buyer_dashboard.php">Buy</a></li>
                <li><a href="#">Sell</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </div>
</header>
    <title>Registration Complete!</title>
    <link rel="stylesheet" href="homesite.css">
</head>

<body>

    <div class="signup-container">
        <!-- Display pop-up message with a link to the login page -->
        <?php if (!empty($registrationMessage)) : ?>
            <p><?php echo $registrationMessage; ?></p>
        <?php endif; ?>
    </div>

</body>

</html>
