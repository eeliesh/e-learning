<!-- Courses Section-->
<section class="page-section portfolio" id="portfolio">
    <div class="container">
        <!-- Portfolio Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Ultimele Postări</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <div class="text-right mb-4">
            <a href="<?= base_url('postari/cautare'); ?>" class="btn btn-primary">Caută o Postare</a>
        </div>
        <!-- Portfolio Grid Items-->
        <div class="row">
            <?php if (!empty($latest_posts)): ?>
                <?php foreach ($latest_posts as $post): ?>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto">
                            <a href="<?= base_url('post') . '/' . $post['id']; ?>">
                                <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                    <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <h3 class="course-title">
                                    <?php
                                    if (strlen($post['title']) > 12) {
                                        echo substr($post['title'], '0', '12') . '...';
                                    } else {
                                        echo $post['title'];
                                    }
                                    ?>
                                </h3>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h4>Nu a fost găsit niciun curs.</h4>
            <?php endif; ?>
        </div>
    </div>
</section>