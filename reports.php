<?php include('includes/header.php'); ?>

<?php
$sql = "
SELECT 
    al.log_id,
    CONCAT(u.fname, ' ', COALESCE(u.mname, ''), ' ', u.lname) AS full_name,
    ot.operation_name,
    ot.description,
    al.timestamp
FROM audit_log_tb al
JOIN operation_type_tb ot ON al.operation_type_id = ot.operation_type_id
JOIN users_tb u ON al.user_id = u.userid
ORDER BY al.timestamp DESC
";

$result = $connection->query($sql);
?>

<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Reports</h3>
        </div>
        <div class="card-body">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <div class="table-responsive">
                    <table id="reportsTable" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Activity</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td><?= htmlspecialchars($row['timestamp']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">No activity logs found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Optional CSS -->
<style>
    .table td, .table thead {
        vertical-align: middle;
    }
    a.text-primary:hover, a.text-danger:hover {
        opacity: 0.7;
        transition: 0.2s ease;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }
    .add-user-button {
        padding-top: 3px;
        left: 357px;
        position: relative;
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

<!-- Initialize DataTables -->
<script>
    $(document).ready(function () {
        $('#reportsTable').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: ['copy', 'pdf', 'print']
        });
    });
</script>
