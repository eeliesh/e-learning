<h2><?= $title; ?></h2>
<h6>Lucrări Atașate Postării: <a href="<?= base_url('post') . '/' . $original_post_id; ?>"><?= $post_title; ?></a></h6>
<table id="table" class="display">
    <thead>
    <tr>
        <th>Nume Student</th>
        <th>Trimis Pe</th>
        <th>Acțiuni</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?= $post['student_name']; ?></td>
                <td><?= $post['posted_on']; ?></td>
                <td>
                    <a href="<?= base_url('postare-student') . '/' . $post['id']; ?>" title="Vizualizează"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>