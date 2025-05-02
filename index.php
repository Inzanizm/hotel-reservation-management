<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']); // Clear after displaying
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
            background-color: rgba(0, 0, 0, 0.6);
            /* Adjust the 0.4 for more/less transparency */
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

        .divider {
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

        .intro h1 {
            font-size: 50px;
        }

        .intro h6 {
            font-size: 28px;
            font-weight: 120;
        }

        .login-box {
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

        .login-box h1 {
            font-size: 50px;
            width: 100%;
            height: 19.75%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hr {
            height: .25%;
            width: 100%;
            background-color: black;
        }

        .bottom {
            /* background-color: aqua; */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 80%;
        }

        .login-box form {
            /* background-color: bisque; */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-content: center;
            width: 90%;
            height: 60%;
            padding: 5%;
        }

        form h3 {
            font-weight: 100;
        }

        form input {
            height: 40px;
            border-radius: 8px;
            border: gray 1px solid;
            padding: 16px;
            font-size: 16px;
        }

        form button {
            height: 40px;
            border-radius: 8px;
            border: none;
            background-color: #102C33;
            color: white;
        }

        .error-msg {
            color: red;
            margin-bottom: 10px;
        }

        .password-container {
            position: relative;
            width: 100%;
            /* or a fixed width like 300px */
        }

        .password-container>input {
            width: 100%;
            padding-right: 30px;
            /* to make room for the eye icon */
            box-sizing: border-box;
            ;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        form .fp{
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="bg">
        <div class="left">
            <div class="intro">
                <h1>RESERVATION MANAGEMENT SYSTEM FOR RESORTS</h1>
                <br>
                <h6>Step into a peaceful paradise with a Resort Reservation Management System — designed for hidden gems
                    like yours.</h6>
                <br>
                <h6>If your resort still doesn’t have a reservation system in place, now’s the perfect time to level up.
                    Imagine handling bookings, tracking guest preferences, and managing room availability all in one
                    easy-to-use platform — while your guests enjoy the calm waters, soft sand, and fresh air of your
                    beach paradise.</h6>
                <br>
                <h6>This system is made for resorts that want to simplify operations and offer seamless service without
                    the stress. Whether it’s confirming reservations or keeping an eye on room occupancy, everything
                    becomes easier and more efficient.</h6>
                <br>
                <h6>Discover how a resort reservation management system can help you create the perfect escape for your
                    guests — and a smoother experience for you.</h6>
            </div>

        </div>
        <div class="divider">

        </div>
        <div class="right">
            <div class="login-box">
                <h1 valign="center">LOG IN</h1>
                <div class="hr"></div>
                <div class="bottom">
                    <form method="POST" action="send_otp.php">
                        <h3>Email</h3>
                        <input type="email" name="email" required>
                        <h3>Password</h3>
                        <div class="password-container">
                            <input type="password" name="password" id="password" required>
                            <span class="toggle-password" onclick="togglePassword()">👁️</span>
                        </div>
                        <a class="fp" href="forgot_pw.php">Forgot password?</a>
                        <button name="login" type="submit">Submit</button>
                        <a class="gb" href="front-end/page1/index.php">Go back to website</a>
                        <?php if ($error): ?>
                        <div class="error-msg">
                            <?= $error ?>
                        </div>
                        <?php endif; ?>

                    </form>
                </div>
            </div>

        </div>

    </div>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const toggleIcon = document.querySelector(".toggle-password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.textContent = "🙈"; // change icon
            } else {
                passwordField.type = "password";
                toggleIcon.textContent = "👁️"; // revert icon
            }
        }
    </script>

</body>

</html>