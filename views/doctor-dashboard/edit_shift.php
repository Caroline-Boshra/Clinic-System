<?php
/** @var array $shift */
/** @var array $old */
$basePath = '';
$pageTitle = 'Edit Shift';
require_once __DIR__ . '/../layouts/header.php';

$old   = $old ?? [];
$shift = $shift ?? [];

$currentDay   = ($old['day_of_week'] ?? '') ?: ($shift['day_of_week'] ?? '');
$currentStart = ($old['start_time'] ?? '') ?: substr($shift['start_time'] ?? '', 0, 5);
$currentEnd   = ($old['end_time'] ?? '') ?: substr($shift['end_time'] ?? '', 0, 5);
$shiftId      = (int)($shift['id'] ?? 0);
?>

<div class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
        <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="<?= $basePath ?>index.php?page=home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Shift</li>
        </ol>
    </nav>

    <div class="d-flex flex-column gap-3 account-form mx-auto mt-5">
        <?php showmessage(); ?>

        <form class="form" action="index.php?page=edit_shift&shift_id=<?= $shiftId ?>" method="POST">
            <input type="hidden" name="shift_id" value="<?= $shiftId ?>">

            <div class="form-items">
                <div class="mb-3">
                    <label class="form-label required-label" for="day_of_week">Day of Week</label>
                    <select class="form-control" id="day_of_week" name="day_of_week">
                        <option value="">Select Day</option>
                        <?php
                        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                        foreach ($days as $day) {
                            $selected = (strcasecmp(trim((string)$currentDay), $day) === 0) ? 'selected' : '';
                            echo "<option value=\"$day\" $selected>$day</option>";
                        }
                        ?>
                    </select>
                    <?php showmessage('error', 'day_of_week'); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label required-label" for="start_time">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time"
                           value="<?= htmlspecialchars($currentStart, ENT_QUOTES) ?>">
                    <?php showmessage('error', 'start_time'); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label required-label" for="end_time">End Time</label>
                    <input type="time" class="form-control" id="end_time" name="end_time"
                           value="<?= htmlspecialchars($currentEnd, ENT_QUOTES) ?>">
                    <?php showmessage('error', 'end_time'); ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Shift</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>