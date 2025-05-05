<?php
include 'initialize.php'; // Replace with your actual DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_status_id'])) {
    // Sanitize input
    $payment_id = intval($_POST['payment_id']);
    $payment_status_id = intval($_POST['payment_status_id']);

    // Update query
    $sql = "UPDATE payments_tb SET payment_status_id = ? WHERE payment_id = ?";
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $payment_status_id, $payment_id);
        if ($stmt->execute()) {
            // Optional: set a session message for success
            header("Location: Payments.php?status=success");
            exit();
        } else {
            // Optional: log error or set a failure message
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Failed to prepare statement: " . $connection->error;
    }
} else {
    // Invalid access
    header("Location: Payments.php");
    exit();
}
?>