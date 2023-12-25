<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, return an error message
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Get the property ID from the form submission
$propertyId = $_POST['propertyId']; // Use 'propertyId' instead of 'property_id'

// Check if the property is already in the wishlist
$checkQuery = "SELECT * FROM wishlist WHERE user_id = $userId AND property_id = $propertyId";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows === 0) {
    // If not wish-listed, add to wishlist
    $insertQuery = "INSERT INTO wishlist (user_id, property_id) VALUES ($userId, $propertyId)";
    $conn->query($insertQuery);

    // Return a success message
    echo json_encode(['message' => 'Property added to wishlist']);
} else {
    // If already wish-listed, return a message indicating that
    echo json_encode(['message' => 'Property is already in the wishlist']);
}

$conn->close();
?>
