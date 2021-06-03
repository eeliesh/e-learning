<div class="search-block">
    <h2><?= $title; ?></h2>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?= \Config\Services::validation()->listErrors(); ?>
    <?php endif; ?>
    <form action="<?= base_url('postari/cautare'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="form-group">
            <label for="search_word">Cuvânt cheie</label>
            <input type="text" name="search_word" id="search_word" class="form-control">
        </div>
        <button type="submit" name="submit_search" class="btn btn-primary">Caută</button>
    </form>
</div>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_search'])): ?>
<div class="portfolio mt-4">
    <div class="row">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="portfolio-item mx-auto">
                        <a href="<?= base_url('curs') . '/' . $post['id']; ?>">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <h3 class="course-title">
                                <?php
                                if (strlen($post['title']) > 12) {
                                    echo substr($post['title'], '0', '12');
                                } else {
                                    echo $post['title'];
                                }
                                ?>
                            </h3>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h4 class="mt-4">Nu a fost găsită nicio postare.</h4>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
