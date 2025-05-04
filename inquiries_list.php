<?php include('includes/header.php'); ?>

<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title mb-0">Email Inquiries</h3>
        </div>
        <div class="card-body">
            <?php
            // SQL query to fetch inquiries and status
            $sql = "
                SELECT 
                    i.inquiry_id,
                    i.sender_name,
                    i.sender_email,
                    i.contact_number,
                    i.inquiry_type,
                    i.message_body,
                    i.received_date,
                    s.status_name,
                    i.status_id
                FROM inquiries_tb i
                LEFT JOIN inquiry_status_tb s ON i.status_id = s.status_id
                ORDER BY i.received_date DESC
            ";
            $result = $connection->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#inquiryDetails<?= $row['inquiry_id'] ?>" aria-expanded="false" aria-controls="inquiryDetails<?= $row['inquiry_id'] ?>">
                            <div class="d-flex align-items-center">
                                <strong><?= htmlspecialchars($row['sender_name']) ?> (<?= htmlspecialchars($row['sender_email']) ?>)</strong>
                                <span class="ms-3 badge bg-<?= $row['status_id'] == 2 ? 'success' : 'warning' ?>">
                                    <?= htmlspecialchars($row['status_name']) ?>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted"><?= date('M d, Y h:i A', strtotime($row['received_date'])) ?></small>
                            </div>
                        </div>
                        <div id="inquiryDetails<?= $row['inquiry_id'] ?>" class="collapse">
                            <div class="card-body">
                                <p><strong>Contact #:</strong> <?= htmlspecialchars($row['contact_number']) ?></p>
                                <p><strong>Type:</strong> <?= htmlspecialchars($row['inquiry_type']) ?></p>
                                <p><strong>Message:</strong><br><?= nl2br(htmlspecialchars($row['message_body'])) ?></p>
                                <div class="d-flex justify-content-end gap-2">
                                    <?php if ($row['status_id'] != 2): ?>
                                        <a href="mark_as_read.php?inquiry_id=<?= $row['inquiry_id'] ?>" class="btn btn-sm btn-success">Mark as Read</a>
                                    <?php endif; ?>
                                    <!-- Trigger for Respond Modal -->
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#respondModal<?= $row['inquiry_id'] ?>">Respond</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Respond -->
                    <div class="modal fade" id="respondModal<?= $row['inquiry_id'] ?>" tabindex="-1" aria-labelledby="respondModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="respondModalLabel">Respond to Inquiry from <?= htmlspecialchars($row['sender_name']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="respond_to_inquiry.php" method="POST">
                                        <input type="hidden" name="inquiry_id" value="<?= $row['inquiry_id'] ?>">
                                        
                                        <!-- Built-in email format with placeholders -->
                                        <div class="mb-3">
                                            <label for="responseMessage" class="form-label">Response Message</label>
                                            <textarea class="form-control" id="responseMessage" name="response_message" rows="10" required>
Hello <?= htmlspecialchars($row['sender_name']) ?>,

Thank you for reaching out! We're happy to assist you. Here's our response:


--------------------
Best regards,
Support Team
                                            </textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Send Response</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No inquiries found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .table td, .table th {
        vertical-align: middle;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-header .d-flex {
        display: flex;
        align-items: center;
    }
    .card-header .ms-3 {
        margin-left: 1rem;
    }

    .text-muted{
        left: 12rem;
        position: relative;
    }
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php include('includes/footer.php'); ?>
