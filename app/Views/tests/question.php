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
                <h5>Întrebare #<?= $test['question_id']; ?></h5>
                <?php if ($test['question_limit'] != 0): ?>
                    <p>Ai la dispoziție <?= $test['question_limit']; ?> secunde pentru fiecare întrebare.</p>
                <?php endif; ?>
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                    <?= \Config\Services::validation()->listErrors(); ?>
                <?php endif;?>
                <form action="<?= base_url('test/') . '/' . $test['id'] . '/intrebare/' . $test['question_id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="answer"><?= $test['questions'][$test['question_id']]; ?></label>
                        <select name="answer" id="answer" class="custom-select">
                            <?php foreach ($test['answers'][$test['question_id']] as $answer): ?>
                                <option value="<?= $answer; ?>"><?= $answer; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="next_question" class="btn btn-primary">Mai departe</button>
                </form>
            </div>
        </div>
    </div>
</div>