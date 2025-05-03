<?php include('includes/header.php'); ?>
<?php
// Set the number of records to show per page
$limit = 10;

// Get current page from URL, default is page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for SQL LIMIT
$offset = ($page - 1) * $limit;

$searchTerm = isset($_GET['search']) ? $connection->real_escape_string($_GET['search']) : '';
$searchQuery = $searchTerm 
    ? "WHERE CONCAT(fname, ' ', lname) LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'" 
    : '';

// Corrected SQL to fetch guest information
$sql = "
    SELECT 
        g.fname,
        g.lname,
        g.email,
        g.contact_number,
        CONCAT(g.fname, ' ', g.lname) AS fullname
    FROM guests_tb g
    $searchQuery
";

$result = $connection->query($sql);
?>
<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Guest Information</h3>
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
            <!-- Guest Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
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
                                    <td><span class="badge bg-success">Active</span></td> <!-- Placeholder for status -->
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
</style>

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
                        <!-- hELLO -->
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

            
