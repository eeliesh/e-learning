<div class="w-50 mx-auto">
    <h1><?= $title; ?></h1>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?= \Config\Services::validation()->listErrors(); ?>
        <?php if (isset($password_error)): ?>
            <ul>
                <li><?= $password_error; ?></li>
            </ul>
        <?php endif; ?>
    <?php endif;?>
    <form action="<?= base_url('autentificare'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="form-group">
            <label for="username">Nume de Utilizator</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Parolă</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" name="remember_me" class="form-check-input" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Memorează-mă</label>
        </div>
        <button type="submit" name="submit" class="btn btn-primary"><?= $title; ?></button>
    </form>
    <p class="mt-3">Nu ai un cont? <a href="<?= base_url('inregistrare'); ?>">Înregistrează-te</a> acum.</p>
</div>