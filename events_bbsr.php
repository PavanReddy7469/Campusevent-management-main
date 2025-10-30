<?php

// Database connection configuration
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "signuppage";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$eventId = $_POST['eventId'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO feedback (eventId, rating, comment) VALUES ('$eventId', '$rating', '$comment')");
$stmt->bind_param("sis", $eventId, $rating, $comment);

// Execute SQL statement
if ($stmt->execute()) {
    echo "Feedback submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

?>
