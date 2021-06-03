<div class="w-75 mx-auto">
    <h2><?= $title; ?></h2>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?= \Config\Services::validation()->listErrors(); ?>
    <?php endif;?>
    <form action="<?= base_url('mesaj/creare'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="form-group">
            <label for="recipient">Nume Destinatar</label>
            <input type="text" name="recipient" id="recipient" class="form-control">
        </div>
        <div class="form-group">
            <label for="title">Titlu Conversație</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="form-group">
            <label for="message">Mesaj</label>
            <textarea name="message" id="message" rows="7" class="form-control"></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Trimite</button>
    </form>
</div>