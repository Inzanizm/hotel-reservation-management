<?php include('includes/header.php'); 

// Ensure the session is started if not already done
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle delete action
    if (isset($_POST['archive_btn']) && isset($_POST['userid'])) {
        $userId = (int)$_POST['userid'];

        // Delete query
        $deleteSql = "DELETE FROM users_tb WHERE userid = $userId";
        if ($connection->query($deleteSql)) {
            // Log the deletion action
            $operation_name = 'Delete User';
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();

            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();

                // Log the operation in the audit log table
                $user_id = $_SESSION['userid'] ?? null;  // Make sure user is logged in
                if ($user_id) {
                    $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                    $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
            }

            $operation_type_stmt->close();
            echo "<script>alert('User deleted successfully.');window.location.href='user-management.php';</script>";
        } else {
            echo "<script>alert('Error deleting user.');</script>";
        }
    }

    // Handle update action
    elseif (isset($_POST['edit_user'])) {
        $userid = (int)$_POST['userid'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'] ?? null; // Allow NULL
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $contact_number = (int)$_POST['contact_number'];
        $role_id = (int)$_POST['role_id'];
        $active = (int)$_POST['active'];

        // Update query
        $stmt = $connection->prepare("
            UPDATE users_tb 
            SET fname = ?, mname = ?, lname = ?, email = ?, contact_number = ?, role_id = ?, active = ? 
            WHERE userid = ?
        ");
        $stmt->bind_param("ssssiiii", $fname, $mname, $lname, $email, $contact_number, $role_id, $active, $userid);

        if ($stmt->execute()) {
            // Log the update action
            $operation_name = 'Update User Details';
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();

            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();

                // Log the operation in the audit log table
                $user_id = $_SESSION['userid'] ?? null;  // Ensure user is logged in
                if ($user_id) {
                    $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                    $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
            }

            $operation_type_stmt->close();
            echo "<script>alert('User updated successfully.');location.href='user-management.php';</script>";
        } else {
            echo "<script>alert('Error updating user.');</script>";
        }
        $stmt->close();
    }
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['add_user'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $role_id = $_POST['role_id'];
    $active = $_POST['active'];
    $password_raw = $_POST['password'];
    $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

    $user_id = $_SESSION['userid'] ?? null;

    if (!$user_id) {
        echo "<script>alert('User session not found. Please log in again.');</script>";
        exit();
    }

    $check_stmt = $connection->prepare("SELECT userid FROM users_tb WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use another.');</script>";
    } else {
        $stmt = $connection->prepare("INSERT INTO users_tb (fname, mname, lname, email, contact_number, role_id, active, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssiis", $fname, $mname, $lname, $email, $contact_number, $role_id, $active, $password_hashed);

        if ($stmt->execute()) {
            $operation_name = 'Add User';
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();

            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();

                $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
                $log_stmt->execute();
                $log_stmt->close();
            }

            $operation_type_stmt->close(); // ✅ Safe to call here
            echo "<script>location.href = location.href;</script>";
        } else {
            echo "<script>alert('Error adding user: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    $check_stmt->close();
}


// JOIN users -> user_roles
$sql = "SELECT u.userid, u.fname, u.lname, u.email, u.contact_number, CONCAT(u.fname, ' ', u.lname) AS fullname, u.active, ur.role_name FROM users_tb u LEFT JOIN user_roles ur ON u.role_id = ur.role_id";


$result = $connection->query($sql);
?>
<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">User Information</h3>
            <div class="add-user-button">
                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-bordered table-striped align-middle">
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
                                        <a href="#" class="text-primary me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editUser(<?= $row['userid'] ?>)"><i class="fas fa-edit fa-lg"></i></a>
                                        <form method="post" action="" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="userid" value="<?= $row['userid'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" name="archive_btn" title="Delete User">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                        </form>
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

                <!-- Add User Modal -->
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" action="">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="fname" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" name="mname">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="lname" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Contact Number</label>
                                        <input type="number" class="form-control" name="contact_number" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Role</label>
                                        <select name="role_id" class="form-select" required>
                                            <?php
                                            $roles = $connection->query("SELECT role_id, role_name FROM user_roles");
                                            while ($r = $roles->fetch_assoc()):
                                            ?>
                                                <option value="<?= $r['role_id'] ?>"><?= $r['role_name'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Status</label>
                                        <select name="active" class="form-select">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Not Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- Cancel Button -->
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" name="add_user" class="btn btn-primary">Save User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Add User Modal -->  
                 
                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" action="">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="editUserId" name="userid">
                                    <div class="mb-2">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="fname" id="editFname" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" name="mname" id="editMname">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="lname" id="editLname" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="editEmail" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Contact Number</label>
                                        <input type="number" class="form-control" name="contact_number" id="editContactNumber" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Role</label>
                                        <select name="role_id" class="form-select" id="editRoleId" required>
                                            <?php
                                            $roles = $connection->query("SELECT role_id, role_name FROM user_roles");
                                            while ($r = $roles->fetch_assoc()):
                                            ?>
                                                <option value="<?= $r['role_id'] ?>"><?= $r['role_name'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Status</label>
                                        <select name="active" class="form-select" id="editActive" required>
                                            <option value="1">Active</option>
                                            <option value="0">Not Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" name="edit_user" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Edit User Modal -->
                <script>
function editUser(userid) {
    fetch('get_user.php?id=' + userid)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            // Populate modal fields with fetched user data
            document.getElementById('editUserId').value = data.userid;
            document.getElementById('editFname').value = data.fname;
            document.getElementById('editMname').value = data.mname;
            document.getElementById('editLname').value = data.lname;
            document.getElementById('editEmail').value = data.email;
            document.getElementById('editContactNumber').value = data.contact_number;
            document.getElementById('editRoleId').value = data.role_id;
            document.getElementById('editActive').value = data.active;
        })
        .catch(error => {
            alert('Error fetching user data: ' + error.message);
        });
}

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
        $('#usersTable').DataTable({
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

