<h2><?= $title; ?></h2>
<h6>Lucrare Atașată Postării: <a href="<?= base_url('post') . '/' . $post['post_id']; ?>"><?= $post['post_name']; ?></a></h6>
<div class="course">
    <h6 class="mt-4">Conținut</h6>
    <div class="course-desc">
        <p><?= $post['description']; ?></p>
        <p class="mt-2"><strong>Fișier Încărcat:</strong> <a class="btn btn-primary" href="<?= base_url('uploads/students' . '/' . $post['file']); ?>" target="_blank"><i class="fas fa-download"></i> CLICK</a></p>
    </div>
</div>