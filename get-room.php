<?php
include('initialize.php');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $connection->prepare("
        SELECT room_id, room_number, room_type_id, room_status_id, descriptions
        FROM rooms_tb
        WHERE room_id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc();

    echo json_encode($room);
}