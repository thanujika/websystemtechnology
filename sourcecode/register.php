<?php
include 'dbconnection.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user input
    $firstName = $conn->real_escape_string(trim($_POST['first_name']));
    $lastName = $conn->real_escape_string(trim($_POST['last_name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);
    
    $streetAddress = $conn->real_escape_string(trim($_POST['street_address']));
    $city = $conn->real_escape_string(trim($_POST['city']));
    $state = $conn->real_escape_string(trim($_POST['state']));
    $zip = $conn->real_escape_string(trim($_POST['zip']));
    $country = $conn->real_escape_string(trim($_POST['country']));

    // Check for existing email or username
    $checkQuery = $conn->prepare("SELECT * FROM users WHERE email=? OR username=?");
    $checkQuery->bind_param("ss", $email, $username);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    
    if ($result->num_rows > 0) {
        die("Error: Email or Username already exists!");
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert user data
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, username, password, street_address, city, state, zip, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $firstName, $lastName, $email, $phone, $username, $hashedPassword, $streetAddress, $city, $state, $zip, $country);

    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect to login page after successful registration
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
