<?php
require_once '../conn.php';
?>
<div class="site-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 text-center border-primary">
        <h2 class="font-weight-light text-primary">Toplam İşletme Sayıları</h2>
      </div>
    </div>

    <div class="row align-items-stretch">
      <div class="col-6 col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
        <a  class="popular-category h-100">
          <span class="icon mb-3"><span class="flaticon-hotel"></span></span>
          <span class="caption mb-2 d-block">Barınma</span>
          <span class="number"><?= $conn->query("SELECT adet FROM kategoriler WHERE id = 6")->fetchColumn() ?></span>
        </a>
      </div>
      <div class="col-6 col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
        <a  class="popular-category h-100">
          <span class="icon mb-3"><span class="flaticon-microphone"></span></span>
          <span class="caption mb-2 d-block">Müzik</span>
          <span class="number"><?= $conn->query("SELECT adet FROM kategoriler WHERE id = 4")->fetchColumn() ?></span>
        </a>
      </div>
      <div class="col-6 col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
        <a  class="popular-category h-100">
          <span class="icon mb-3"><span class="flaticon-flower"></span></span>
          <span class="caption mb-2 d-block">Kişisel Bakım</span>
          <span class="number"><?= $conn->query("SELECT adet FROM kategoriler WHERE id = 3")->fetchColumn() ?></span>
        </a>
      </div>
      <div class="col-6 col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
        <a class="popular-category h-100">
          <span class="icon mb-3"><span class="flaticon-restaurant"></span></span>
          <span class="caption mb-2 d-block">Mağaza</span>
          <span class="number"><?= $conn->query("SELECT adet FROM kategoriler WHERE id = 2")->fetchColumn() ?></span>
        </a>
      </div>
      <div class="col-6 col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
        <a  class="popular-category h-100">
          <span class="icon mb-3"><span class="flaticon-cutlery"></span></span>
          <span class="caption mb-2 d-block">Yemek</span>
          <span class="number"><?= $conn->query("SELECT adet FROM kategoriler WHERE id = 1")->fetchColumn() ?></span>
        </a>
      </div>
      <div class="col-6 col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
        <a  class="popular-category h-100">
          <span class="icon mb-3"><span class="flaticon-bike"></span></span>
          <span class="caption mb-2 d-block">Spor</span>
          <span class="number"><?= $conn->query("SELECT adet FROM kategoriler WHERE id = 5")->fetchColumn() ?></span>
        </a>
      </div>
    </div>

    <div class="row mt-5 justify-content-center tex-center">
      <div class="col-md-4"><a href="isletmeler.php" class="btn btn-block btn-outline-primary btn-md px-5">Tüm Kategorileri göster</a>
      </div>
    </div>
  </div>
</div>
