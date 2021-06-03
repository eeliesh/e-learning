<div class="w-75 mx-auto">
    <h2><?= $title; ?></h2>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?= \Config\Services::validation()->listErrors(); ?>
    <?php endif;?>
        <form action="<?= base_url('test/creare'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="title">Titlu</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>
            <?php for ($i = 1; $i <= $_SESSION['questions_number']; $i++): ?>
                <div class="form-group">
                    <label for="question_<?= $i; ?>">Întrebarea <?= $i; ?></label>
                    <input type="text" name="question_<?= $i; ?>" id="question_<?= $i; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="answer_<?= $i; ?>">Răspunsuri la întrebarea #<?= $i; ?></label>
                    <small id="answer_<?= $i; ?>_help" class="form-text text-muted mt-0 mb-2">Scrieți câte o variantă de răspuns pentru testul grilă per rând. Nu folosiți virgule în răspunsuri.</small>
                    <textarea name="answer_<?= $i; ?>" id="answer_<?= $i; ?>" rows="5" aria-describedby="answer_<?= $i; ?>_help" class="form-control"></textarea>
                </div>
            <?php endfor; ?>
            <p>Timpul de Început</p>
            <div class="form-row">
                <div class="form-group col">
                    <label for="start_hour">Ora</label>
                    <select name="start_hour" id="start_hour" class="custom-select">
                        <?php for ($h = 1; $h <= 24; $h++): ?>
                            <?php if ($h < 10): $h = '0' . $h; endif; ?>
                            <option value="<?= $h ?>"><?= $h; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="start_minute">Minute</label>
                    <select name="start_minute" id="start_minute" class="custom-select">
                        <?php for ($min = 0; $min <= 59; $min++): ?>
                            <?php if ($min < 10): $min = '0' . $min; endif; ?>
                            <option value="<?= $min; ?>"><?= $min; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="start_day">Ziua</label>
                    <select name="start_day" id="start_day" class="custom-select">
                        <?php for ($d = 1; $d <= 31; $d++): ?>
                            <?php if ($d < 10): $d = '0' . $d; endif; ?>
                            <option value="<?= $d; ?>"><?= $d; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="start_month">Luna</label>
                    <select name="start_month" id="start_month" class="custom-select">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <?php if ($m < 10): $m = '0' . $m; endif; ?>
                            <option value="<?= $m; ?>"><?= $m; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="start_year">Anul</label>
                    <select name="start_year" id="start_year" class="custom-select">
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                    </select>
                </div>
            </div>
            <p>Timpul de Sfârșit</p>
            <div class="form-row">
                <div class="form-group col">
                    <label for="end_hour">Ora</label>
                    <select name="end_hour" id="end_hour" class="custom-select">
                        <?php for ($h = 1; $h <= 24; $h++): ?>
                            <?php if ($h < 10): $h = '0' . $h; endif; ?>
                            <option value="<?= $h ?>"><?= $h; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="end_minute">Minute</label>
                    <select name="end_minute" id="end_minute" class="custom-select">
                        <?php for ($min = 0; $min <= 59; $min++): ?>
                            <?php if ($min < 10): $min = '0' . $min; endif; ?>
                            <option value="<?= $min; ?>"><?= $min; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="end_day">Ziua</label>
                    <select name="end_day" id="end_day" class="custom-select">
                        <?php for ($d = 1; $d <= 31; $d++): ?>
                            <?php if ($d < 10): $d = '0' . $d; endif; ?>
                            <option value="<?= $d; ?>"><?= $d; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="end_month">Luna</label>
                    <select name="end_month" id="end_month" class="custom-select">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <?php if ($m < 10): $m = '0' . $m; endif; ?>
                            <option value="<?= $m; ?>"><?= $m; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="end_year">Anul</label>
                    <select name="end_year" id="end_year" class="custom-select">
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="question_limit">Timp Limită Întrebare</label>
                <small id="limitHelp" class="form-text text-muted mt-0 mb-2">Introduceți timpul în secunde. Folosiți 0 pentru a nu seta o limită.</small>
                <input type="number" name="question_limit" id="question_limit" min="0" max="600" value="0" class="form-control" aria-describedby="limitHelp">
            </div>
            <button type="submit" name="submit_test" class="btn btn-primary">Postează</button>
        </form>
</div>