<?php include('../../initialize.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Guest Info
    $first_name = $connection->real_escape_string($_POST['firstname']);
    $last_name = $connection->real_escape_string($_POST['lastname']);
    $email = $connection->real_escape_string($_POST['email']);
    $contact_number = $connection->real_escape_string($_POST['contact_number']);
    $home_address = $connection->real_escape_string($_POST['home_address']);
    $street_name = $connection->real_escape_string($_POST['street_name']);
    $barangay = $connection->real_escape_string($_POST['barangay']);
    $city_municipality = $connection->real_escape_string($_POST['city_municipality']);
    $province = $connection->real_escape_string($_POST['province']);
    $eta = $connection->real_escape_string($_POST['eta']);
    $special_request = $connection->real_escape_string($_POST['special-request']);

    // Insert special request
    $sql_request = "INSERT INTO special_requests (special_request) VALUES ('$special_request')";
    if ($connection->query($sql_request)) {
        $request_id = $connection->insert_id;

        $sql_guest = "INSERT INTO guests_tb (fname, lname, email, contact_number, home_address, street_name, barangay, city_municipality, province, estimated_arrival_time, special_request_id)
                      VALUES ('$first_name', '$last_name', '$email', '$contact_number', '$home_address', '$street_name', '$barangay', '$city_municipality', '$province', '$eta', '$request_id')";
        if ($connection->query($sql_guest)) {
            $guest_id = $connection->insert_id;

            // Step 2: Reservation
            $checkIn = $_POST['check_in_date'];
            $checkOut = $_POST['check_out_date'];
            $totalGuests = $_POST['total_guests'];
            $totalAmount = $_POST['total_amount'];
            $confirmedBy = $_POST['confirmed_by'];
            $statusId = $_POST['reservation_status_id'];

            $stmt1 = $connection->prepare("INSERT INTO reservations_tb (guest_id, reservation_status_id, check_in_date, check_out_date, total_guests, total_amount, confirmed_by)
                                           VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt1->bind_param("iissidi", $guest_id, $statusId, $checkIn, $checkOut, $totalGuests, $totalAmount, $confirmedBy);
            $stmt1->execute();
            $reservation_id = $connection->insert_id;
            $stmt1->close();

            // Step 3: Payment
            $method = $_POST['method'];
            $paymentStatusId = $_POST['payment_status_id'];
            $referenceNumber = $_POST['reference_number'];

            $stmt2 = $connection->prepare("INSERT INTO payments_tb (reservation_id, amount_paid, method, payment_status_id, reference_number)
                                           VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param("idsis", $reservation_id, $totalAmount, $method, $paymentStatusId, $referenceNumber);
            if ($stmt2->execute()) {
                echo "Booking and reservation successful!";
            } else {
                echo "Error saving payment: " . $stmt2->error;
            }
            $stmt2->close();
        } else {
            echo "Error saving guest: " . $connection->error;
        }
    } else {
        echo "Error saving special request: " . $connection->error;
    }

    $connection->close();
}
?>
