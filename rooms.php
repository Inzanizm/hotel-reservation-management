<?php include('includes/header.php'); ?>
<?php
// Query to get rooms with optional promo price
$sql = "
    SELECT 
        r.room_number,
        rt.room_name,
        s.status_name,
        rt.base_price,
        IFNULL(CONCAT('₱', FORMAT(rt.base_price - p.discount_percent, 2)), 'N/A') AS seasonal_price,
        r.description
    FROM rooms_tb r
    LEFT JOIN room_type_tb rt ON r.room_type_id = rt.room_type_id
    LEFT JOIN room_status_tb s ON r.room_status_id = s.room_status_id
    LEFT JOIN promo_codes_tb p ON r.promo_code_id = p.promo_code_id
";

$result = $connection->query($sql);
?>
<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Room Management</h3>
            <a href="#" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Add Room</a>
        </div>
        <div class="card-body">
            <!-- Room Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Room Number</th>
                            <th>Room Type</th>
                            <th>Status</th>
                            <th>Base Price</th>
                            <th>Seasonal Price</th>
                            <th>Description</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['room_number']) ?></td>
                                    <td><?= htmlspecialchars($row['room_name']) ?></td>
                                    <td>
                                        <?php
                                            $badge = 'secondary';
                                            if ($row['status_name'] == 'Available') $badge = 'success';
                                            elseif ($row['status_name'] == 'Reserved') $badge = 'warning';
                                            echo "<span class='badge bg-$badge'>{$row['status_name']}</span>";
                                        ?>
                                    </td>
                                    <td>₱<?= number_format($row['base_price'], 2) ?></td>
                                    <td><?= $row['seasonal_price'] ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td class="text-center">
                                        <a href="#" class="text-primary me-2" title="Edit"><i class="fas fa-edit fa-lg"></i></a>
                                        <a href="#" class="text-danger" title="Archive"><i class="fas fa-archive fa-lg"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No rooms found.</td>
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