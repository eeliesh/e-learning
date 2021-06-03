<div class="w-50 mx-auto">
    <h1><?= $title; ?></h1>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?= \Config\Services::validation()->listErrors(); ?>
    <?php endif;?>
    <form action="<?= base_url('inregistrare'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="form-group">
            <label for="username">Nume de Utilizator</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Adresă de Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Parolă</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmă Parola</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-primary"><?= $title; ?></button>
    </form>
    <p class="mt-3">Ai deja un cont? <a href="<?= base_url('autentificare'); ?>">Autentifică-te</a> acum.</p>
</div>