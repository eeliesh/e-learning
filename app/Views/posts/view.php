<?php if (isAdmin()): ?>
    <div class="mb-4 text-right">
        <a href="<?= base_url('post/editare') . '/' . $post['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Editează Postare</a>
        <a href="<?= base_url('post/stergere') . '/' . $post['id']; ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Șterge Postare</a>
        <?php if ($post['category'] == 'Laborator' || $post['category'] == 'Proiect'): ?>
            <a href="<?= base_url('postari-studenti' . '/' . $post['id']); ?>" class="btn btn-primary"><i class="fas fa-file-alt"></i> Încărcări Studenți</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="course">
    <h2 class="course-title"><?= $post['title']; ?></h2>
    <h6 class="course-subtitle">Materie: <?= $post['subject_name']; ?></h6>
    <div class="course-meta">
        <div class="course-author">
            <i class="fas fa-user"></i>
            <span><?= $post['author_name']; ?></span>
        </div>
        <div class="course-date">
            <i class="fas fa-calendar-alt"></i>
            <span><?= $post['posted_on']; ?>
        </div>
        <div class="course-category">
            <i class="fas fa-tag"></i>
            <?= $post['category']; ?>
        </div>
    </div>
    <div class="course-content">
        <div class="course-desc">
            <p><?= $post['description']; ?></p>
        </div>
        <div class="course-download">
            <p><a class="btn btn-primary" href="<?= base_url('uploads/posts') . '/' . $post['file']; ?>" target="_blank"><i class="fas fa-download"></i> Click aici</a> pentru ca să descărcați fișierul atașat.</p>
        </div>
    </div>
</div>
<?php if (($post['category'] == 'Laborator' || $post['category'] == 'Proiect') && (studentTeacherId() == $post['author_id'])): ?>
    <?php if (isLoggedIn()): ?>
        <h4>Încarcă Fișier</h4>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?= \Config\Services::validation()->listErrors(); ?>
        <?php endif;?>
        <form action="<?= base_url('post' . '/' . $post['id']); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="description">Descriere</label>
                <textarea name="description" id="description" rows="5" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="file">Fișier</label>
                <input type="file" name="file" id="file" class="form-control">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Trimite</button>
        </form>
    <?php endif; ?>
<?php endif; ?>