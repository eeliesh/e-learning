<div class="w-75 mx-auto">
    <h1><?= $title; ?></h1>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?= \Config\Services::validation()->listErrors(); ?>
    <?php endif;?>
    <form action="<?= base_url('post/editare') . '/' . $post['id']; ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group">
            <label for="title">Titlu</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= $post['title']; ?>">
        </div>
        <div class="form-group">
            <label for="subject">Materie</label>
            <select name="subject" id="subject" class="custom-select">
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= $subject['id']; ?>"<?php if ($post['subject_id'] == $subject['id']): ?> selected="selected"<?php endif; ?>><?= $subject['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="category">Categorie</label>
            <select name="category" id="category" class="custom-select">
                <option value="Curs"<?php if ($post['category'] == 'Curs'): ?> selected="selected"<?php endif; ?>>Curs</option>
                <option value="Seminar"<?php if ($post['category'] == 'Seminar'): ?> selected="selected"<?php endif; ?>>Seminar</option>
                <option value="Laborator"<?php if ($post['category'] == 'Laborator'): ?> selected="selected"<?php endif; ?>>Laborator</option>
                <option value="Proiect"<?php if ($post['category'] == 'Proiect'): ?> selected="selected"<?php endif; ?>>Proiect</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Descriere</label>
            <textarea name="description" id="description" rows="10" class="form-control"><?= $post['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="file">Fișier</label>
            <small id="courseHelp" class="form-text text-muted mb-2">Nu încărcați niciun fișier dacă nu doriți să modificați fișierul în sine.</small>
            <input type="file" name="file" id="file" class="form-control" aria-describedby="courseHelp">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Editează</button>
    </form>
</div>