<?php
include('includes/header.php');
include('initialize.php'); // Ensure DB connection is included

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
$user_id = $_SESSION['userid'] ?? null;
if (!$user_id) {
    echo "<script>alert('User session not found. Please log in again.'); window.location.href = 'index.php';</script>";
    exit();
}

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $reservationId = intval($_GET['id']); // Always sanitize input

    // Delete the reservation record
    $query = "DELETE FROM reservations_tb WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $reservationId);

    if ($stmt->execute()) {
        // Step 1: Check if operation type exists
        $operation_name = 'Delete Reservation';
        $op_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
        $op_stmt->bind_param("s", $operation_name);
        $op_stmt->execute();
        $op_result = $op_stmt->get_result();

        if ($op_result->num_rows > 0) {
            $operation_type = $op_result->fetch_assoc();

            // Step 2: Log into audit log
            $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
            $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);

            if (!$log_stmt->execute()) {
                echo "<script>alert('Reservation deleted, but audit log failed: " . $log_stmt->error . "');</script>";
            }

            $log_stmt->close();
        } else {
            echo "<script>alert('Reservation deleted, but \"Delete Reservation\" operation type not found.');</script>";
        }

        $op_stmt->close();

        echo "<script>alert('Reservation deleted successfully!'); window.location.href = 'reservations.php';</script>";
    } else {
        echo "<script>alert('Error deleting reservation!'); window.location.href = 'reservations.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No reservation ID provided.'); window.location.href = 'reservations.php';</script>";
}
?>
