<?php
$basePath = '';
$pageTitle = 'Create Shift';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
        <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="<?= $basePath ?>index.php?page=home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Shift</li>
        </ol>
    </nav>
    <div class="d-flex flex-column gap-3 account-form mx-auto mt-5">
        <?php showmessage(); ?>
        
        <form class="form" action="index.php?page=create_shift" method="POST">
            <div class="form-items">
                <div class="mb-3">
                    <label class="form-label required-label" for="day_of_week">Day of Week</label>
                    <select class="form-control" id="day_of_week" name="day_of_week" >
                        <option value="">Select Day</option>
                        <?php 
                        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                        $oldDay = $_SESSION['old']['day_of_week'] ?? '';
                        foreach ($days as $day) {
                            $selected = ($oldDay === $day) ? 'selected' : '';
                            echo "<option value=\"$day\" $selected>$day</option>";
                        }
                        ?>
                    </select>
                    <?php showmessage('error', 'day_of_week'); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label required-label" for="start_time">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time"  
                           value="<?= htmlspecialchars($_SESSION['old']['start_time'] ?? '', ENT_QUOTES) ?>">
                    <?php showmessage('error', 'start_time'); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label required-label" for="end_time">End Time</label>
                    <input type="time" class="form-control" id="end_time" name="end_time"  
                           value="<?= htmlspecialchars($_SESSION['old']['end_time'] ?? '', ENT_QUOTES) ?>">
                    <?php showmessage('error', 'end_time'); ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add Shift</button>
        </form>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>


</div>