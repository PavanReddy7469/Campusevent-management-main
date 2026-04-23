<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.html");
    exit;
}

$usernameInput = $_POST["username"] ?? "";
$passwordInput = $_POST["password"] ?? "";

if ($usernameInput === "" || $passwordInput === "") {
    echo "Please provide both username/email and password.";
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

$stmt = $conn->prepare("SELECT password FROM users WHERE email = ? OR firstName = ? LIMIT 1");
$stmt->bind_param("ss", $usernameInput, $usernameInput);
$stmt->execute();
$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;

if ($user && isset($user["password"]) && password_verify($passwordInput, $user["password"])) {
    $stmt->close();
    $conn->close();
    header("Location: select_campus.html");
    exit;
}

$stmt->close();
$conn->close();
echo "Invalid credentials. <a href='login.html'>Try again</a>.";
?>