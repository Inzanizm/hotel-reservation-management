<?php include('initialize.php'); ?> 

<?php 
if (isset($_GET['inquiry_id'])) {
    $inquiry_id = intval($_GET['inquiry_id']);

    // Set status_id = 2 (Read)
    $update = $connection->query("
        UPDATE inquiries_tb 
        SET status_id = 2 
        WHERE inquiry_id = $inquiry_id
    ");

    if ($update) {
        header("Location: inquiries_list.php");
        exit;
    } else {
        echo "Error updating status: " . $connection->error;
    }
}
?>
