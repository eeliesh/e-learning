<h2>Editează studenții pentru profesorul: <?= $teacher['username']; ?></h2>
<?php if (!empty($students)): ?>
    <form action="<?= base_url('profesor/editare' . '/' . $teacher['id']); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="form-group">
            <label for="students">Selectează studenții din listă:</label>
            <select name="students[]" id="students" multiple="multiple" class="form-control">
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['id']; ?>"<?php if ($teacher['id'] == $student['teacher_id']): ?>selected="selected"<?php endif; ?>><?= $student['username']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Adaugă</button>
    </form>
<?php else: ?>
    <h3>Nu au fost găsiți studenți.</h3>
<?php endif; ?>