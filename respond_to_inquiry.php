<?php
include('includes/header.php');

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['userid'] ?? null;

if (!$user_id) {
    echo "<script>alert('User session not found. Please log in again.');</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inquiry_id = $_POST['inquiry_id'];
    $response_message = $_POST['response_message'];

    // Get the guest's email and other info from the database
    $sql = "SELECT sender_email, sender_name, message_body, inquiry_type FROM inquiries_tb WHERE inquiry_id = ?";
    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("i", $inquiry_id);
        $stmt->execute();
        $stmt->bind_result($sender_email, $sender_name, $message_body, $inquiry_type);
        $stmt->fetch();
        $stmt->close();
    }

    // Insert the response into the replies table
    $sql = "INSERT INTO inquiry_replies_tb (inquiry_id, responder_id, reply_message, replied_date) VALUES (?, ?, ?, NOW())";
    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("iis", $inquiry_id, $user_id, $response_message);

        if ($stmt->execute()) {
            // Update the inquiry status
            $update_status = "UPDATE inquiries_tb SET status_id = 2 WHERE inquiry_id = ?";
            if ($update_stmt = $connection->prepare($update_status)) {
                $update_stmt->bind_param("i", $inquiry_id);
                $update_stmt->execute();
                $update_stmt->close();
            }

            // === Audit Log: Log this response action ===
<<<<<<< HEAD
            $operation_name = 'Respond to Inquiry';
=======
            $operation_name = 'Answer Email Inquiry';
>>>>>>> 1822f4082b682e1570b338700bd39c929d099571
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();

            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();

                $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
                $log_stmt->execute();
                $log_stmt->close();
            }

            $operation_type_stmt->close();
            // === End of Audit Logging ===

            // Send email response to the guest
            $email_subject = "Response to Your Inquiry";
            $email_body = "
Hello $sender_name,

Thank you for reaching out to us. We have received your inquiry and here is the response:

-----------
Inquiry Type: $inquiry_type
Your Message: $message_body

Response Message:
$response_message

Best regards,
Support Team
            ";

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = '9da3dac8b7d8aa';
                $mail->Password = 'c49097f0da5dca';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('your_email@example.com', 'Support Team');
                $mail->addAddress($sender_email, $sender_name);
                $mail->addReplyTo('support@example.com', 'Support Team');

                $mail->isHTML(true);
                $mail->Subject = $email_subject;
                $mail->Body    = nl2br($email_body);

                $mail->send();
                echo "<script>alert('Response sent to guest successfully!'); window.location.href = 'inquiries_list.php';</script>";
                exit();
            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        } else {
            echo "<script>alert('Error saving reply: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Database error: " . $connection->error . "');</script>";
    }
}
?>
