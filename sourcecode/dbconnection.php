<?php
$servername = "localhost"; // Change if your server is different
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "bloomy_flowers"; // The name of your database

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn) {
    echo "Connected successfully";
} else {
    die("Connection failed: " . mysqli_connect_error());
}
?>

