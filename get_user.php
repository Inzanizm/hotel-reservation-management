<?php
header('Content-Type: application/json');
include('initialize.php'); // make sure this file defines $connection

if (isset($_GET['id'])) {
    $userid = $_GET['id'];

    $stmt = $connection->prepare("SELECT * FROM users_tb WHERE userid = ?");
    if ($stmt) {
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing user ID']);
}
?>
