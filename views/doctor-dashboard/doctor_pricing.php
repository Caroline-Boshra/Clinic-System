<?php
$pageTitle = 'My Pricing';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <div class="d-flex flex-column gap-3 account-form mx-auto mt-5">
        <?php showmessage(); ?>

        <form class="form" action="index.php?page=doctor_pricing" method="POST">

            <div class="mb-3">
                <label class="form-label required-label" for="major_id">Major</label>
                <select class="form-control" id="major_id" name="major_id">
                    <option value="">Select Major</option>
                    <?php
                    $selected = $_SESSION['old']['major_id'] ?? $details['major_id'] ?? '';
                    foreach ($majors as $major):
                    ?>
                        <option value="<?= (int) $major['id'] ?>" <?= ((string) $selected === (string) $major['id']) ? 'selected' : '' ?>>
                         <?= htmlspecialchars($major['name'], ENT_QUOTES) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php showmessage('error', 'major_id'); ?>
            </div>

            <div class="mb-3">
                <label class="form-label required-label" for="examination_price">Examination Price</label>
                <input type="number" step="0.01" min="0" class="form-control"
                       id="examination_price" name="examination_price"
                       value="<?= htmlspecialchars($_SESSION['old']['examination_price'] ?? $details['examination_price'] ?? '', ENT_QUOTES) ?>">
                <?php showmessage('error', 'examination_price'); ?>
            </div>

            <div class="mb-3">
                <label class="form-label required-label" for="consultation_price">Consultation Price</label>
                <input type="number" step="0.01" min="0" class="form-control"
                       id="consultation_price" name="consultation_price"
                       value="<?= htmlspecialchars($_SESSION['old']['consultation_price'] ?? $details['consultation_price'] ?? '', ENT_QUOTES) ?>">
                <?php showmessage('error', 'consultation_price'); ?>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>