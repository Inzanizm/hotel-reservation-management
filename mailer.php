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
$mail->Username = "6fd472d8ef5b11";
$mail->Password = "17e4340662e778";

$mail->isHtml(true);

return $mail;


?>