<?php include('../../initialize.php'); ?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $checkIn = $_POST['check_in_date'];
    $checkOut = $_POST['check_out_date'];
    $totalGuests = $_POST['total_guests'];
    $totalAmount = $_POST['total_amount'];
    $confirmedBy = $_POST['confirmed_by'];
    $statusId = $_POST['reservation_status_id'];

    // Get latest guest_id
    $guestSql = "SELECT id FROM guests_tb ORDER BY id DESC LIMIT 1";
    $guestResult = $connection->query($guestSql);
    $guestId = $guestResult->fetch_assoc()['id'];

    // Insert into reservations_tb
    $stmt = $connection->prepare("INSERT INTO reservations_tb (guest_id, reservation_status_id, check_in_date, check_out_date, total_guests, total_amount, confirmed_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissidi", $guestId, $statusId, $checkIn, $checkOut, $totalGuests, $totalAmount, $confirmedBy);

    if ($stmt->execute()) {
        echo "Reservation inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}
?>