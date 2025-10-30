<?php

// Database connection configuration
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "eventsDB";

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
$stmt = $conn->prepare("INSERT INTO feedback (eventId, rating, comment) VALUES (?, ?, ?)");
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
