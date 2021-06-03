<h2><?= $title; ?></h2>
<h3 class="mb-3">Listă Materii Actuale</h3>
<table id="table" class="display">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nume</th>
        <th>Acțiuni</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($subjects)): ?>
        <?php foreach ($subjects as $subject): ?>
            <tr>
                <td><?= $subject['id']; ?></td>
                <td><?= $subject['name']; ?></td>
                <td>
                    <a href="<?= base_url('materie') . '/' . $subject['id'] . '/sterge'; ?>" title="Șterge"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<h3 class="mt-3">Adaugă Materie</h3>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <?= \Config\Services::validation()->listErrors(); ?>
<?php endif;?>
<form action="<?= base_url('materii'); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="form-group">
        <label for="name">Nume Materie</label>
        <input type="text" name="subject_name" id="name" class="form-control">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Adaugă</button>
</form>