<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
        <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="<?= $basePath ?>index.php?page=home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Login</li>
        </ol>
    </nav>
    <div class="d-flex flex-column gap-3 account-form mx-auto mt-5">
        <?php showmessage(); ?>
        <?php showmessage('error', 'login'); ?>
        <form class="form" action="index.php?page=login" method="POST">
            <div class="mb-3">
                <label class="form-label required-label" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <?php showmessage('error', 'email'); ?>
            </div>
            <div class="mb-3">
                <label class="form-label required-label" for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <?php showmessage('error', 'password'); ?>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="d-flex justify-content-center gap-2 flex-column flex-lg-row flex-md-row flex-sm-column">
            <span>Don't have an account?</span><a class="link" href="<?= $basePath ?>index.php?page=register">Create account</a>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
