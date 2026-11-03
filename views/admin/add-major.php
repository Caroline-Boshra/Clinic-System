<?php
$basePath = '';
$pageTitle = 'Add Major';
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
        <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="<?= $basePath ?>index.php?page=home">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Add Major</li>
        </ol>
    </nav>

    <section class="admin-form mx-auto admin-form--compact">
        <div class="admin-form__header">
            <span class="admin-form__icon" aria-hidden="true">+</span>
            <div>
                <h1 class="h3 fw-bold mb-1">Add Major</h1>
                <p class="text-muted mb-0">Create a new medical major</p>
            </div>
        </div>

        <form class="form" action="<?= $basePath ?>index.php?page=add-major" method="POST">
            <div class="form-items">
                <div class="mb-3">
                    <label class="form-label required-label" for="major-name">Major name</label>
                    <input type="text" class="form-control" id="major-name" name="name"
                        placeholder="required" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="major-image">Image URL</label>
                    <input type="url" class="form-control" id="major-image" name="image"
                        placeholder="https://example.com/major.jpg">
                </div>
                <div class="mb-3 form-item--full">
                    <label class="form-label" for="major-description">Description</label>
                    <textarea class="form-control" id="major-description" name="description" rows="5"
                        placeholder="Description"></textarea>
                </div>
            </div>
            <div class="admin-form__actions">
                <a class="btn btn-outline-secondary" href="<?= $basePath ?>index.php?page=majors">Cancel</a>
                <button type="submit" class="btn btn-primary">Add Major</button>
            </div>
        </form>
    </section>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
