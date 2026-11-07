<?php
$basePath = '';
$pageTitle = 'All Messages';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Messages</h2>
    </div>

    
    <?php showmessage(); ?>
    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Message</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Subject</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $index => $message): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($message['name']) ?></td>
                        <td><?= htmlspecialchars($message['message']) ?></td>
                        <td><?= htmlspecialchars($message['email']) ?></td>
                        <td><?= htmlspecialchars($message['phone']) ?></td>
                        <td><?= htmlspecialchars($message['subject']) ?></td>
                        <td><?= date('Y-m-d H:i:s', strtotime($message['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-muted">No messages found.</td>
                </tr>
            <?php endif; ?>
           
        </tbody>
    </table>

    <div class="mt-3 text-center">
        <a href="index.php?page=home" class="btn btn-secondary">Back to Home</a>
    </div>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>