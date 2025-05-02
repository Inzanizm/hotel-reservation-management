<?php
if (isset($_GET['status_id'])) {
    $inquiry_id = intval($_GET['status_id']);

    // Get or insert 'read' status
    $status_check = $connection->query("SELECT status_id FROM inquiry_status_tb WHERE status_name = 'read'");
    if ($status_check->num_rows > 0) {
        $status_id = $status_check->fetch_assoc()['status_id'];
    } else {
        $connection->query("INSERT INTO inquiry_status_tb (status_name) VALUES ('read')");
        $status_id = $connection->insert_id;
    }

    // Update inquiry: set is_read = 1 and status_id = read
    $update = $connection->query("
        UPDATE inquiries_tb 
        SET is_read = 1, status_id = $status_id 
        WHERE inquiry_id = $inquiry_id
    ");

    if ($update) {
        header("Location: inquiries_list.php");
    } else {
        echo "Error updating status: " . $connection->error;
    }
}
?>