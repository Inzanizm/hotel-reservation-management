<?php include('includes/header.php'); ?>

<?php
// Set the number of records to show per page
$limit = 10;

// Get current page from URL, default is page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for SQL LIMIT
$offset = ($page - 1) * $limit;

// Get search term from URL, sanitize it
$searchTerm = isset($_GET['search']) ? $connection->real_escape_string($_GET['search']) : '';
$searchQuery = $searchTerm ? "WHERE CONCAT(fname, ' ', lname) LIKE '%$searchTerm%'" : '';
?>

<div class="container">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Reservation Management</h3>
            <button class="btn btn-outline-secondary" type="submit">
                    <i class="fa fa-filter"></i>
                </button>
            <!-- Search bar form for filtering reservations by guest name -->
            <div class="search-bar-container">
                <form method="get" action="" class="form input-group">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by Guest Name"
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
                    >
                    <span class="input-group-text">
                        <i class="fa fa-search"></i>
                    </span>
                </form>
            </div>
        </div>

        <div class="card-body">
            <!-- Reservations Table -->
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

                        // Refetch search query for security
                        $searchQuery = isset($_GET['search']) && !empty($_GET['search']) 
                            ? "WHERE CONCAT(fname, ' ', lname) LIKE '%" . $connection->real_escape_string($_GET['search']) . "%'" 
                            : "";

                        // SQL query to fetch reservation and guest info
                        $qry = $connection->query("SELECT r.*, g.fname, g.lname 
                            FROM reservations_tb r 
                            JOIN guests_tb g ON r.guest_id = g.guests_id 
                            $searchQuery 
                            ORDER BY r.reservation_status_id ASC, UNIX_TIMESTAMP(r.created_date) DESC 
                            LIMIT $limit OFFSET $offset");

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
                                    case 0:
                                        echo '<span class="rounded-pill badge badge-secondary col-9">Pending</span>';
                                        break;
                                    case 1:
                                        echo '<span class="rounded-pill badge badge-primary col-9" style="color:white;background:green;text-align:center;">Confirmed</span>';
                                        break;
                                    case 2:
                                        echo '<span class="rounded-pill badge badge-danger col-9">Cancelled</span>';
                                        break;
                                    case 3:
                                        echo '<span class="rounded-pill badge badge-success col-9">Completed</span>';
                                        break;
                                }
                            ?>
                        </td>
                        <td align="center">
                            <a href="#" class="text-primary me-2" title="Edit"><i class="fas fa-eye fa-lg"></i></a>
                            <a href="#" class="text-danger" title="Archive"><i class="fas fa-archive fa-lg"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php 
            // Pagination: get total number of matching records
            $totalRecordsQuery = $connection->query("SELECT COUNT(*) AS total FROM reservations_tb r JOIN guests_tb g ON r.guest_id = g.guests_id $searchQuery");
            $totalRecords = $totalRecordsQuery->fetch_assoc()['total'];
            $totalPages = ceil($totalRecords / $limit);
            ?>

            <!-- Pagination Controls -->
            <div class="pagination-container" style="text-align:center; margin-top:20px;">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Page -->
                        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($searchTerm) ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($searchTerm) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Page -->
                        <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($searchTerm) ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
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
    .btn-outline-secondary {
        margin-right: 330px;
        margin-top: 10px;
}
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

.available {
    background-color: #d4edda;
    color: #155724;
}

.calendar-day.disabled {
    color: #bbb;
    cursor: not-allowed;
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

    .search-bar-container {
    position: absolute;
    top: 20px;
    right: 30px;
    width: 30%;
    max-width: 400px;
    z-index: 1000;
}

.search-bar-container .input-group {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    border-radius: 30px;
    overflow: hidden;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    background-color: #fff;
    display: flex;
}

.search-bar-container .input-group:hover {
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
    transform: translateY(-2px);
}

.search-bar-container .form-control {
    border: none;
    border-radius: 0;
    padding-left: 20px;  /* Added padding for the icon */
    font-size: 16px;
    height: 45px;
    flex-grow: 1;
    transition: all 0.3s ease;
}

.search-bar-container .form-control:focus {
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.6);
    border-color: #007bff;
    transform: scale(1.02);
    outline: none;
}

.search-bar-container .form-control:hover {
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}

.input-group-text {
    color: white;
    border: none;
    display: flex;
    align-items: center;
    padding: 0 15px;
    right: 1rem!important;
    transition: background-color 0.3s ease;
    height: 45px;
    position: absolute; /* Position the icon inside the input group */
    right: 10px; /* Move it to the right */
    top: 50%; /* Vertically center the icon */
    transform: translateY(-50%); /* Adjust for perfect vertical centering */
}

.input-group-text i {
    font-size: 18px;
}

.pagination-container {
        margin-top: 20px;
    }

    .pagination .page-item {
        margin: 0 5px;
    }

    .pagination .page-link {
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        padding: 8px 15px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .pagination .page-item.active .page-link {
        background-color: #0056b3;
        color: white;
        border: none;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #e9ecef;
        color: #6c757d;
        pointer-events: none;
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

<!-- Footer of the page -->
<?php include('includes/footer.php'); ?>
