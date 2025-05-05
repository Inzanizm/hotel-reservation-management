<?php include('initialize.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reservation_id']) && isset($_POST['reservation_status_id'])) {
        $reservation_id = intval($_POST['reservation_id']);
        $status_id = intval($_POST['reservation_status_id']);

        // Update reservation status
        $update_sql = "UPDATE reservations_tb SET reservation_status_id = ? WHERE reservation_id = ?";
        if ($stmt = $connection->prepare($update_sql)) {
            $stmt->bind_param("ii", $status_id, $reservation_id);

            if ($stmt->execute()) {
                $stmt->close();
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
