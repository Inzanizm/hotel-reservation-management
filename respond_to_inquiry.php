<?php include('includes/header.php'); ?>

<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $inquiry_id = $_POST['inquiry_id'];
    $response_message = $_POST['response_message'];
    
    // Assuming a logged-in user, get the responder_id (you should replace this with actual logged-in user logic)
    $responder_id = 1;  // Replace with the actual user ID from your session or authentication system

    // Get the guest's email from the database
    $sql = "SELECT sender_email, sender_name, message_body, inquiry_type FROM inquiries_tb WHERE inquiry_id = ?";
    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("i", $inquiry_id);
        $stmt->execute();
        $stmt->bind_result($sender_email, $sender_name, $message_body, $inquiry_type);
        $stmt->fetch();
        $stmt->close();
    }

    // Insert the response into the inquiry_replies_tb table
    $sql = "INSERT INTO inquiry_replies_tb (inquiry_id, responder_id, reply_message, replied_date) 
            VALUES (?, ?, ?, NOW())";
    
    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("iis", $inquiry_id, $responder_id, $response_message);

        if ($stmt->execute()) {
            // Optionally: Update the inquiry status to 'responded'
            $update_status = "UPDATE inquiries_tb SET status_id = 2 WHERE inquiry_id = ?";
            if ($update_stmt = $connection->prepare($update_status)) {
                $update_stmt->bind_param("i", $inquiry_id);
                $update_stmt->execute();
                $update_stmt->close();
            }

            // Send email to the guest using PHPMailer
            $email_subject = "Response to Your Inquiry";
            $email_body = "
                Hello $sender_name,

                Thank you for reaching out to us. We have received your inquiry and here is the response:

                ---

                Inquiry Type: $inquiry_type
                Your Message: $message_body

                Response Message:
                $response_message

                Best regards,
                Support Team
            ";

            // Send email with PHPMailer
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.yourmailserver.com';  // Set the SMTP server to use
                $mail->SMTPAuth = true;
                $mail->Username = 'your_email@example.com';  // SMTP username
                $mail->Password = 'your_email_password';  // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;  // TCP port for TLS

                //Recipients
                $mail->setFrom('your_email@example.com', 'Support Team');
                $mail->addAddress($sender_email, $sender_name);  // Add guest's email and name
                $mail->addReplyTo('support@example.com', 'Support Team');  // Optional: Add reply-to address

                // Content
                $mail->isHTML(true);
                $mail->Subject = $email_subject;
                $mail->Body    = nl2br($email_body);

                // Send the email
                $mail->send();

                echo 'Response sent to guest successfully!';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            // Redirect back to the inquiries page or show a success message
            header("Location: email_inquiries.php?status=2");
            exit();
        } else {
            // Handle errors if insert fails
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $connection->error;
    }
}
?>
