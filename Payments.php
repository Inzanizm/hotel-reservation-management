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
        p.payment_id,
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
                                            1, 3 => 'success',   // Paid or Refunded
                                            2    => 'warning',   // Pending
                                            4    => 'danger',    // Failed
                                            default => 'secondary'
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
                                        <!-- Button to trigger modal -->
                                        <button type="button"
                                                class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#paymentModal<?= $row['payment_id'] ?>"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="paymentModal<?= $row['payment_id'] ?>" tabindex="-1" aria-labelledby="paymentModalLabel<?= $row['payment_id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <!-- Modal Title with Full Name -->
                                                <h5 class="modal-title" id="paymentModalLabel<?= $row['payment_id'] ?>">
                                                    Update Payment Status for <?= ucwords($row['fullname']) ?>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <!-- Form for Updating Payment -->
                                            <form method="POST" action="edit_payment.php">
                                                <div class="modal-body">
                                                    <!-- Hidden Payment ID -->
                                                    <input type="hidden" name="payment_id" value="<?= $row['payment_id'] ?>">

                                                    <!-- Amount Paid Display -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Amount Paid</label>
                                                        <input type="text" class="form-control" value="₱<?= number_format($row['amount_paid'], 2) ?>" readonly>
                                                    </div>

                                                    <!-- Payment Status Dropdown -->
                                                    <div class="mb-3">
                                                        <label for="paymentStatusSelect<?= $row['payment_id'] ?>" class="form-label">Payment Status</label>
                                                        <select class="form-select" id="paymentStatusSelect<?= $row['payment_id'] ?>" name="payment_status_id" required>
                                                            <option value="1" <?= $row['payment_status_id'] == 1 ? 'selected' : '' ?>>Paid</option>
                                                            <option value="2" <?= $row['payment_status_id'] == 2 ? 'selected' : '' ?>>Pending</option>
                                                            <option value="3" <?= $row['payment_status_id'] == 3 ? 'selected' : '' ?>>Refunded</option>
                                                            <option value="4" <?= $row['payment_status_id'] == 4 ? 'selected' : '' ?>>Failed</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Modal Footer Buttons -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="update_payment" class="btn btn-primary">Update Payment</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
