<?php include('initialize.php'); ?>
<?php
// or wherever your DB connection is

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reservation_id']) && isset($_POST['reservation_status_id'])) {
        $reservation_id = intval($_POST['reservation_id']);
        $status_id = intval($_POST['reservation_status_id']);

        // Update reservation status
        $update = $connection->query("UPDATE reservations_tb SET reservation_status_id = $status_id WHERE reservation_id = $reservation_id");

        if ($update) {
            // Redirect back to reservation management page
            header("Location: reservation.php?updated=1");
            exit();
        } else {
            // Handle error
            echo "Failed to update reservation.";
        }
    }
}
?>
