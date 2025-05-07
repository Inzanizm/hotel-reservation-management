<?php include('includes/header.php'); ?>

<?php

// Get current page from URL, default is page 1


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['archive_btn'])) {
    $reservationId = intval($_POST['reservation_id']);
    $deleteSql = "DELETE FROM reservations_tb WHERE reservation_id = $reservationId";
    if ($connection->query($deleteSql)) {
        echo "<script>alert('Reservation delete successfully.');window.location.href='reservation.php' </script>";
    } else {
        echo "<script>alert('Error delete reservation.');</script>";
    }
}

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
                        <th>Guest Name</th> <!-- Should this be 'Guest Name'? -->
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
                                     <input type="hidden" name="editreservation_id" value="<?= $row['reservation_id'] ?>">
                                       <button type="button" class="btn btn-sm btn-primary" title="Edit" data-bs-toggle="modal" data-bs-target="#respondModal<?= $row['reservation_id'] ?>">
                                    <i class="fas fa-edit"></i>
                                     </button>

                                    <!-- Archive Button -->
                                    <form method="post" action="" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                    <input type="hidden" name="reservation_id" value="<?= $row['reservation_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" name="archive_btn" title="Archive">
                                    <i class="fas fa-archive"></i>
                                    </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="respondModal<?= $row['reservation_id'] ?>" tabindex="-1" aria-labelledby="respondModalLabel<?= $row['reservation_id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- Show Full Name in Modal Title -->
                                    <h5 class="modal-title" id="respondModalLabel<?= $row['reservation_id'] ?>">
                                        Update Status for <?= ucwords($row['fname'] . ' ' . $row['lname']) ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="edit_reservation.php">
                                    <div class="modal-body">
                                        <!-- Hidden ID -->
                                        <input type="hidden" name="reservation_id" value="<?= $row['reservation_id'] ?>">

                                        <!-- Dropdown to Change Reservation Status -->
                                        <div class="mb-3">
                                            <label for="statusSelect<?= $row['reservation_id'] ?>" class="form-label">Reservation Status</label>
                                            <select class="form-select" id="statusSelect<?= $row['reservation_id'] ?>" name="reservation_status_id" required>
                                                <option value="1" <?= $row['reservation_status_id'] == 1 ? 'selected' : '' ?>>Completed</option>
                                                <option value="2" <?= $row['reservation_status_id'] == 2 ? 'selected' : '' ?>>Pending</option>
                                                <option value="3" <?= $row['reservation_status_id'] == 3 ? 'selected' : '' ?>>Confirmed</option>
                                                <option value="4" <?= $row['reservation_status_id'] == 4 ? 'selected' : '' ?>>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Modal Footer Buttons -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
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

<!--Calendar-->

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

<!-- Initialize DataTables -->
<script>
    $(document).ready(function () {
        $('#reservationsTable').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            pageLength: 10,
        });
    });
</script>

<!-- Footer of the page -->
<?php include('includes/footer.php'); ?>
