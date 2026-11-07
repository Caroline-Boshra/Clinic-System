<?php
$basePath = '';
$pageTitle = 'Contact Us';
require_once __DIR__ . '/layouts/header.php';
?>

<div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="<?= $basePath ?>index.php?page=home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">contact</li>
                </ol>
            </nav>
            <div class="d-flex flex-column gap-3 account-form mx-auto mt-5">
                <?php showmessage(); ?>

                <form class="form" action="index.php?page=contact_us" method="POST">
                    <div class="form-items">
                        <div class="mb-3">
                            <label class="form-label required-label" for="name">Name</label>
                            <input type="text" name="name"  class="form-control" id="name" 
                                   value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '', ENT_QUOTES) ?>">
                            <?php showmessage('error', 'name'); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required-label" for="phone">Phone</label>
                            <input type="tel" name="phone" class="form-control" id="phone" 
                                   value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '', ENT_QUOTES) ?>">
                            <?php showmessage('error', 'phone'); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required-label" for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" 
                            value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '', ENT_QUOTES) ?>" >
                            <?php showmessage('error', 'email'); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required-label" for="subject">subject</label>
                            <input type="text" name="subject" class="form-control" id="subject" 
                                   value="<?= htmlspecialchars($_SESSION['old']['subject'] ?? '', ENT_QUOTES) ?>">
                            <?php showmessage('error', 'subject'); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required-label" for="message">message</label>
                            <textarea type ="text" class="form-control" name="message" id="message" ><?= htmlspecialchars($_SESSION['old']['message'] ?? '', ENT_QUOTES) ?></textarea>
                            <?php showmessage('error', 'message'); ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

        </div>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
