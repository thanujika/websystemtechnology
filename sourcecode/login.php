<?php
include 'dbconnection.php'; // Include the database connection file

session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    // Prepare SQL query to fetch user data
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Set session variables for logged in user
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: index.html"); // Redirect to the main page after login
            exit();
        } else {
            echo "Error: Invalid username or password.";
        }
    } else {
        echo "Error: User not found.";
    }

    $stmt->close();
}

$conn->close();
?>
