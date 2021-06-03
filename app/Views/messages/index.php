<h2><?= $title; ?></h2>
<div class="mb-2 text-right">
    <a href="<?= base_url('mesaj/creare'); ?>" class="btn btn-primary">Mesaj Nou</a>
</div>
<h3>Necitite</h3>
<?php if (!empty($unread_messages)): ?>
    <table id="unreadMessagesTable" class="display">
        <thead>
        <tr>
            <th>ID</th>
            <th>Autor</th>
            <th>Titlu</th>
            <th>Trimis Pe</th>
            <th>Acțiuni</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($unread_messages as $message): ?>
                <tr>
                    <td><?= $message['id']; ?></td>
                    <td><?= $message['author_name']; ?></td>
                    <td><?= $message['title']; ?></td>
                    <td><?= $message['created_on']; ?></td>
                    <td>
                        <a href="<?= base_url('mesaj') . '/' . $message['id']; ?>" title="Vizualizează"><i class="fas fa-eye"></i></a>
                        <a href="<?= base_url('mesaj/stergere') . '/' . $message['id']; ?>" title="Șterge"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nu a fost găsit niciun mesaj necitit.</p>
<?php endif; ?>
<h3>Citite</h3>
<?php if (!empty($read_messages)): ?>
    <table id="readMessagesTable" class="display">
        <thead>
        <tr>
            <th>ID</th>
            <th>Autor</th>
            <th>Titlu</th>
            <th>Trimis Pe</th>
            <th>Acțiuni</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($read_messages as $message): ?>
            <tr>
                <td><?= $message['id']; ?></td>
                <td><?= $message['author_name']; ?></td>
                <td><?= $message['title']; ?></td>
                <td><?= $message['created_on']; ?></td>
                <td>
                    <a href="<?= base_url('mesaj') . '/' . $message['id']; ?>" title="Vizualizează"><i class="fas fa-eye"></i></a>
                    <a href="<?= base_url('mesaj/stergere') . '/' . $message['id']; ?>" title="Șterge"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nu a fost găsit niciun mesaj citit.</p>
<?php endif; ?>
<h3>Trimise</h3>
<?php if (!empty($sent_messages)): ?>
    <table id="sentMessagesTable" class="display">
        <thead>
        <tr>
            <th>ID</th>
            <th>Destinatar</th>
            <th>Titlu</th>
            <th>Trimis Pe</th>
            <th>Acțiuni</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sent_messages as $message): ?>
            <tr>
                <td><?= $message['id']; ?></td>
                <td><?= $message['recipient_name']; ?></td>
                <td><?= $message['title']; ?></td>
                <td><?= $message['created_on']; ?></td>
                <td>
                    <a href="<?= base_url('mesaj') . '/' . $message['id']; ?>" title="Vizualizează"><i class="fas fa-eye"></i></a>
                    <a href="<?= base_url('mesaj/stergere') . '/' . $message['id']; ?>" title="Șterge"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nu a fost găsit niciun mesaj trimis.</p>
<?php endif; ?>