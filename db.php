<?php
$servername = "localhost";
$username = "cmugomba1";
$password = "cmugomba1";
$dbname = "cmugomba1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>