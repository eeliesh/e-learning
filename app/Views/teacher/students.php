<h2>Studenții dvs.:</h2>
<?php if (!empty($students)): ?>
    <ul>
        <?php foreach ($students as $student): ?>
            <li><?= $student['username']; ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Nu a fost găsit niciun student.</p>
<?php endif; ?>