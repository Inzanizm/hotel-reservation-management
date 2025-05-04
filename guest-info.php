<?php include('includes/header.php'); ?>
<?php

// Corrected SQL to fetch guest information
$sql = "
    SELECT 
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
                                        <a href="#" class="text-primary me-2" title="Edit"><i class="fas fa-edit fa-lg"></i></a>
                                        <a href="#" class="text-danger" title="Archive"><i class="fas fa-archive fa-lg"></i></a>
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


            