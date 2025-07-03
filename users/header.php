<?php
session_start();
require_once '../conn.php';

// Önbelleği devre dışı bırak
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Oturum kontrolü
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: ../signup.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>İşletme Pusulası</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="Free-Template.co" />
  <link rel="shortcut icon" href="../images/favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <link rel="stylesheet" href="../fonts/icomoon/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/magnific-popup.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="../css/aos.css">
  <link rel="stylesheet" href="../css/rangeslider.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="site-wrap">
    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    <?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="site-navbar" role="banner">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-11 col-xl-2">
        <h1 class="mb-0 site-logo"><a href="index.php"><img src="../images/işletme2.png" alt="logo"></a></h1>
      </div>
      <div class="col-12 col-md-10 d-none d-xl-block">
        <nav class="site-navigation position-relative text-right" role="navigation">
          <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
            <li class="<?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>"><a href="index.php"><span>Anasayfa</span></a></li>
            <li class="<?php echo ($currentPage == 'isletmeler.php') ? 'active' : ''; ?>"><a href="isletmeler.php"><span>işletmeler</span></a></li>
            <li class="<?php echo ($currentPage == 'about.php') ? 'active' : ''; ?>"><a href="about.php"><span>Hakkımızda</span></a></li>
            <li class="has-children">
                      <a href="#">İşletmelerim</a>
                      <ul class="dropdown">
                        <li><a href="isletme-ekle.php">İşletme ekle</a></li>
                        <li><a href="isletme-düzenle.php">Kayıtlı İşletmeler</a></li>
                      </ul>
                    </li>
            <li class="<?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>"><a href="contact.php"><span>İletişim</span></a></li>
            <li><a href="../logout.php"><i class="sl sl-icon-user"></i>Çıkış Yap</a></li>
          </ul>
        </nav>
      </div>
      <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;">
        <a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a>
      </div>
    </div>
  </div>
</header>
<div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(../images/hero_1.jpg);" data-aos="fade"
  data-stellar-background-ratio="0.5">
