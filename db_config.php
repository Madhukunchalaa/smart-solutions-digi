<?php
$servername = "localhost";
$username = "u756859339_smartsolutions";
$password = "Smart!@#$4321";
$dbname = "u756859339_smartsolutions";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "smart solutions databse connected successfully";
}
?>