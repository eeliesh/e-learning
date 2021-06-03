<div class="test">
    <h2 class="mb-3"><?= $title; ?></h2>
    <div class="row">
        <div class="col-lg-4 col-sm-12 col-12">
            <div class="sidebar">
                <div class="widget">
                    <h5 class="widget-title">Informații Test</h5>
                    <ul class="widget-list">
                        <li>
                            <span class="first"><i class="fas fa-user"></i> Nume Student:</span>
                            <span class="second"><?= $test['student_name']; ?></span>
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
                <h5>Răspunsuri Test</h5>
                <div class="px-3">
                    <?php $i = 0; ?>
                    <?php foreach ($finished_test['answers'] as $answer): ?>
                        <?php $i++; ?>
                        <h6>Î: <?= $test['questions'][$i]; ?></h6>
                        <p>R: <?= $answer; ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="mt-3">
                    <p>
                        <?php if ($finished_test['file'] != null): ?>
                            <a href="<?= base_url('uploads/tests' . '/' . $finished_test['file']); ?>"
                               target="_blank"><i class="fas fa-download"></i> Click aici</a> pentru ca să descărcați fișierul atașat de student.
                        <?php else: ?>
                            Studentul nu a atașat niciun fișier acestui test.
                        <?php endif; ?>
                    </p>
                </div>
                <?php if ($finished_test['grade'] != 0): ?>
                    <div class="mt-3">
                        <span class="font-weight-bold">Ați evaluat acest test cu nota: <?= $finished_test['grade'] . '/10.'; ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                    <?= \Config\Services::validation()->listErrors(); ?>
                <?php endif; ?>
                <form action="<?= base_url('test') . '/' . $test['id'] . '/student' . '/' . $finished_test['student_id']; ?>"
                      class="mt-3" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="grade">Notă</label>
                        <input type="number" name="grade" id="grade" min="1" max="10" class="form-control">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Evaluează</button>
                </form>
            </div>
        </div>
    </div>
</div>