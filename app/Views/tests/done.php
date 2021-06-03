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
                <h5>Întrebări Test</h5>
                <p>Ai terminat deja testul respectiv. Poți vedea mai jos răspunsurile oferite de tine.</p>
                <div class="px-3">
                    <?php $i = 0; ?>
                    <?php foreach ($finished_test['answers'] as $answer): ?>
                        <?php $i++; ?>
                        <h6>Î: <?= $test['questions'][$i]; ?></h6>
                        <p>R: <?= $answer; ?></p>
                    <?php endforeach ;?>
                </div>
                <div class="mt-3">
                    <p>
                        <?php if ($finished_test['file'] != null): ?>
                            <a href="<?= base_url('uploads/tests' . '/' . $finished_test['file']); ?>"
                               target="_blank"><i class="fas fa-download"></i> Click aici</a> pentru ca să descarci fișierul atașat testului.
                        <?php else: ?>
                            Nu ai atașat niciun fișier acestui test.
                        <?php endif; ?>
                    </p>
                </div>
                <div class="mt-3">
                    <span class="font-weight-bold">
                        <?php if ($finished_test['grade'] != 0): ?>
                            Testul tău a fost evaluat cu nota: <?= $finished_test['grade'] . '/10.'; ?>
                        <?php else: ?>
                            Testul tău încă nu a fost evaluat.
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>