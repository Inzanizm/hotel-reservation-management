<?php include('includes/header.php'); ?>
<?php
// JOIN users -> user_roles
$sql = "
    SELECT 
        u.fname,
        u.lname,
        u.email,
        u.contact_number,
        CONCAT(u.fname, ' ', u.lname) AS fullname,
        u.active,
        ur.role_name
    FROM users_tb u
    LEFT JOIN user_roles ur ON u.role_id = ur.role_id
";

$result = $connection->query($sql);
?>
<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">User Information</h3>
            <a href="#" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Add User</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                                    <td><?= htmlspecialchars($row['role_name']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['contact_number']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $row['active'] == 1 ? 'success' : 'secondary' ?>">
                                            <?= $row['active'] == 1 ? 'Active' : 'Not Active' ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="text-primary me-2" title="Edit"><i class="fas fa-edit fa-lg"></i></a>
                                        <a href="#" class="text-danger" title="Archive"><i class="fas fa-archive fa-lg"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No user records found.</td>
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

    .card-title{
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }
</style>
