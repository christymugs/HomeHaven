<?php
session_start();
include('db.php');

// Check if it's the user's first login
if ($_SESSION['first_login']) {
    $user_id = $_SESSION['user_id'];
    
    // Getting the user's name
    $fetchNameQuery = "SELECT name FROM users WHERE id = $user_id";
    $result = $conn->query($fetchNameQuery);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_name = $user['name'];
        echo "Welcome, $user_name! Thank you for choosing HomeHaven.\nNow let's find your new home!";
        
        // Update the 'first_login' field to false in the database
        $updateFirstLogin = "UPDATE users SET first_login = false WHERE id = $user_id";
        $conn->query($updateFirstLogin);
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
    <link rel="stylesheet" href="homesite.css">
    <title>Buyer Dashboard</title>
    <style>
        .property-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .property-card img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .property-details {
            margin-bottom: 10px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .button-container button {
            padding: 8px 16px;
            cursor: pointer;
        }

    </style>
</head>
<body>
    <input type="text" id="searchInput" placeholder="Enter Your Dream Location or Press Search to View All">
    <button onclick="searchProperties()">Search</button>

    <?php
    if ($_SESSION['user_role'] === 'buyer') {
        echo '<div class="button-container">';
        echo '<button onclick="viewWishlist()">View Wishlist</button>';
        echo '</div>';
    }
    ?>
        <div id="propertyList"></div>
    <script>
        function searchProperties() {
            var searchTerm = document.getElementById('searchInput').value;

            fetch('search.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'searchTerm=' + encodeURIComponent(searchTerm),
            })
            .then(response => response.json())
            .then(properties => displayProperties(properties))
            .catch(error => console.error('Error fetching search results:', error));
        }

        function displayProperties(properties) {
            var propertyListElement = document.getElementById('propertyList');
            propertyListElement.innerHTML = '';

            properties.forEach(property => {
                var propertyCard = document.createElement('div');
                propertyCard.className = 'property-card';

                var propertyImage = document.createElement('img');
                propertyImage.src = property.image_path;
                propertyImage.alt = property.location;

                var propertyDetails = document.createElement('p');
                propertyDetails.textContent = `Location: ${property.location}, Bedrooms: ${property.bedrooms}, Bathrooms: ${property.bathrooms}, Price: $${property.property_value}`;

                var addToWishlistButton = document.createElement('button');
                addToWishlistButton.textContent = 'Add to Wishlist';
                addToWishlistButton.onclick = function() {
                    addToWishlist(property.id);
                };

                var viewDetailsButton = document.createElement('button');
                viewDetailsButton.textContent = 'View Details';
                viewDetailsButton.onclick = function() {
                    viewPropertyDetails(property.id);
                };

                propertyCard.appendChild(propertyImage);
                propertyCard.appendChild(propertyDetails);
                propertyCard.appendChild(addToWishlistButton);
                propertyCard.appendChild(viewDetailsButton);

                propertyListElement.appendChild(propertyCard);
            });
        }

        function addToWishlist(propertyId) {
            fetch('add_to_wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'propertyId=' + encodeURIComponent(propertyId),
            })
            .then(response => response.json())
            .then(result => {
                console.log(result.message);
            })
            .catch(error => console.error('Error adding property to wishlist:', error));
        }

        function viewWishlist() {
            window.location.href = 'wishlist.php';
        }

        function viewPropertyDetails(propertyId) {
            window.location.href = 'property_details.php?property_id=' + propertyId;
        }
    </script>
</body>
</html>

