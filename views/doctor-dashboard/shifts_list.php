<?php
$basePath = '';
$pageTitle = 'My Shifts';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Working Shifts</h2>
        <a href="index.php?page=create_shift" class="btn btn-primary">Add New Shift</a>
    </div>

    
    <?php showmessage(); ?>
    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Day of Week</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($shifts)): ?>
                <?php foreach ($shifts as $index => $shift): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($shift['day_of_week']) ?></td>
                        <td><?= date('h:i A', strtotime($shift['start_time'])) ?></td>
                        <td><?= date('h:i A', strtotime($shift['end_time'])) ?></td>
                        <td>
                            <a href="index.php?page=edit_shift&shift_id=<?= (int)$shift['id'] ?>" class="btn btn-sm btn-primary">Edit</a> 
                            <form action="index.php?page=delete_shift" method="post">
                                <input type="hidden" name="shift_id" value="<?= $shift['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" >Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-muted">No shifts added yet.</td>
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