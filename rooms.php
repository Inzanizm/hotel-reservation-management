<?php include('includes/header.php'); ?>
<?php
$searchTerm = isset($_GET['search']) ? $connection->real_escape_string($_GET['search']) : '';
$searchQuery = $searchTerm ? "WHERE rt.room_name LIKE '%$searchTerm%'" : '';

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
    $searchQuery
";

$result = $connection->query($sql);
?>
<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Room Management</h3>
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
                        placeholder="Search by Room Name"
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
                    >
                    <span class="input-group-text">
                        <i class="fa fa-search"></i>
                    </span>
                </form>
            </div>
            <div class="add-room-button">
                <a href="#" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Add Room</a>
            </div>
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

    .search-bar-container {
    position: absolute;
    top: 20px;
    right: 150px;
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

.add-room-button{
    padding-top: 10px;
}

.btn-outline-secondary {
        margin-right: 150px;
        margin-top: 10px;
}
</style>