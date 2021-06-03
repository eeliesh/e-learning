<h2><?= $title; ?></h2>
<?php if (!empty($finished_tests)): ?>
    <table id="testsTable" class="display">
        <thead>
        <tr>
            <th>ID Student</th>
            <th>Nume Student</th>
            <th>Notă</th>
            <th>Acțiuni</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($finished_tests as $test): ?>
            <tr>
                <td><?= $test['student_id']; ?></td>
                <td><?= $test['student_name']; ?></td>
                <td>
                    <?php if ($test['grade'] == 0): ?>
                        Neevaluat
                    <?php else: ?>
                        <?= $test['grade'] . '/10'; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url('test/') . '/' . $test['test_id'] . '/student' . '/' . $test['student_id']; ?>" title="Vizualizează">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Niciun student nu a finalizat testul respectiv până acum.</p>
<?php endif; ?>