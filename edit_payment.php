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
            // Get operation type ID for 'Update Payment Status'
            $operation_name = 'Update Payment Status';
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();

            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();

                // Log the operation in the audit log table
                $user_id = $_SESSION['userid'] ?? null;
                if ($user_id) {
                    $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                    $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
            }

            $operation_type_stmt->close();

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
