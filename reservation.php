<?php include('includes/header.php'); ?>

<?php

// Get current page from URL, default is page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


$searchTerm = isset($_GET['search']) ? trim($connection->real_escape_string($_GET['search'])) : '';
$searchQuery = "";


$qry = $connection->query("SELECT r.*, g.fname, g.lname 
    FROM reservations_tb r 
    JOIN guests_tb g ON r.guest_id = g.guests_id 
    $searchQuery 
    ORDER BY r.reservation_status_id ASC, UNIX_TIMESTAMP(r.created_date) DESC");
?>

<div class="container">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Reservation Management</h3>
        </div>
        <div class="card-body">
            <!-- Reservations Table -->
            <table id="reservationsTable" class="table table-hover table-striped table-bordered">
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
                        <th>Reservoir</th> <!-- Should this be 'Guest Name'? -->
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;

                        // Loop through the results
                        while ($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?= $i++ ?></td>
                        <td><p class="truncate-1"><?= ucwords($row['fname'] . ' ' . $row['lname']) ?></p></td>
                        <td><?= date("Y-m-d", strtotime($row['check_in_date'])) ?></td>
                        <td><?= date("Y-m-d", strtotime($row['check_out_date'])) ?></td>
                        <td class="text-center">
                            <?php 
                                // Display reservation status with color-coded badges
                                switch ($row['reservation_status_id']){
                                    case 1:
                                        echo '<span class="rounded-pill badge badge-primary col-9">Completed</span>';
                                        break;
                                    case 2:
                                        echo '<span class="rounded-pill badge badge-secondary col-9" style="color:white;background:green;text-align:center;">Pending</span>';
                                        break;
                                    case 3:
                                        echo '<span class="rounded-pill badge badge-success col-9">Confirmed</span>';
                                        break;
                                    case 4:
                                        echo '<span class="rounded-pill badge badge-danger col-9">Cancelled</span>';
                                        break;
                                }                                
                            ?>
                        </td>
                        <td align="center">
                            <a href="#" class="text-primary me-2" title="View"><i class="fas fa-eye fa-lg"></i></a>
                            <a href="#" class="text-danger" title="Archive"><i class="fas fa-archive fa-lg"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <script>
                $(document).ready(function () {
                    $('#reservationsTable').DataTable({
                        paging: true,
                        lengthChange: true,
                        searching: true, // enables live search
                        ordering: true,
                        info: true,
                        autoWidth: true,
                        responsive: true,
                        pageLength: 10,
                        dom: 'Bfrtip',
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    });
                });
            </script>
        </div>
    </div>
</div>

<?php
// ===================
// Calendar Section
// ===================

// Set year to current
$year = date('Y');

// Fetch all reserved date ranges
$bookedDates = [];
$sql = "SELECT check_in_date, check_out_date FROM reservations_tb";
$result = $connection->query($sql);

// Loop through and expand each date range into individual dates
while ($row = $result->fetch_assoc()) {
    $start = strtotime($row['check_in_date']);
    $end = strtotime($row['check_out_date']);
    for ($d = $start; $d <= $end; $d += 86400) {
        $bookedDates[] = date("Y-m-d", $d);
    }
}

// Remove duplicates
$bookedDates = array_unique($bookedDates);
?>

<!-- Calendar Heading -->
<h1 style="text-align:center; margin-top: 30px;">Room Reservation Calendar - <?= $year ?></h1>

<!-- Legend -->
<div style="text-align:center; margin-bottom: 20px;">
    <strong>Calendar Legend:</strong>
    <span style="display:inline-block; background:#ff6961; color:white; padding:5px 10px; margin: 0 10px; border-radius: 5px;">Booked</span>
    <span style="display:inline-block; background:#d4edda; color:#155724; padding:5px 10px; border-radius: 5px;">Available</span>
</div>

<style>
   .calendar-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.calendar-nav {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    margin-bottom: 30px;
}

.calendar-nav button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.calendar-nav button:hover {
    background-color: #0056b3;
}

/* Calendar Grid */
.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr); /* 7 columns for 7 days */
    gap: 10px;
    padding: 10px;
    font-family: Arial, sans-serif;
    font-size: 14px;
    color: #333;
}

.calendar-header {
    font-weight: bold;
    text-align: center;
    background-color: #f1f1f1;
    padding: 10px;
    border-radius: 5px;
}

.calendar-day {
    text-align: center;
    padding: 20px 0;
    border-radius: 5px;
    font-size: 16px;
    height: 50px;
    line-height: 50px;  /* Ensures numbers are vertically centered */
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.2s ease;
}

.calendar-day:hover {
    background-color: #f0f0f0;
    transform: scale(1.05);  /* Adds a subtle zoom effect on hover */
}

/* Booking and availability colors */
.booked {
    background-color: #ff6961;
    color: white;
    font-weight: bold;
}

/* Responsive Design */
@media (max-width: 768px) {
    .calendar {
        grid-template-columns: repeat(4, 1fr); /* Fewer columns on smaller screens */
    }

    .calendar-day {
        font-size: 14px;
        padding: 15px 0;
    }
}

@media (max-width: 480px) {
    .calendar {
        grid-template-columns: repeat(3, 1fr); /* Adjust even more on mobile */
    }

    .calendar-day {
        font-size: 12px;
        padding: 12px 0;
    }
}

    .card-title{
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }

    .booked {
    background-color: #ff6961;
    color: red!important;
    padding: 5px;
    text-align: center;
}

.available {
    background-color: #d4edda;
    color: green!important;
    padding: 5px;
    text-align: center;
}
</style>

<?php
// Get today's date
$todayDate = date('Y-m-d');
?>

<!-- Calendar Navigation: Allows the user to go to the previous or next month -->
<div class="calendar-nav">
    <button onclick="changeMonth(-1)" class="btn btn-secondary">Previous</button>
    <div style="text-align:center;">
        <h2 id="calendar-month" style="margin: 0;"></h2> <!-- Month Name -->
        <!-- Current Date -->
        <div style="margin-top: 10px;">
            <strong>Today's Date:</strong> <?= $todayDate ?>
        </div>
    </div>
    <button onclick="changeMonth(1)" class="btn btn-secondary">Next</button>
</div>

<!-- Calendar Table Structure -->
<table id="calendar" class="table table-bordered">
    <thead>
        <!-- Calendar Days Header -->
        <tr>
            <th>Sun</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
        </tr>
    </thead>
    <tbody></tbody> <!-- Calendar days will be inserted here dynamically -->
</table>

<script>
    // Initialize the current displayed month
    let currentMonth = new Date().getMonth();
    
    // Pass PHP year variable into JavaScript
    const year = <?php echo $year; ?>;
    
    // Convert booked dates array from PHP to JavaScript
    const bookedDates = <?php echo json_encode($bookedDates); ?>;

    // Change the displayed month by incrementing or decrementing the currentMonth variable
    function changeMonth(offset) {
        currentMonth += offset;
        if (currentMonth < 0) currentMonth = 11; // Wrap to December
        if (currentMonth > 11) currentMonth = 0; // Wrap to January
        renderCalendar();
    }

    // Dynamically generate the calendar for the selected month
    function renderCalendar() {
        const monthName = new Date(year, currentMonth).toLocaleString('default', { month: 'long' });
        document.getElementById('calendar-month').textContent = monthName + ' ' + year;

        const firstDay = new Date(year, currentMonth, 1); // First day of the month
        const lastDay = new Date(year, currentMonth + 1, 0); // Last day of the month
        const numDays = lastDay.getDate(); // Total number of days in the month
        const firstDayOfWeek = firstDay.getDay(); // Day index the month starts on (0=Sunday)

        const totalRows = Math.ceil((numDays + firstDayOfWeek) / 7); // Number of calendar rows needed
        let calendarHTML = '';

        // Build rows of the calendar
        for (let i = 0; i < totalRows; i++) {
            calendarHTML += '<tr>';
            for (let j = 0; j < 7; j++) {
                const day = i * 7 + j - firstDayOfWeek + 1;

                if (day > 0 && day <= numDays) {
                    // Format the date to match YYYY-MM-DD
                    const dateString = `${year}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                    // Check if this date is booked
                    const isBooked = bookedDates.includes(dateString);

                    // Make the date clickable
                    const dateLink = `?date=${dateString}`;

                    // Apply class based on booking status
                    calendarHTML += `<td class="${isBooked ? 'booked' : 'available'}">
                        <a href="${dateLink}" style="text-decoration:none; color: inherit;">${day}</a>
                    </td>`;
                } else {
                    // Empty cell for days before the first day of the month
                    calendarHTML += '<td></td>';
                }
            }
            calendarHTML += '</tr>';
        }

        // Insert the generated calendar HTML into the table
        document.querySelector('#calendar tbody').innerHTML = calendarHTML;
    }

    // Initial render when page loads
    renderCalendar();
</script>

<?php
// If a specific date is clicked, show guest reservations on that day
if (isset($_GET['date'])) {
    $selectedDate = $_GET['date'];
    echo "<h2 class='text-center mb-4'>Guests Booked on $selectedDate</h2>";

    // SQL query to fetch guest details for the selected date
    $query = "SELECT g.fname, g.lname, g.email, g.contact_number, r.check_in_date, r.check_out_date 
              FROM reservations_tb r
              JOIN guests_tb g ON r.guest_id = g.guests_id
              WHERE '$selectedDate' BETWEEN r.check_in_date AND r.check_out_date";
    $result = $connection->query($query);

    // If bookings exist on that date, display them
    if ($result->num_rows > 0) {
        echo "<div class='table-responsive'>
                <table class='table table-striped table-bordered text-center mb-4'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['fname']} {$row['lname']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['contact_number']}</td>
                    <td>{$row['check_in_date']}</td>
                    <td>{$row['check_out_date']}</td>
                </tr>";
        }
        echo "</tbody>
            </table>
        </div>";
    } else {
        echo "<p class='text-center'>No guests booked on this date.</p>";
    }

    // Back link
    echo "<div class='text-center mt-4'>
            <a href='reservation.php' class='btn btn-primary'>Back to Calendar</a>
          </div>";

    // Stop further rendering
    exit;
}
?>

<script>
    // Clear the search input and submit the form to reload page
    document.querySelector('.input-group-text').addEventListener('click', function() {
        let searchInput = document.querySelector('input[name="search"]');
        searchInput.value = '';
        document.querySelector('form').submit();
    });

    // Handle Enter key on search input
    document.querySelector('input[name="search"]').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            let searchInput = document.querySelector('input[name="search"]');
            if (searchInput.value.trim() === '') {
                searchInput.value = '';
            }
            document.querySelector('form').submit();
        }
    });

    // Confirmation and redirection for delete actions
    document.querySelectorAll('.delete_data').forEach(button => {
        button.addEventListener('click', function() {
            const reservationId = this.getAttribute('data-id');
            
            if (confirm('Are you sure you want to delete this reservation?')) {
                window.location.href = 'delete_reservation.php?id=' + reservationId;
            }
        });
    });
</script>

<!-- Scripts -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<!-- Footer of the page -->
<?php include('includes/footer.php'); ?>
