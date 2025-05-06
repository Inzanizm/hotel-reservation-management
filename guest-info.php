<?php include('includes/header.php'); ?>
<?php

// Handle Delete (Archive) Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['archive_btn'])) {
    $archiveId = intval($_POST['archive_id']);

    // Check if the guest exists (optional but good practice)
    $check_stmt = $connection->prepare("SELECT guests_id FROM guests_tb WHERE guests_id = ?");
    $check_stmt->bind_param("i", $archiveId);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Proceed with deletion
        $deleteSql = "DELETE FROM guests_tb WHERE guests_id = ?";
        $delete_stmt = $connection->prepare($deleteSql);
        $delete_stmt->bind_param("i", $archiveId);

        if ($delete_stmt->execute()) {
            // Get operation type ID for 'Delete Guest'
            $operation_name = 'Delete Guest Information';
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();

            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();

                // Insert into audit log
                $user_id = $_SESSION['userid'] ?? null;
                if ($user_id) {
                    $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                    $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
            }

            $operation_type_stmt->close();

            // Redirect with success message
            echo "<script>alert('Guest deleted successfully.'); window.location.href='guest-info.php';</script>";
        } else {
            echo "<script>alert('Error deleting guest.');</script>";
        }

        $delete_stmt->close();
    } else {
        echo "<script>alert('Guest not found.'); window.location.href='guest-info.php';</script>";
    }

    $check_stmt->close();
}

// Corrected SQL to fetch guest information
$sql = "
    SELECT 
        g.guests_id,
        g.fname,
        g.lname,
        g.email,
        g.contact_number,
        CONCAT(g.fname, ' ', g.lname) AS fullname,
        CASE 
            WHEN CURDATE() BETWEEN r.check_in_date AND r.check_out_date THEN 'Active'
            ELSE 'Not Active'
        END AS status
    FROM guests_tb g
    LEFT JOIN (
    SELECT * FROM reservations_tb
    WHERE CURDATE() BETWEEN check_in_date AND check_out_date
) r ON g.guests_id = r.guest_id";

$result = $connection->query($sql);
?>
<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Guest Information</h3>
        </div>
        <div class="card-body">
            <!-- Guest Table -->
            <div class="table-responsive">
                <table id="guestTable" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['contact_number']) ?></td>
                                    <td>
                                       <?php if ($row['status'] === 'Active'): ?>
                                       <span class="badge bg-success">Active</span>
                                       <?php else: ?>
                                       <span class="badge bg-secondary">Not Active</span>
                                        <?php endif; ?>
                                    </td> <!-- Placeholder for status -->
                                    <td class="text-center">
                                    <!-- Archive Button -->
                                    <form method="post" action="" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this guest?');">
                                    <input type="hidden" name="archive_id" value="<?= $row['guests_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" name="archive_btn" title="Archive">
                                    <i class="fas fa-archive"></i>
                                    </button>
                                    </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No guest records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <script>
                    $(document).ready(function () {
                        $('#guestTable').DataTable({
                            paging: true,         // Enable pagination
                            lengthChange: true,   // Allow changing the number of records per page
                            searching: true,      // Enable live search
                            ordering: true,       // Enable column sorting
                            info: true,           // Show info (like number of records)
                            autoWidth: false,      // Auto calculate column widths
                            responsive: false,     // Make the table responsive
                            pageLength: 10,       // Set number of records per page
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<!-- Optional CSS -->
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    a.text-primary:hover, a.text-danger:hover {
        opacity: 0.7;
        transition: 0.2s ease;
    }

.card-title{
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }
</style>

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
            