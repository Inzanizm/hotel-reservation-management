<?php include('includes/header.php'); ?>
<?php
// JOIN guests -> reservations -> payments -> payment_status
$sql = "
    SELECT 
        g.fname,
        g.lname,
        g.email,
        g.contact_number,
        CONCAT(g.fname, ' ', g.lname) AS fullname,
        p.amount_paid,
        p.payment_status_id,
        p.reference_number,
        p.method,
        ps.status_name
    FROM payments_tb p
    LEFT JOIN payment_status_tb ps ON p.payment_status_id = ps.payment_status_id
    LEFT JOIN reservations_tb r ON r.reservation_id = p.reservation_id
    LEFT JOIN guests_tb g ON g.guests_id = r.guest_id
";

$result = $connection->query($sql);
?>
<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Guest Information</h3>
            <a href="#" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Add Guest</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Amount Paid</th>
                            <th>Payment Status</th>
                            <th>Payment Method</th>
                            <th>Reference Number</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['contact_number']) ?></td>
                                    <td>₱<?= number_format($row['amount_paid'], 2) ?></td>
                                    <td>
                                    <?php
                                        $badge = match ((int)$row['payment_status_id']) {
                                            1, 3 => 'success',   // Paid or Refund
                                            2    => 'warning',   // Pending
                                            4    => 'danger',    // Failed
                                            default => 'secondary',
                                        };      
                                    ?>
                                    <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($row['status_name']) ?></span>                    
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['method']) ?>   
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['reference_number']) ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="text-primary me-2" title="Edit"><i class="fas fa-edit fa-lg"></i></a>
                                        <a href="#" class="text-danger" title="Archive"><i class="fas fa-archive fa-lg"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No guest records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
</style>
