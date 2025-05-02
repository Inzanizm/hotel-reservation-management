<?php include('includes/header.php'); ?>

<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title mb-0">Guest Inquiries</h3>
        </div>
        <div class="card-body">
            <?php
            $sql = "
                SELECT 
                    i.inquiry_id,
                    i.sender_name,
                    i.sender_email,
                    i.contact_number,
                    i.inquiry_type,
                    i.message_body,
                    i.is_read,
                    s.status_name,
                    i.received_date
                FROM inquiries_tb i
                LEFT JOIN inquiry_status_tb s ON i.status_id = s.status_id
                ORDER BY i.received_date DESC
            ";
            $result = $connection->query($sql);
            ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact #</th>
                            <th>Type</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['sender_name']) ?></td>
                                    <td><?= htmlspecialchars($row['sender_email']) ?></td>
                                    <td><?= htmlspecialchars($row['contact_number']) ?></td>
                                    <td><?= htmlspecialchars($row['inquiry_type']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($row['message_body'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $row['is_read'] ? 'success' : 'warning' ?>">
                                            <?= $row['is_read'] ? 'Read' : 'Unread' ?>
                                        </span>
                                    </td>
                                    <td><?= date('M d, Y h:i A', strtotime($row['received_date'])) ?></td>
                                    <td class="text-center">
                                        <?php if (!$row['is_read']): ?>
                                            <a href="mark_as_read.php?id=<?= $row['inquiry_id'] ?>" class="btn btn-sm btn-success">Mark as Read</a>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No inquiries found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table td, .table th {
        vertical-align: middle;
    }
</style>