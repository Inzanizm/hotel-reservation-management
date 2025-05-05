<?php
// Include the initialization file which already starts the session
include('initialize.php');

// Ensure the session is started if not already done
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the query to check if the user exists
    $stmt = $connection->prepare("SELECT * FROM users_tb WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        // Use password_verify for security (ensure passwords are hashed in DB)
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['userid'] = $user['userid']; // Save user id in session
            $_SESSION['email'] = $email;
            $_SESSION['alert_message'] = 'You are logged in.';
            $_SESSION['user_firstname'] = $user['fname'];
            $_SESSION['is_login'] = true;
            
            // Generate OTP
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;

            // Log the login activity
            $operation_name = 'Login';
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();

            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();

                // Log the login activity
                $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                $log_stmt->bind_param("ii", $user['userid'], $operation_type['operation_type_id']);
                $log_stmt->execute();
            }

            // Send OTP via email
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '9da3dac8b7d8aa';
            $mail->Password = 'c49097f0da5dca';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@resort.com', 'Resort');
            $mail->addAddress($email);
            $mail->Subject = 'Your One-Time Password';
            $mail->Body = "Your OTP is: $otp";

            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                header("Location: otp.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Incorrect password.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Email not found.";
        header("Location: index.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation Management</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    scroll-behavior: smooth;
}

body {
      margin: 0;
      padding: 0;
      background-color: black;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .bg {
      background-image: url('img/bg-nobs.jpg');
      background-size: cover;
      background-position: center;
      width: 100vw;
      height: 100vh;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .bg::before {
  content: '';
  position: absolute;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.6); /* Adjust the 0.4 for more/less transparency */
  z-index: 1;
}
    .left {
        display: flex;
        height: 100vh;
        width: 65vw;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .right {
        display: flex;
        height: 100vh;
        width: 34.75vw;
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    .divider{
        background-color: black;
        width: .25vw;
        height: 100vh;
        z-index: 1000;
    }
    .intro {
        font-family: Arial, Helvetica, sans-serif;
        display: flex;
        justify-content: space-between;
        flex-direction: column;
        width: 90%;
        height: 90%;
        color: white;
        text-align: center;
    }
    .intro h1{
        font-size: 50px;
    }
    .intro h6{
        font-size: 28px;
        font-weight: 120;
    }
    .login-box{
        display: flex;
        flex-direction: column;
        background-color: #85ACB1;
        border-radius: 20px;
        width: 80%;
        height: 83%;
        justify-content: space-around;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
    }

    .login-box h1{
        font-size: 50px;
        width: 100%;
        height: 19.75%;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hr{
        height: .25%;
        width: 100%;
        background-color: black;
    }

    .bottom{
        /* background-color: aqua; */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center   ;
        width: 100%;
        height: 80%;
    }

    .login-box form{
        /* background-color: bisque; */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-content: center;
        width: 90%;
        height: 60%;
        padding: 5%;
    }

    form h3{
        font-weight: 100;
    }

    form input{
        height: 40px;
        border-radius: 8px;
        border: gray 1px solid;
        padding: 16px;
        font-size: 16px;
    }
    form button{
        height: 40px;
        border-radius: 8px;
        border: none;
        background-color: #102C33;
        color: white;
    }
    </style>
</head>
<body>
    <div class="bg">
        <div class="left">
            <div class="intro">
                <h1>RESERVATION MANAGEMENT SYSTEM FOR RESORTS</h1>
                <br>
                <h6>Step into a peaceful paradise with a Resort Reservation Management System — designed for hidden gems like yours.</h6>
                <br>
                <h6>If your resort still doesn’t have a reservation system in place, now’s the perfect time to level up. Imagine handling bookings, tracking guest preferences, and managing room availability all in one easy-to-use platform — while your guests enjoy the calm waters, soft sand, and fresh air of your beach paradise.</h6>
                <br>
                <h6>This system is made for resorts that want to simplify operations and offer seamless service without the stress. Whether it’s confirming reservations or keeping an eye on room occupancy, everything becomes easier and more efficient.</h6>
                <br>
                <h6>Discover how a resort reservation management system can help you create the perfect escape for your guests — and a smoother experience for you.</h6>
            </div>

        </div>
        <div class="divider">

        </div>
        <div class="right">
            <div class="login-box">
                <h1 valign="center">LOG IN</h1>
                <div class="hr"></div>
                <div class="bottom">
                
            </div>
            </div>

        </div>

    </div>
    
</body>
</html>