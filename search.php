<?php

include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = $_POST['searchTerm'];

    $sql = "SELECT * FROM properties WHERE location LIKE '%$searchTerm%' OR floor_plan LIKE '%$searchTerm'";

    $result = $conn->query($sql);

    if ($result) {
        $properties = [];

        while ($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($properties);
    } else {
        echo json_encode(['error' => 'Error executing query']);
    }

    $conn->close();
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
    <link rel="stylesheet" href="homesite.css">
</head>
</html>
