<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: signup.html");
    exit;
}

$firstName = $_POST["firstName"] ?? "";
$lastName = $_POST["lastName"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

if ($firstName === "" || $lastName === "" || $email === "" || $password === "") {
    echo "All fields are required.";
    exit;
}

$servername = "127.0.0.1";
$dbUsername = "root";
$dbPassword = "";
$dbname = "signuppage";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$existingUser = $checkStmt->get_result();

if ($existingUser && $existingUser->num_rows > 0) {
    $checkStmt->close();
    $conn->close();
    echo "Email already registered. <a href='login.html'>Login here</a>.";
    exit;
}

$checkStmt->close();
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$insertStmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
$insertStmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

if ($insertStmt->execute()) {
    $insertStmt->close();
    $conn->close();
    header("Location: select_campus.html");
    exit;
}

echo "Error: " . $conn->error;
$insertStmt->close();
$conn->close();
?>