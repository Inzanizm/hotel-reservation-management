<?php include('initialize.php'); ?>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reservation_id']) && isset($_POST['reservation_status_id'])) {
        $reservation_id = intval($_POST['reservation_id']);
        $status_id = intval($_POST['reservation_status_id']);

        // Get user ID from session
        $user_id = $_SESSION['userid'] ?? null;

        if (!$user_id) {
            echo "<script>alert('User session not found. Please log in again.');</script>";
            exit();
        }

        // Update reservation status
        $update_sql = "UPDATE reservations_tb SET reservation_status_id = ? WHERE reservation_id = ?";
        if ($stmt = $connection->prepare($update_sql)) {
            $stmt->bind_param("ii", $status_id, $reservation_id);

            if ($stmt->execute()) {
                $stmt->close();

                // Log the operation
                $operation_name = 'Update Reservation';
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

                header("Location: reservation.php?updated=1");
                exit();
            } else {
                echo "Error updating reservation: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $connection->error;
        }
    } else {
        echo "Missing reservation ID or status ID.";
    }
}
?>
