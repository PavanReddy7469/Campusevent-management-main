<?php
include 'PHPMailer.php' ;
include 'Exception.php' ;
include 'SMTP.php' ;

include 'db.php';
$servername = "127.0.0.1";
$username = "root"; // Replace with your database username
$password = "";  // Replace with your database password
$dbname = "signuppage";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash the password

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        echo "Error: This email is already registered.";
    } else {
        // Insert user into the database
        $sql = "INSERT INTO users (firstName, lastName, email, password) VALUES ('$firstName', '$lastName', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->CharSet = "utf-8";// set charset to utf8
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                        )
                    );
                    $mail->SMTPDebug = 2;
                    $mail->SMTPSecure = false;
                    $mail->SMTPAutoTLS = false;
                    $mail->isHTML(true);
                    // $mail->SMTPSecure = false;
                    // $mail->SMTPAutoTLS = false;
                    //Recipients
                $mail->Username = 'harshithapoojari123@gmail.com';
                $mail->Password = 'harshi@2005';
                $mail->setFrom('harshithapoojari123@gmail.com', 'Event Management');
                
                //Content
                $mail->Subject = 'Sign Up Confirmation';
                $mail->MsgHTML('You have successfully signed up to the Event Management website. Thank you!');// Message body
                $mail->addAddress($email);


                $mail->send();
                echo 'Sign up successful and email sent.';
            } catch (Exception $e) {
                echo "Sign up successful, but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>
