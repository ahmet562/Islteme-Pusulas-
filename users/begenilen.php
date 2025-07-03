<?php
require_once '../conn.php';

$kategoriler = [
    1 => 'Yemek',
    2 => 'Mağaza',
    3 => 'Kişisel Bakım',
    4 => 'Müzik',
    5 => 'Spor',
    6 => 'Barınma'
];
?>
<style>
    .listing-item {
        height: 350px;
        width: 100%;
    }
    .listing-image {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .listing-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        filter: brightness(1.1) contrast(1.2);
    }
</style>

<div class="site-section" data-aos="fade">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 text-center border-primary">
        <h2 class="font-weight-light text-primary">En Çok Beğenilenler</h2>
      </div>
    </div>
    <div class="row">
    <?php
    foreach ($kategoriler as $kategori_id => $kategori_adi) {
        $row = $conn->query("SELECT * FROM isletme WHERE kategori = '$kategori_id' ORDER BY ortalama_yildiz DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $resimYolu = str_replace("", "", $row['isletme_resim']);
            ?>
            <div class="col-md-6 mb-4 mb-lg-4 col-lg-4">
                <div class="listing-item">
                    <div class="listing-image">
                        <img src="<?= htmlspecialchars($resimYolu) ?>" class="img-fluid">
                    </div>
                    <div class="listing-item-content">
                        <a class="px-3 mb-3 category" href="#"><?= htmlspecialchars($kategori_adi) ?></a>
                        <h2 class="mb-1">
                            <a href="isletme-detay.php?id=<?= $row['id'] ?>">
                                <?= htmlspecialchars($row['isletme_adi']) ?>
                            </a>
                        </h2>
                        <span class="address"><?= htmlspecialchars($row['isletme_konumu']) ?></span>
                    </div>
                </div>
            </div>
        <?php
        }
    }
    ?>
    </div>
  </div>
</div>
