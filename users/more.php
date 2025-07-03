<?php require_once '../conn.php';?>
<div class="site-section bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <?php
        $sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
        $limit = 10;
        $offset = ($sayfa - 1) * $limit;
        $kategoriFiltre = isset($_POST['kategori']) ? $_POST['kategori'] : '';
        $lokasyonFiltre = isset($_POST['lokasyon']) ? $_POST['lokasyon'] : '';
        $sql = "SELECT COUNT(*) FROM isletme WHERE 1";
        if ($kategoriFiltre && $kategoriFiltre != '') {
            $sql .= " AND kategori = :kategori";
        }
        if ($lokasyonFiltre) {
            $sql .= " AND isletme_konumu LIKE :lokasyon";
        }
        $toplamSorgu = $conn->prepare($sql);
        if ($kategoriFiltre && $kategoriFiltre != '') {
            $toplamSorgu->bindValue(':kategori', $kategoriFiltre, PDO::PARAM_STR);
        }
        if ($lokasyonFiltre) {
            $toplamSorgu->bindValue(':lokasyon', "%$lokasyonFiltre%", PDO::PARAM_STR);
        }
        $toplamSorgu->execute();
        $toplamKayit = $toplamSorgu->fetchColumn();
        $toplamSayfa = ceil($toplamKayit / $limit);
        $sql = "SELECT * FROM isletme WHERE 1";
        if ($kategoriFiltre && $kategoriFiltre != '') {
            $sql .= " AND kategori = :kategori";
        }
        if ($lokasyonFiltre) {
            $sql .= " AND isletme_konumu LIKE :lokasyon";
        }
        $sql .= " ORDER BY ortalama_yildiz DESC, id DESC LIMIT :limit OFFSET :offset";
        $sorgu = $conn->prepare($sql);
        if ($kategoriFiltre && $kategoriFiltre != '') {
            $sorgu->bindValue(':kategori', $kategoriFiltre, PDO::PARAM_STR);
        }
        if ($lokasyonFiltre) {
            $sorgu->bindValue(':lokasyon', "%$lokasyonFiltre%", PDO::PARAM_STR);
        }
        $sorgu->bindValue(':limit', $limit, PDO::PARAM_INT);
        $sorgu->bindValue(':offset', $offset, PDO::PARAM_INT);
        $sorgu->execute();
        $isletmeler = $sorgu->fetchAll(PDO::FETCH_ASSOC);
        foreach ($isletmeler as $isletme) {
        ?>
          <div class="d-block d-md-flex listing-horizontal">
              <a href="isletme-detay.php?id=<?php echo $isletme['id']; ?>" class="img d-block" style="background-image: url('../images/<?php echo htmlspecialchars($isletme['isletme_resim']); ?>')">
                <?php
                $stmtKategori = $conn->prepare("SELECT kategori FROM kategoriler WHERE id = :kategori");
                $stmtKategori->execute([':kategori' => $isletme['kategori']]);
                $kategori = $stmtKategori->fetch(PDO::FETCH_ASSOC);
                ?>
                <span class="category"><?php echo htmlspecialchars($kategori['kategori']); ?></span>
              </a>
            <div class="lh-content">
              <h3><a href="isletme-detay.php?id=<?php echo $isletme['id']; ?>"><?php echo htmlspecialchars($isletme['isletme_adi']); ?></a></h3>
              <p><?php echo htmlspecialchars($isletme['isletme_konumu']); ?></p>
              <p>
                <?php
                $puan = round($isletme['ortalama_yildiz']);
                for ($i = 0; $i < 5; $i++) {
                  echo $i < $puan
                    ? '<span class="icon-star text-warning"></span>'
                    : '<span class="icon-star text-secondary"></span>';
                }
                $stmtYorum = $conn->prepare("SELECT COUNT(*) AS yorum_sayisi FROM yorumlar WHERE isletme_id = :id");
                $stmtYorum->execute([':id' => $isletme['id']]);
                $yorum_sayisi = $stmtYorum->fetchColumn();
                ?>
                <span>(<?php echo $yorum_sayisi; ?> yorum)</span>
              </p>
            </div>
          </div>
        <?php } ?>
        <div class="pagination mt-4">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <?php if ($sayfa > 1): ?>
                <li class="page-item"><a class="page-link" href="?sayfa=<?php echo $sayfa - 1; ?>">Geri</a></li>
              <?php endif; ?>
              <?php for ($i = 1; $i <= $toplamSayfa; $i++): ?>
                <li class="page-item <?php echo ($i == $sayfa) ? 'active' : ''; ?>">
                  <a class="page-link" href="?sayfa=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>
              <?php if ($sayfa < $toplamSayfa): ?>
                <li class="page-item"><a class="page-link" href="?sayfa=<?php echo $sayfa + 1; ?>">İleri</a></li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </div>
      <div class="col-lg-3 ml-auto">
        <div class="mb-5">
          <h3 class="h5 text-black mb-3">Filtreler</h3>
          <form action="" method="post">
            <div class="form-group">
              <div class="select-wrap">
                <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                <select class="form-control" name="kategori">
                  <option value="">Tüm Kategoriler</option>
                  <?php
                  $stmt = $conn->prepare("SELECT * FROM kategoriler");
                  $stmt->execute();
                  while ($row = $stmt->fetch()) {
                    $selected = ($row['id'] == $kategoriFiltre) ? 'selected' : '';
                    echo "<option value='{$row['id']}' {$selected}>{$row['kategori']}</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="wrap-icon">
                <span class="icon icon-room"></span>
                <input type="text" name="lokasyon" placeholder="Lokasyon" class="form-control" value="<?php echo htmlspecialchars($lokasyonFiltre); ?>">
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Filtrele</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
