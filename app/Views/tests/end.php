<div class="test">
    <h2 class="mb-3"><?= $title; ?></h2>
    <div class="row">
        <div class="col-lg-4 col-sm-12 col-12">
            <div class="sidebar">
                <div class="widget">
                    <h5 class="widget-title">Informații Test</h5>
                    <ul class="widget-list">
                        <li>
                            <span class="first"><i class="fas fa-user"></i> Creat de:</span>
                            <span class="second"><?= $test['author_name']; ?></span>
                        </li>
                        <li>
                            <span class="first"><i class="fas fa-question-circle"></i> Întrebări:</span>
                            <span class="second"><?= $test['questions_count']; ?></span>
                        </li>
                        <li>
                            <span class="first"><i class="fas fa-calendar-plus"></i> Început:</span>
                            <span class="second"><?= $test['start_time']; ?></span>
                        </li>
                        <li>
                            <span class="first"><i class="fas fa-calendar-alt"></i> Sfârșit:</span>
                            <span class="second"><?= $test['end_time']; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-sm-12 col-12">
            <div class="content">
                <h5>Finalul Testului</h5>
                <p>Ai ajuns la finalul acestui test. Poți încărca un fișier dacă dorești. Dacă nu, apasă butonul de finalizare.</p>
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                    <?= \Config\Services::validation()->listErrors(); ?>
                <?php endif;?>
                <form action="<?= base_url('test/') . '/' . $test['id'] . '/intrebare/' . $test['question_id']; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="test_file">Fișier Test</label>
                        <small id="fileHelp" class="form-text text-muted">Se acceptă doar fișiere ZIP de maxim 5MB.</small>
                        <input type="file" name="test_file" class="form-control" aria-describedby="fileHelp">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Trimite</button>
                </form>
            </div>
        </div>
    </div>
</div>