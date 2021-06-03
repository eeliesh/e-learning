<h2><?= $title; ?></h2>
<div class="mb-4 text-right">
    <?php if (isAdmin()): ?>
        <a href="<?= base_url('post/creare'); ?>" class="btn btn-success">Postare Nouă</a>
    <?php endif; ?>
</div>
<div class="accordion" id="accordion">
    <?php if (!empty($subjects)): ?>
        <?php foreach ($subjects as $subject): ?>
            <div class="card">
                <div class="card-header" id="heading_<?= $subject['id']; ?>">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                data-target="#collapse_<?= $subject['id']; ?>" aria-expanded="true"
                                aria-controls="collapse_<?= $subject['id']; ?>">
                            <i class="fas fa-book"></i> <?= $subject['name'] ?>
                        </button>
                    </h2>
                </div>
                <div id="collapse_<?= $subject['id']; ?>" class="collapse"
                     aria-labelledby="heading_<?= $subject['id']; ?>" data-parent="#accordion">
                    <div class="card-body">
                        <div class="accordion" id="accordion2">
                            <div class="card">
                                <div class="card-header" id="courses_heading_<?= $subject['id']; ?>">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#courses_collapse_<?= $subject['id']; ?>"
                                                aria-expanded="true"
                                                aria-controls="courses_collapse_<?= $subject['id']; ?>">
                                            <i class="fas fa-folder-open"></i> Cursuri
                                        </button>
                                    </h2>
                                </div>
                                <div id="courses_collapse_<?= $subject['id']; ?>" class="collapse"
                                     aria-labelledby="courses_heading_<?= $subject['id']; ?>" data-parent="#accordion2">
                                    <div class="card-body">
                                        <?php if (!empty($subject['courses'])): ?>
                                            <?php foreach ($subject['courses'] as $course): ?>
                                                <a href="<?= base_url('post') . '/' . $course['id']; ?>"
                                                   class="btn btn-link d-block text-left">
                                                    <i class="fas fa-file-alt"></i> <?= $course['title']; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span>Nu au fost găsite cursuri pentru această materie.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="seminars_heading_<?= $subject['id']; ?>">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#seminars_collapse_<?= $subject['id']; ?>"
                                                aria-expanded="true"
                                                aria-controls="seminars_collapse_<?= $subject['id']; ?>">
                                            <i class="fas fa-folder-open"></i> Seminarii
                                        </button>
                                    </h2>
                                </div>
                                <div id="seminars_collapse_<?= $subject['id']; ?>" class="collapse"
                                     aria-labelledby="seminars_heading_<?= $subject['id']; ?>"
                                     data-parent="#accordion2">
                                    <div class="card-body">
                                        <?php if (!empty($subject['seminars'])): ?>
                                            <?php foreach ($subject['seminars'] as $seminar): ?>
                                                <a href="<?= base_url('post') . '/' . $seminar['id']; ?>"
                                                   class="btn btn-link d-block text-left">
                                                    <i class="fas fa-file-alt"></i> <?= $seminar['title']; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span>Nu au fost găsite seminarii pentru această materie.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="labs_heading_<?= $subject['id']; ?>">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#labs_collapse_<?= $subject['id']; ?>" aria-expanded="true"
                                                aria-controls="labs_collapse_<?= $subject['id']; ?>">
                                            <i class="fas fa-folder-open"></i> Laboratoare
                                        </button>
                                    </h2>
                                </div>
                                <div id="labs_collapse_<?= $subject['id']; ?>" class="collapse"
                                     aria-labelledby="labs_heading_<?= $subject['id']; ?>" data-parent="#accordion2">
                                    <div class="card-body">
                                        <?php if (!empty($subject['labs'])): ?>
                                            <?php foreach ($subject['labs'] as $lab): ?>
                                                <a href="<?= base_url('post') . '/' . $lab['id']; ?>"
                                                   class="btn btn-link d-block text-left">
                                                    <i class="fas fa-file-alt"></i> <?= $lab['title']; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span>Nu au fost găsite laboratoare pentru această materie.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="projects_heading_<?= $subject['id']; ?>">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#projects_collapse_<?= $subject['id']; ?>"
                                                aria-expanded="true"
                                                aria-controls="projects_collapse_<?= $subject['id']; ?>">
                                            <i class="fas fa-folder-open"></i> Proiecte
                                        </button>
                                    </h2>
                                </div>
                                <div id="projects_collapse_<?= $subject['id']; ?>" class="collapse"
                                     aria-labelledby="projects_heading_<?= $subject['id']; ?>"
                                     data-parent="#accordion2">
                                    <div class="card-body">
                                        <?php if (!empty($subject['projects'])): ?>
                                            <?php foreach ($subject['projects'] as $project): ?>
                                                <a href="<?= base_url('post') . '/' . $project['id']; ?>"
                                                   class="btn btn-link d-block text-left">
                                                    <i class="fas fa-file-alt"></i> <?= $project['title']; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span>Nu au fost găsite proiecte pentru această materie.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nu au fost găsite materii.</p>
    <?php endif; ?>
</div>