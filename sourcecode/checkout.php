<?php
// Include the database connection file
include 'dbconnection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_info = mysqli_real_escape_string($conn, $_POST['payment']);

    // Insert the data into the orders table
    $sql = "INSERT INTO orders (name, address, payment_info) VALUES ('$name', '$address', '$payment_info')";

    if (mysqli_query($conn, $sql)) {
        echo "Order placed successfully!";
        // Optionally, you can redirect to a success page
        // header("Location: success.html");
        // exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>

