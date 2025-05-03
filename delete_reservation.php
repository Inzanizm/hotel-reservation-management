<?php
include('includes/header.php');

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $reservationId = $_GET['id'];

    // Delete the reservation record from the database
    $query = "DELETE FROM reservations_tb WHERE id = $reservationId";
    
    if ($connection->query($query)) {
        echo "<script>alert('Reservation deleted successfully!'); window.location.href = 'reservations.php';</script>";
    } else {
        echo "<script>alert('Error deleting reservation!'); window.location.href = 'reservations.php';</script>";
    }
}
?>
