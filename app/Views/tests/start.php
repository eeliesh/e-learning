<div class="w-75 mx-auto">
    <h2><?= $title; ?></h2>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?= \Config\Services::validation()->listErrors(); ?>
    <?php endif;?>
    <form action="<?= base_url('test/creare/inceput'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="form-group">
            <label for="questions_number">Număr de întrebări</label>
            <small id="questionsHelp" class="form-text text-muted mt-0 mb-3">Introduceți numărul de întrebări pe care le va conține testul.</small>
            <input type="number" name="questions_number" id="questions_number" min="1" max="200" class="form-control" aria-describedby="questionsHelp">
        </div>
        <button type="submit" name="submit_first" class="btn btn-primary">Trimite</button>
    </form>
</div>