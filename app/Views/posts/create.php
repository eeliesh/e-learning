<div class="w-75 mx-auto">
    <h2><?= $title; ?></h2>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?= \Config\Services::validation()->listErrors(); ?>
    <?php endif;?>
    <form action="<?= base_url('post/creare'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group">
            <label for="title">Titlu</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="form-group">
            <label for="subject">Materie</label>
            <select name="subject" id="subject" class="custom-select">
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= $subject['id']; ?>"><?= $subject['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="category">Categorie</label>
            <select name="category" id="category" class="custom-select">
                <option value="Curs">Curs</option>
                <option value="Seminar">Seminar</option>
                <option value="Laborator">Laborator</option>
                <option value="Proiect">Proiect</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Descriere</label>
            <textarea name="description" id="description" rows="10" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="course">Fișier</label>
            <input type="file" name="file" id="course" class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Postează</button>
    </form>
</div>