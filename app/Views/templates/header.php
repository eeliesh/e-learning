<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Gestionează Activitățile Didactice cu Ușurință." />
    <meta name="author" content="Budescu Ionuț" />
    <title><?php echo $title . ' - Electro Study'; ?></title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.ico'); ?>" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?= base_url('3rd_party/datatables/datatables.min.css'); ?>">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?= base_url('css/styles.css') ?>" rel="stylesheet" />
</head>
<body id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="<?php echo base_url(); ?>">Electro</a>
        <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?php echo base_url('resurse'); ?>">Resurse</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?php echo base_url('evaluare') ?>">Evaluare</a></li>
                <?php if (isLoggedIn()): ?>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?= base_url('mesaje'); ?>"><i class="fas fa-inbox"></i> <?= $user_unread_messages; ?></a>
                </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= userName(); ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php if (isAdmin()): ?>
                                    <a class="dropdown-item" href="<?= base_url('admin'); ?>">Admin Panel</a>
                                    <a class="dropdown-item" href="<?= base_url('studenti'); ?>">Studenții Mei</a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="<?= base_url('delogare'); ?>">Delogare</a>
                            </div>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="<?php echo base_url('autentificare'); ?>">Autentificare</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="<?php echo base_url('inregistrare'); ?>">Înregistrare</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php if (isset($masthead_bg)): ?>
    <!-- Masthead-->
    <header style="background-image: url(<?php echo base_url('assets/img') . '/' . $masthead_bg; ?>);" class="masthead text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-0"><?php echo isset($page_title) ? $page_title : $title; ?></h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <?php if (isset($page_desc)): ?>
                <p class="masthead-subheading font-weight-light mb-0"><?php echo $page_desc; ?></p>
            <?php endif; ?>
        </div>
        <div class="overlay"></div>
    </header>
<?php endif; ?>
<div class="container">
    <main class="main">