<?php include('includes/header.php'); ?>

<div class="container">
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Reservation Management</h3>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Reservoir</th>
						<th>Check-in</th>
						<th>Check-out</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $connection->query("SELECT * from `reservations_tb` order by `reservation_status_id` asc, unix_timestamp(`created_date`) desc ");
                        $qry = $connection->query("
    SELECT r.*, g.fname, g.lname 
    FROM reservations_tb r
    JOIN guests_tb g ON r.guest_id = g.guests_id
    ORDER BY r.reservation_status_id ASC, UNIX_TIMESTAMP(r.created_date) DESC
");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?= $i++ ?></td>
							<td class=""><p class="truncate-1"><?php echo ucwords($row['fname'] . ' ' . $row['lname']) ?></p></td>
							<td class=""><?php echo date("Y-m-d",strtotime($row['check_in_date'])) ?></td>
							<td class=""><?php echo date("Y-m-d",strtotime($row['check_out_date'])) ?></td>
							<td class="text-center">
								<?php 
									switch ($row['reservation_status_id']){
                                        case 1:
                                            echo '<span class="rounded-pill badge bg-success ">Completed</span>';
                                            break;
                                        case 2:
                                            echo '<span class="rounded-pill badge bg-warning " >Pending</span>';
                                            break;
                                        case 3:
                                            echo '<span class="rounded-pill badge bg-success ">Confirmed</span>';
                                            break;
                                        case 4:
                                            echo '<span class="rounded-pill badge bg-danger ">Cancelled</span>';
                                            break;
                                    }
								?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-window-restore text-gray"></span> View</a>
									<div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
</div>
<?php // YEAR CALENDAR TO VIEW THE BOOKED IN THOSE MARKED DATES
// Database connection
$year = date('Y');

// Get all date ranges for reservations
$bookedDates = [];
$sql = "SELECT check_in_date, check_out_date FROM reservations_tb";
$result = $connection->query($sql);
while ($row = $result->fetch_assoc()) {
    $start = strtotime($row['check_in_date']);
    $end = strtotime($row['check_out_date']);
    for ($d = $start; $d <= $end; $d += 86400) {
        $bookedDates[] = date("Y-m-d", $d);
    }
}

// Remove duplicate dates
$bookedDates = array_unique($bookedDates);

// HTML + Styles
?>
<h1 style="text-align:center;">Room Reservation Calendar - <?php echo $year; ?></h1>
<style>
    .calendar {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    th {
        background: #007bff;
        color: #fff;
        padding: 10px;
    }
    td {
        border: 1px solid #ddd;
        text-align: center;
        padding: 10px;
        height: 50px;
    }
    .booked {
        background-color: #ff6961;
        color: white;
        font-weight: bold;
    }
    .available {
        background-color: #d4edda;
    }
    a { text-decoration: none; color: inherit; }
</style>
<div class='calendar'>
<?php
for ($month = 1; $month <= 12; $month++) {
    $monthName = date('F', mktime(0, 0, 0, $month, 1, $year));
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $startDay = date('w', strtotime("$year-$month-01"));

    echo "<table>";
    echo "<tr><th colspan='7'>$monthName</th></tr>";
    echo "<tr>
        <th>Sun</th><th>Mon</th><th>Tue</th>
        <th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
    </tr>";

    $day = 1;
    echo "<tr>";
    for ($i = 0; $i < $startDay; $i++) echo "<td></td>";

    for ($i = $startDay; $i < 7 && $day <= $daysInMonth; $i++) {
        $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
        $class = in_array($date, $bookedDates) ? 'booked' : 'available';
        echo "<td class='$class'><a href='?date=$date'>$day</a></td>";
        $day++;
    }
    echo "</tr>";

    while ($day <= $daysInMonth) {
        echo "<tr>";
        for ($i = 0; $i < 7; $i++) {
            if ($day > $daysInMonth) {
                echo "<td></td>";
            } else {
                $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                $class = in_array($date, $bookedDates) ? 'booked' : 'available';
                echo "<td class='$class'><a href='?date=$date'>$day</a></td>";
                $day++;
            }
        }
        echo "</tr>";
    }

    echo "</table>";
}
?>
</div>
<?php
if (isset($_GET['date'])) {
    $selectedDate = $_GET['date'];
    echo "<h2 style='text-align:center;'>Guests Booked on $selectedDate</h2>";

     $query = "SELECT g.fname, g.lname, g.email, g.contact_number, r.check_in_date, r.check_out_date 
              FROM reservations_tb r
              JOIN guests_tb g ON r.guest_id = g.guests_id
              WHERE '$selectedDate' BETWEEN r.check_in_date AND r.check_out_date";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        echo "<table style='width:80%;margin:auto;margin-bottom:30px;'>
                <tr><th>Name</th><th>Email</th><th>Contact Number</th><th>Check In</th><th>Check Out</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['fname']} {$row['lname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['contact_number']}</td>
                <td>{$row['check_in_date']}</td>
                <td>{$row['check_out_date']}</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No guests booked on this date.</p>";
    }
    echo "<p style='text-align:center;'><a href='reservation.php'>Back to Calendar</a></p>";
}
?>

<?php include('includes/footer.php'); ?>