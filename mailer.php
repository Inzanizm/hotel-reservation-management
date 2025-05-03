<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "sandbox.smtp.mailtrap.io";
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->Username = "4d301f304eaac5";
$mail->Password = "255e3f739f30b4";

$mail->isHtml(true);

return $mail;


?>