<?php include('../../initialize.php'); ?>
<?php

if (isset($_POST['submit'])) {
    // Retrieving form values
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $home_address = $_POST['home_address'];
    $street_name = $_POST['street_name'];
    $barangay = $_POST['barangay'];
    $city_municipality = $_POST['city_municipality'];
    $province = $_POST['province'];
    $eta = $_POST['eta'];
    $special_request = $_POST['special-request'];  // Retrieve special request

    // Sanitize input values
    $first_name = $connection->real_escape_string($first_name);
    $last_name = $connection->real_escape_string($last_name);
    $email = $connection->real_escape_string($email);
    $contact_number = $connection->real_escape_string($contact_number);
    $home_address = $connection->real_escape_string($home_address);
    $street_name = $connection->real_escape_string($street_name);
    $barangay = $connection->real_escape_string($barangay);
    $city_municipality = $connection->real_escape_string($city_municipality);
    $province = $connection->real_escape_string($province);
    $eta = $connection->real_escape_string($eta);
    $special_request = $connection->real_escape_string($special_request);

    // Insert special request into special_requests table
    $sql_request = "INSERT INTO special_requests (special_request) 
                    VALUES ('$special_request')";
    if ($connection->query($sql_request) === TRUE) {
        // Get the last inserted special request id
        $request_id = $connection->insert_id;

        // Insert guest details into guests_tb table
        $sql_guest = "INSERT INTO guests_tb (fname, lname, email, contact_number, home_address, street_name, barangay, city_municipality, province, estimated_arrival_time, special_request_id) 
                      VALUES ('$first_name', '$last_name', '$email', '$contact_number', '$home_address', '$street_name', '$barangay', '$city_municipality', '$province', '$eta', '$request_id')";

        if ($connection->query($sql_guest) === TRUE) {
            echo "<script>alert('Booking successful!'); window.location.href='../page1/index.php';</script>";
        } else {
            echo "Error inserting guest details: " . $connection->error;
        }
    } else {
        echo "Error inserting special request: " . $connection->error;
    }
}



?>