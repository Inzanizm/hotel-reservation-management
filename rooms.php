<?php include('includes/header.php'); ?>

<?php
$searchTerm = isset($_GET['search']) ? $connection->real_escape_string($_GET['search']) : '';
$searchQuery = $searchTerm ? "WHERE rt.room_name LIKE '%$searchTerm%'" : '';

// Fetch room status options
$statusOptions = $connection->query("SELECT room_status_id, status_name FROM room_status_tb");

// Fetch room type options
$typeOptions = $connection->query("SELECT room_type_id, room_name FROM room_type_tb");

// Main room data query
$sql = "
    SELECT 
        r.room_id,
        r.room_number,
        rt.room_name,
        s.status_name,
        s.room_status_id,
        rt.base_price,
        IFNULL(CONCAT('₱', FORMAT(rt.base_price - p.discount_percent, 2)), 'N/A') AS seasonal_price,
        r.descriptions
    FROM rooms_tb r
    LEFT JOIN room_type_tb rt ON r.room_type_id = rt.room_type_id
    LEFT JOIN room_status_tb s ON r.room_status_id = s.room_status_id
    LEFT JOIN promo_codes_tb p ON r.promo_code_id = p.promo_code_id
    $searchQuery
";

$result = $connection->query($sql);

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete
    if (isset($_POST['delete_room_btn']) && isset($_POST['room_id'])) {
        $roomId = (int)$_POST['room_id'];
        $deleteSql = "DELETE FROM rooms_tb WHERE room_id = $roomId";
<<<<<<< HEAD
        if ($connection->query($deleteSql)) {
            echo "<script>alert('Room deleted successfully.');window.location.href='rooms.php';</script>";
        } else {
            echo "<script>alert('Error deleting room.');</script>";
        }
    }
    // Edit
    // Edit Room Status
    elseif (isset($_POST['edit_room'])) {
        $roomId = (int)$_POST['room_id'];
        $statusId = (int)$_POST['room_status_id'];

        $stmt = $connection->prepare("UPDATE rooms_tb SET room_status_id = ? WHERE room_id = ?");
        $stmt->bind_param("ii", $statusId, $roomId);

        if ($stmt->execute()) {
            // Audit Logging
            $operation_name = 'Update Room Details';
=======
    
        if ($connection->query($deleteSql)) {
            // Audit Logging
            $operation_name = 'Delete Room';
>>>>>>> 1822f4082b682e1570b338700bd39c929d099571
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();
<<<<<<< HEAD

            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();

=======
    
            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();
    
>>>>>>> 1822f4082b682e1570b338700bd39c929d099571
                $user_id = $_SESSION['userid'] ?? null;  // Ensure session user ID is available
                if ($user_id) {
                    $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                    $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
            }
<<<<<<< HEAD

            $operation_type_stmt->close();
            echo "<script>alert('Room status updated successfully.');window.location.href='rooms.php';</script>";
        } else {
            echo "<script>alert('Error updating room.');</script>";
        }

        $stmt->close();
    }
    // Add
    elseif (isset($_POST['add_room'])) {
        $roomNumber = $_POST['room_number'];
        $roomTypeId = (int)$_POST['room_type_id'];
        $statusId = (int)$_POST['room_status_id'];
        $descriptions = $_POST['descriptions'];

        $stmt = $connection->prepare("
            INSERT INTO rooms_tb (room_number, room_type_id, room_status_id, descriptions)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("siis", $roomNumber, $roomTypeId, $statusId, $descriptions);

        if ($stmt->execute()) {
            echo "<script>alert('Room added successfully.');window.location.href='rooms.php';</script>";
        } else {
            echo "<script>alert('Error adding room.');</script>";
        }
    }
=======
    
            $operation_type_stmt->close();
            echo "<script>alert('Room deleted successfully.');window.location.href='rooms.php';</script>";
        } else {
            echo "<script>alert('Error deleting room.');</script>";
        }
    }
    
    // Edit Room Status
    elseif (isset($_POST['edit_room'])) {
        $roomId = (int)$_POST['room_id'];
        $statusId = (int)$_POST['room_status_id'];

        $stmt = $connection->prepare("UPDATE rooms_tb SET room_status_id = ? WHERE room_id = ?");
        $stmt->bind_param("ii", $statusId, $roomId);

        if ($stmt->execute()) {
            // Audit Logging
            $operation_name = 'Update Room Details';
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();

            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();

                $user_id = $_SESSION['userid'] ?? null;  // Ensure session user ID is available
                if ($user_id) {
                    $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                    $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
            }

            $operation_type_stmt->close();
            echo "<script>alert('Room status updated successfully.');window.location.href='rooms.php';</script>";
        } else {
            echo "<script>alert('Error updating room.');</script>";
        }

        $stmt->close();
    }

    // Add
    elseif (isset($_POST['add_room'])) {
        $roomNumber = $_POST['room_number'];
        $roomTypeId = (int)$_POST['room_type_id'];
        $statusId = (int)$_POST['room_status_id'];
        $descriptions = $_POST['descriptions'];
    
        $stmt = $connection->prepare("
            INSERT INTO rooms_tb (room_number, room_type_id, room_status_id, descriptions)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("siis", $roomNumber, $roomTypeId, $statusId, $descriptions);
    
        if ($stmt->execute()) {
            // Audit Logging
            $operation_name = 'Add Room';
            $operation_type_stmt = $connection->prepare("SELECT operation_type_id FROM operation_type_tb WHERE operation_name = ?");
            $operation_type_stmt->bind_param("s", $operation_name);
            $operation_type_stmt->execute();
            $operation_type_res = $operation_type_stmt->get_result();
    
            if ($operation_type_res->num_rows > 0) {
                $operation_type = $operation_type_res->fetch_assoc();
    
                $user_id = $_SESSION['userid'] ?? null;  // Make sure the user is logged in
                if ($user_id) {
                    $log_stmt = $connection->prepare("INSERT INTO audit_log_tb (user_id, operation_type_id, timestamp) VALUES (?, ?, NOW())");
                    $log_stmt->bind_param("ii", $user_id, $operation_type['operation_type_id']);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
            }
    
            $operation_type_stmt->close();
            echo "<script>alert('Room added successfully.');window.location.href='rooms.php';</script>";
        } else {
            echo "<script>alert('Error adding room.');</script>";
        }
    }    
>>>>>>> 1822f4082b682e1570b338700bd39c929d099571
}
?>

<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Room Management</h3>
            <div class="add-room-button">
                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addRoomModal"><i class="fas fa-plus"></i> Add Room</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="roomsTable" class="table table-bordered table-striped align-middle">
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
                                    <td><?= htmlspecialchars($row['descriptions']) ?></td>
                                    <td class="text-center">
                                        <a href="#" class="text-primary me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editRoomModal" onclick='setEditRoomData(<?= json_encode($row) ?>)'>
                                            <i class="fas fa-edit fa-lg"></i>
                                        </a>
<<<<<<< HEAD
                                        <form method="post" class="d-inline" onsubmit="return confirm('Are you sure?');">
=======
                                        <form method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this?');">
>>>>>>> 1822f4082b682e1570b338700bd39c929d099571
                                            <input type="hidden" name="room_id" value="<?= $row['room_id'] ?>">
                                            <button type="submit" name="delete_room_btn" class="btn btn-sm btn-danger"><i class="fas fa-archive"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">No rooms found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <form method="POST">
              <div class="modal-header">
                  <h5 class="modal-title">Add New Room</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-2">
                      <label class="form-label">Room Number</label>
                      <input type="text" class="form-control" name="room_number" required>
                  </div>
                  <div class="mb-2">
                      <label class="form-label">Room Type</label>
                      <select name="room_type_id" class="form-select" required>
                          <?php while ($type = $typeOptions->fetch_assoc()): ?>
                              <option value="<?= $type['room_type_id'] ?>"><?= $type['room_name'] ?></option>
                          <?php endwhile; ?>
                      </select>
                  </div>
                  <div class="mb-2">
                      <label class="form-label">Status</label>
                      <select name="room_status_id" class="form-select" required>
                          <?php while ($status = $statusOptions->fetch_assoc()): ?>
                              <option value="<?= $status['room_status_id'] ?>"><?= $status['status_name'] ?></option>
                          <?php endwhile; ?>
                      </select>
                  </div>
                  <div class="mb-2">
                      <label class="form-label">Description</label>
                      <textarea name="descriptions" class="form-control" rows="3"></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" name="add_room" class="btn btn-primary">Add Room</button>
              </div>
          </form>
      </div>
  </div>
</div>

<!-- Edit Room Modal -->
<div class="modal fade" id="editRoomModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Room Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="room_id" id="editRoomId">
          <div class="mb-3">
            <label class="form-label">Room Number</label>
            <input type="text" class="form-control" id="editRoomNumber" disabled>
          </div>
          <div class="mb-3">
            <label class="form-label">Room Type</label>
            <input type="text" class="form-control" id="editRoomType" disabled>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" id="editDescriptions" rows="3" disabled></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Room Status</label>
            <select name="room_status_id" id="editRoomStatusId" class="form-select" required>
              <?php
              $statusResult = $connection->query("SELECT room_status_id, status_name FROM room_status_tb");
              while ($status = $statusResult->fetch_assoc()) {
                  echo "<option value='{$status['room_status_id']}'>{$status['status_name']}</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="edit_room" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- JavaScript for modal editing -->
<script>
function setEditRoomData(data) {
    document.getElementById('editRoomId').value = data.room_id;
    document.getElementById('editRoomNumber').value = data.room_number;
    document.getElementById('editRoomType').value = data.room_name;
    document.getElementById('editDescriptions').value = data.descriptions;
    document.getElementById('editRoomStatusId').value = data.room_status_id;
}
</script>
<<<<<<< HEAD

<style>
.table td, .table th { vertical-align: middle; }
a.text-primary:hover, a.text-danger:hover { opacity: 0.7; transition: 0.2s ease; }
.card-title { font-size: 1.5rem; font-weight: bold; color: #007bff; }
.add-room-button { padding-top: 10px; left: 340px; position: relative; }
</style>
=======

<style>
.table td, .table th { vertical-align: middle; }
a.text-primary:hover, a.text-danger:hover { opacity: 0.7; transition: 0.2s ease; }
.card-title { font-size: 1.5rem; font-weight: bold; color: #007bff; }
.add-room-button { padding-top: 10px; left: 340px; position: relative; }
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
        $('#roomsTable').DataTable({
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
>>>>>>> 1822f4082b682e1570b338700bd39c929d099571

<?php include('includes/footer.php'); ?>
