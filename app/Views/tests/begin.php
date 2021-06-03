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
                <p>Atunci când consideri că ești gata să începi testul, apasă butonul de mai jos.</p>
                <form action="<?= base_url('test/' . '/' . $test['id'] . '/' . $test['question_id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <button type="submit" name="begin_test" class="btn btn-primary">Începe Testul</button>
                </form>
            </div>
        </div>
    </div>
</div>