<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
        <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="<?= $basePath ?>index.php?page=home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Register</li>
        </ol>
    </nav>
    <div class="d-flex flex-column gap-3 account-form mx-auto mt-5">
        <?php showmessage(); ?>
        <?php showmessage('error'); ?>
        <form class="form" action="index.php?page=register" method="POST">
            <div class="form-items">
                <div class="mb-3">
                    <label class="form-label required-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '', ENT_QUOTES) ?>">
                    <?php showmessage('error', 'name'); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="phone">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '', ENT_QUOTES) ?>">
                    <?php showmessage('error', 'phone'); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '', ENT_QUOTES) ?>">
                    <?php showmessage('error', 'email'); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <?php showmessage('error', 'password'); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <?php showmessage('error', 'confirm_password'); ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create account</button>
        </form>
        <div class="d-flex justify-content-center gap-2">
            <span>Already have an account?</span><a class="link" href="<?= $basePath ?>index.php?page=login">Login</a>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
