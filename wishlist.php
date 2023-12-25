<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user's name
$userId = $_SESSION['user_id'];
$nameQuery = "SELECT name FROM users WHERE id = $userId";
$nameResult = $conn->query($nameQuery);

if ($nameResult->num_rows > 0) {
    $user = $nameResult->fetch_assoc();
    $name = $user['name'];
} else {
    
    $name = 'User';
}

// Fetch wish-listed properties for the current user from the database
$sql = "SELECT properties.* FROM wishlist
        INNER JOIN properties ON wishlist.property_id = properties.id
        WHERE wishlist.user_id = $userId";
$result = $conn->query($sql);

$wishListedProperties = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wishListedProperties[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
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

    <div class="wishlist-container">
        <h2><?php echo $name; ?>'s Wishlist</h2>

        <?php if (empty($wishListedProperties)) : ?>
            <p>Your wishlist is empty.</p>
        <?php else : ?>
            <div class="property-list">
                <?php foreach ($wishListedProperties as $property) : ?>
                    <div class="property-card">
                        <img src="<?php echo $property['image_path']; ?>" alt="<?php echo $property['location']; ?>" />
                        <p>Location: <?php echo $property['location']; ?></p>
                        <p>Bedrooms: <?php echo $property['bedrooms']; ?></p>
                        <p>Bathrooms: <?php echo $property['bathrooms']; ?></p>
                        <p>Property Value: $<?php echo $property['property_value']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>
