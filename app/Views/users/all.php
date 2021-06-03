<h2><?= $title; ?></h2>
<table id="usersTable" class="display">
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Rol</th>
        <th>Acțiuni</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id']; ?></td>
            <td><?= $user['username']; ?></td>
            <td><?= $user['role']; ?></td>
            <td>
                <a href="<?= base_url('utilizator/rol/') . '/' . $user['id']; ?>" title="Schimbă Rolul"><i class="fas fa-user-shield"></i></a>
                <?php if ($user['is_teacher']): ?>
                    <a href="<?= base_url('profesor/editare') . '/' . $user['id']; ?>" title="Editează Studenții"><i class="fas fa-users"></i></a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>