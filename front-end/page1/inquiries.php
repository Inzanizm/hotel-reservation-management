<?php include('../../initialize.php'); ?>
<?php

if (isset($_POST['submit'])) {
    // Retrieving form values
    $name = $_POST['name'];
    $contact_number = $_POST['cn'];
    $email = $_POST['email'];
    $inquiry_type = $_POST['inquiry_type'];
    $message = $_POST['message'];
    
    // Sanitize input values
    $name = $connection->real_escape_string($name);
    $email = $connection->real_escape_string($email);
    $contact_number = $connection->real_escape_string($contact_number); 
    $inquiry_type = $connection->real_escape_string($inquiry_type);
    $message = $connection->real_escape_string($message);


     // 1. Ensure 'unread' status exists in inquery_status_tb
    $status_check_query = "SELECT status_id FROM inquiry_status_tb WHERE status_name = 'unread'";
    $result = $connection->query($status_check_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status_id = $row['status_id'];
    } else {
        // Insert 'unread' into inquery_status_tb
        $insert_status_query = "INSERT INTO inquiry_status_tb (status_name) VALUES ('unread')";
        if ($connection->query($insert_status_query) === TRUE) {
            $status_id = $connection->insert_id; // Get the ID of the newly inserted status
        } else {
            echo "Error inserting status: " . $connection->error;
            exit();
        }
    }

    // 2. Insert inquiry with associated status_id
    $sql_inquiry = "INSERT INTO inquiries_tb (sender_name, sender_email, contact_number, inquiry_type, message_body, status_id) 
                    VALUES ('$name', '$email', '$contact_number', '$inquiry_type', '$message', '$status_id')";

    if ($connection->query($sql_inquiry) === TRUE) {
        echo "<script>alert('Inquiry submitted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error inserting inquiry: " . $connection->error;
    }
}
?>