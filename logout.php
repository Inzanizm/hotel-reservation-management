<?php
// Include the initialization file which starts the session
include('initialize.php');

// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];

    // Get operation_type_id for Logout
    $operation_name = 'Logout';
    $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
    $operation_type_stmt->bind_param("s", $operation_name);
    $operation_type_stmt->execute();
    $operation_type_res = $operation_type_stmt->get_result();

    if ($operation_type_res->num_rows > 0) {
        $operation_type = $operation_type_res->fetch_assoc();

        // Log the logout activity
        $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
        $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
        $log_stmt->execute();
    }

    // Destroy session
    session_unset();
    session_destroy();

    // Redirect to login page after logout
    header("Location: index.php");
    exit();
} else {
    echo "Error: User not logged in.";
    exit();
}
?>
