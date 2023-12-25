<?php
session_start();

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            switch ($user['role']) {
                case 'seller':
                    header('Location: seller_dashboard.php');
                    break;
                case 'buyer':
                    header('Location: buyer_dashboard.php');
                    break;
                case 'admin':
                    header('Location: admin_dashboard.php');
                    break;
                default:
                    break;
            }
        } else {
            $loginMessage = "Invalid email or password";
        }
    } else {
        $loginMessage = "Invalid email or password";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
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
    <link rel="stylesheet" href="homesite.css">
</head>

<body>

    <div class="login-container">
        <h2>User Login</h2>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

            <a href="#">Forgot Password?</a>
            <a href="index-hs.html">Need to Register?</a>

        <?php if (!empty($loginMessage)) : ?>
            <p class="login-message"><?php echo $loginMessage; ?></p>
        <?php endif; ?>
    </div>

</body>

</html>
