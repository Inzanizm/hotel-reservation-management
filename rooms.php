<?php include('includes/header.php'); ?>
<?php

$searchTerm = isset($_GET['search']) ? $connection->real_escape_string($_GET['search']) : '';
$searchQuery = $searchTerm ? "WHERE rt.room_name LIKE '%$searchTerm%'" : '';

// Query to get rooms with optional promo price
$sql = "
    SELECT 
        r.room_id,
        r.room_number,
        rt.room_name,
        s.status_name,
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Handle room deletion
  if (isset($_POST['delete_room_btn']) && isset($_POST['room_id'])) {
      $roomId = (int)$_POST['room_id'];
      $deleteSql = "DELETE FROM rooms_tb WHERE room_id = $roomId";
      if ($connection->query($deleteSql)) {
          echo "<script>alert('Room deleted successfully.');window.location.href='rooms.php';</script>";
      } else {
          echo "<script>alert('Error deleting room.');</script>";
      }
  }

  // Handle room update
  elseif (isset($_POST['edit_room'])) {
    $roomId = (int)$_POST['room_id'];
    $statusId = (int)$_POST['room_status_id'];

    $stmt = $connection->prepare("UPDATE rooms_tb SET room_status_id = ? WHERE room_id = ?");
    $stmt->bind_param("ii", $statusId, $roomId);

    if ($stmt->execute()) {
        echo "<script>alert('Room status updated successfully.');location.href='rooms.php';</script>";
    } else {
        echo "<script>alert('Error updating room status.');</script>";
    }
  }
}

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

?>
<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Room Management</h3>
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
                                    <td><?= htmlspecialchars($row['descriptions']) ?></td>
                                    <td class="text-center">
                                    <a href="#" class="text-primary me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editRoom(<?= $row['room_id'] ?>)">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <form method="post" action="" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                        <input type="hidden" name="room_id" value="<?= $row['room_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" name="room_btn" title="Archive">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                      <div class="modal-content">
                                          <form method="POST" action="">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="mb-2">
                                                      <label class="form-label">Room Number</label>
                                                      <input type="text" class="form-control" name="room_number" required>
                                                  </div>
                                                  <div class="mb-2">
                                                      <label class="form-label">Room Type</label>
                                                      <input type="text" class="form-control" name="room_type" required>
                                                  </div>
                                                  <div class="mb-2">
                                                      <label class="form-label">Base Price</label>
                                                      <input type="number" class="form-control" name="base_price" required>
                                                  </div>
                                                  <div class="mb-2">
                                                      <label class="form-label">Status</label>
                                                      <select name="status" class="form-select" required>
                                                          <option value="1" selected>Available</option>
                                                          <option value="0">Not Available</option>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                  <button type="submit" name="add_room" class="btn btn-primary">Save Room</button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                              <!-- End of Add Room Modal -->

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
                                          <select class="form-select" name="room_status_id" id="editRoomStatusId" required>
                                            <!-- Populate with PHP or JS -->
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
<!-- End of Edit Room Modal -->
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

    .card-title{
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }

.add-room-button{
    padding-top: 10px;
    left: 340px;
    position: relative;
}

.btn-outline-secondary {
        margin-right: 150px;
        margin-top: 10px;
}
</style>
<script>
function editRoom(roomId) {
    fetch('get-room.php?id=' + roomId)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editRoomId').value = data.room_id;
            document.getElementById('editRoomNumber').value = data.room_number;
            document.getElementById('editRoomType').value = data.room_type_name; // This must be returned by PHP
            document.getElementById('editDescriptions').value = data.descriptions;
            document.getElementById('editRoomStatusId').value = data.room_status_id;

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('editRoomModal'));
            modal.show();
        })
        .catch(error => {
            alert('Failed to fetch room data: ' + error.message);
        });
}
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php include('includes/footer.php'); ?>