<h2><?= $title; ?></h2>
<h3>Titlu: <?= $message['title']; ?></h3>
<p class="mb-0">Trimis pe: <?= $message['created_on']; ?></p>
<p>Citit pe: <?= $message['read_on']; ?></p>
<div class="course">
    <div class="course-desc">
        <p><?= $message['body']; ?></p>
    </div>
</div>
<div class="replies">
    <h3>Răspunsuri</h3>
    <?php if (!empty($replies)): ?>
        <?php foreach ($replies as $reply): ?>
            <div class="px-3">
                <div>
                    <span class="font-weight-bold"><?= $reply['author_name']; ?></span>
                    <span> • </span>
                    <span><?= $reply['posted_on']; ?></span>
                </div>
                <p><?= $reply['body']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nu au fost găsite răspunsuri pentru această conversație.</p>
    <?php endif; ?>
</div>
<div>
    <h3>Răspunde</h3>
    <div class="px-3">
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?= \Config\Services::validation()->listErrors(); ?>
        <?php endif;?>
        <form action="" method="post">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="reply">Mesaj</label>
                <textarea name="reply" id="reply" rows="5" class="form-control"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Trimite</button>
        </form>
    </div>
</div>