<?php
// Get data from the request
$name = $_POST['name']; // Assuming you have a form field with the name 'name'
// Add more fields as needed

// Connect to your MySQL database (assuming you are using MySQL with PHP)
$servername = "MSI";
$username = "root@localhost";
$password = "root123";
$dbname = "users"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query to insert data into a table
$sql = "INSERT INTO your_table_name (name) VALUES ('$name')"; // Replace 'your_table_name' with your actual table name

// Execute SQL query
if ($conn->query($sql) === TRUE) {
  echo "Data inserted successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
