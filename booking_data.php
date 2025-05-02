<?php
$conn = new mysqli("localhost", "root", "", "hotel-reservation-management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filter = $_GET['filter'] ?? 'day'; // default filter is day

switch ($filter) {
    case 'day':
        $sql = "SELECT DATE(booking_date) AS label, COUNT(*) AS total 
                FROM bookings 
                GROUP BY DATE(booking_date)
                ORDER BY label ASC";
        break;

    case 'week':
        $sql = "SELECT YEAR(booking_date) AS y, WEEK(booking_date) AS w, COUNT(*) AS total 
                FROM bookings 
                GROUP BY YEAR(booking_date), WEEK(booking_date)
                ORDER BY y, w ASC";
        break;

    case 'month':
        $sql = "SELECT DATE_FORMAT(booking_date, '%Y-%m') AS label, COUNT(*) AS total 
                FROM bookings 
                GROUP BY DATE_FORMAT(booking_date, '%Y-%m')
                ORDER BY label ASC";
        break;
}

$result = $conn->query($sql);
$labels = [];
$totals = [];

while ($row = $result->fetch_assoc()) {
    if ($filter == 'week') {
        $labels[] = "Week " . $row['w'] . " - " . $row['y'];
    } else {
        $labels[] = $row['label'];
    }
    $totals[] = (int)$row['total'];
}

echo json_encode([
    "labels" => $labels,
    "data" => $totals
]);

$conn->close();
?>