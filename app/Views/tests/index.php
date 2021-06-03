<h2><?= $title; ?></h2>
<?php if (isAdmin()): ?>
    <div class="mb-4 text-right">
        <a href="<?= base_url('test/creare'); ?>" class="btn btn-success">Adaugă Test</a>
    </div>
<?php endif; ?>
<div class="tests">
    <?php if (!empty($teacher)): ?>
        <h3>Teste create</h3>
        <?php if (!empty($teacher_tests)): ?>
            <table id="testsTable" class="display">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Autor</th>
                    <th>Titlu</th>
                    <th>Început</th>
                    <th>Sfârșit</th>
                    <th>Acțiuni</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($teacher_tests as $test): ?>
                    <tr>
                        <td><?= $test['id']; ?></td>
                        <td><?= $test['author_name']; ?></td>
                        <td><?= $test['title']; ?></td>
                        <td><?= $test['start_time']; ?></td>
                        <td><?= $test['end_time']; ?></td>
                        <td>
                            <a href="<?= base_url('test/') . '/' . $test['id']; ?>" title="Vizualizează">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if (isAdmin()): ?>
                                <a href="<?= base_url('test') . '/' . $test['id'] . '/finalizat'; ?>" title="Teste Finalizate">
                                    <i class="fas fa-user-check"></i>
                                </a>
                                <a href="<?= base_url('test/stergere') . '/' . $test['id']; ?>" title="Șterge Test">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nu ați creat niciun test până acum.</p>
        <?php endif; ?>
    <?php else: ?>
        <div class="incoming-tests">
            <h3>Teste în așteptare</h3>
            <?php if (!empty($incoming_tests)): ?>
                <table id="testsTable" class="display">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Autor</th>
                        <th>Titlu</th>
                        <th>Început</th>
                        <th>Sfârșit</th>
                        <th>Acțiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($incoming_tests as $test): ?>
                        <tr>
                            <td><?= $test['id']; ?></td>
                            <td><?= $test['author_name']; ?></td>
                            <td><?= $test['title']; ?></td>
                            <td><?= $test['start_time']; ?></td>
                            <td><?= $test['end_time']; ?></td>
                            <td>
                                <a href="<?= base_url('test/') . '/' . $test['id']; ?>"><i class="fas fa-eye"></i></a>
                                <?php if (isAdmin()): ?>
                                    <a href="<?= base_url('test/stergere') . '/' . $test['id']; ?>"><i class="fas fa-trash-alt"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nu au fost găsite teste în așteptare.</p>
            <?php endif; ?>
        </div>
        <div class="finished-tests">
            <h3>Teste finalizate</h3>
            <?php if (!empty($finished_tests)): ?>
                <table id="finishedTestsTable" class="display">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Autor</th>
                        <th>Titlu</th>
                        <th>Început</th>
                        <th>Sfârșit</th>
                        <th>Acțiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($finished_tests as $test): ?>
                        <tr>
                            <td><?= $test['id']; ?></td>
                            <td><?= $test['author_name']; ?></td>
                            <td><?= $test['title']; ?></td>
                            <td><?= $test['start_time']; ?></td>
                            <td><?= $test['end_time']; ?></td>
                            <td>
                                <a href="<?= base_url('test/') . '/' . $test['id']; ?>"><i class="fas fa-eye"></i></a>
                                <?php if (isAdmin()): ?>
                                    <a href="<?= base_url('test/stergere') . '/' . $test['id']; ?>"><i class="fas fa-trash-alt"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nu au fost găsite teste finalizate.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>