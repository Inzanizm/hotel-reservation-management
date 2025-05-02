<?php include('initialize.php');?>
<?php session_start();
$inputOtp = $_POST['otp'];

if ($inputOtp == $_SESSION['otp']) {
    header("Location: dashboard.php");
    exit();
} else {
  $_SESSION['error'] = "Invalid OTP. Try again.";
  header("Location: otp.php");
  exit();
}
?>