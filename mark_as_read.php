<?php include('initialize.php'); ?> 

<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['userid'] ?? null;

if (!$user_id) {
    echo "<script>alert('User session not found. Please log in again.');</script>";
    exit();
}

if (isset($_GET['inquiry_id'])) {
    $inquiry_id = intval($_GET['inquiry_id']);

    // Set status_id = 2 (Read/Done)
    $update = $connection->query("
        UPDATE inquiries_tb 
        SET status_id = 2 
        WHERE inquiry_id = $inquiry_id
    ");

    if ($update) {
        // Audit logging for marking inquiry as done
        $operation_name = 'Read Message';
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

        header("Location: inquiries_list.php");
        exit;
    } else {
        echo "Error updating status: " . $connection->error;
    }
}
?>
