<h2><?= $title; ?></h2>
<div class="row">
    <div class="col-lg-4 col-sm-12 col-12">
        <div class="sidebar">
            <div class="widget">
                <h5>Link-uri Utile</h5>
                <a href="<?= base_url('utilizatori'); ?>" class="btn btn-primary">Listă Utilizatori</a>
                <a href="<?= base_url('materii'); ?>" class="btn btn-primary">Modifică Materii</a>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-sm-12 col-12">
        <div class="content">
            <h5>Statistici Platformă</h5>
            <div class="statistics">
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-12">
                        <div class="statistic">
                            <i class="fas fa-users"></i>
                            <h6>Utilizatori</h6>
                            <span><?= $users_count; ?></span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-12">
                        <div class="statistic">
                            <i class="fas fa-book"></i>
                            <h6>Cursuri</h6>
                            <span><?= $courses_count; ?></span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-12">
                        <div class="statistic">
                            <i class="fas fa-file-alt"></i>
                            <h6>Teste</h6>
                            <span><?= $tests_count; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>