<?php require_once 'header.php';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = (int)$_GET['id'];
} else {
  die("Geçersiz ya da eksik ID.");
}
$stmt = $conn->prepare("SELECT * FROM isletme WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$isletme = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$isletme) {
  die("İşletme bulunamadı.");
}
?>
<style>
.rating-display {
  display: inline-flex;
  align-items: center;
  font-size: 1.5rem;
}

.star {
  color: #ddd;
  position: relative;
  display: inline-block;
  width: 1em;
  height: 1em;
}

.star.full::before,
.star.half::before,
.star.empty::before {
  content: '★';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.star.full::before {
  color: #FFD700;
}

.star.half::before {
  color: #FFD700;
  width: 50%;
  overflow: hidden;
}

.star.half::after {
  content: '★';
  color: #ddd;
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}

.star.empty::before {
  color: #ddd;
}

.rating-score {
  margin-left: 8px;
  font-size: 1rem;
  color: #555;
}
.star.half .star-fill {
  width: 50%;
}

</style>

    <div class="container">
      <div class="row align-items-center justify-content-center text-center">
        <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
          <div class="row justify-content-center">
            <div class="col-md-8 text-center">
            <h1><?php echo htmlspecialchars($isletme['isletme_adi']); ?></h1>
              <p data-aos="fade-up" data-aos-delay="100">Yayınlanma Tarihi: <?php echo date("d M Y", strtotime($isletme['tarih'])); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
            <p class="mb-4">
              <img src="../images/<?php echo htmlspecialchars($isletme['isletme_resim']); ?>"
                  alt="<?php echo htmlspecialchars($isletme['isletme_adi']); ?>"
                  class="img-fluid rounded">
            </p>
            <h3>Hakkımızda</h3>
            <p><?php echo nl2br(htmlspecialchars($isletme['isletme_hakkinda'])); ?></p>
            <div class="comment-form-wrap pt-5">
              <h3 class="mb-5">Yorum Yap</h3>
              <form action="yorum_yap.php" method="POST" class="p-5 bg-light">
                <input type="hidden" name="isletme_id" value="<?php echo $id; ?>">
                <div class="form-group">
                  <label for="rating">Puanınız (1-5): *</label>
                  <div class="rating">
                    <input type="radio" name="rating" value="5" id="star5" required><label for="star5">&#9733;</label>
                    <input type="radio" name="rating" value="4" id="star4"><label for="star4">&#9733;</label>
                    <input type="radio" name="rating" value="3" id="star3"><label for="star3">&#9733;</label>
                    <input type="radio" name="rating" value="2" id="star2"><label for="star2">&#9733;</label>
                    <input type="radio" name="rating" value="1" id="star1"><label for="star1">&#9733;</label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="message">Yorumunuz *</label>
                  <textarea name="message" id="message" cols="30" rows="5" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                  <input type="submit" value="Yorumu Gönder" class="btn btn-primary text-white">
                </div>
              </form>
            </div>
            <?php
              $stmtYorum = $conn->prepare("SELECT * FROM yorumlar WHERE isletme_id = :isletme_id ORDER BY yorum_tarihi DESC");
              $stmtYorum->bindValue(':isletme_id', $id, PDO::PARAM_INT);
              $stmtYorum->execute();
              $yorumlar = $stmtYorum->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="pt-5">
              <h3 class="mb-5"><?php echo count($yorumlar); ?> Yorum</h3>
              <ul class="comment-list">
                <?php foreach ($yorumlar as $index => $yorum): ?>
                  <li class="comment <?php echo $index >= 5 ? 'extra-comment d-none' : ''; ?>">
                    <div class="vcard bio">
                      <img src="../images/comment_vcard.jpg" alt="Kullanıcı">
                    </div>
                    <div class="comment-body">
                      <h3><?php echo htmlspecialchars($yorum['yorum_yapan'] ?? 'Anonim'); ?></h3>
                      <div class="meta"><?php echo date("d M Y H:i", strtotime($yorum['yorum_tarihi'])); ?></div>
                      <p><?php echo nl2br(htmlspecialchars($yorum['yorum'])); ?></p>
                      <p>Puan: <?php echo str_repeat("★", (int)$yorum['yildiz']); ?></p>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
              <?php if (count($yorumlar) > 5): ?>
                <div class="text-center mt-3">
                  <button id="loadMoreBtn" class="btn btn-outline-primary">Daha Fazla Yorum Göster</button>
                </div>
              <?php endif; ?>
            </div>
        </div>
        <div class="col-md-3 ml-auto">
        <?php
$gercekOrtalama = (float)$isletme['ortalama_yildiz'];
$tamYildiz = round($gercekOrtalama); // Görsel için tam yıldız sayısı
$bosYildiz = 5 - $tamYildiz;
?>
<div class="rating-display">
  <?php for ($i = 0; $i < $tamYildiz; $i++): ?>
    <span class="star full">&#9733;</span>
  <?php endfor; ?>
  <?php for ($i = 0; $i < $bosYildiz; $i++): ?>
    <span class="star empty">&#9733;</span>
  <?php endfor; ?>
  <span class="rating-score">(<?php echo number_format($gercekOrtalama, 1, ',', '.'); ?>)</span>
</div>

        <br>
        <h3>Yönetici: <?php echo htmlspecialchars($isletme['yonetici_adi']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($isletme['yonetici_hakkinda'])); ?></p>
        <p><strong>Personel Sayısı:</strong> <?php echo (int)$isletme['personel_sayisi']; ?></p>
        <p><strong>Kuruluş Tarihi:</strong> <?php echo date("d.m.Y", strtotime($isletme['kurulus_tarihi'])); ?></p>
        <p><strong>Konum:</strong> <?php echo htmlspecialchars($isletme['isletme_konumu']); ?></p>
        <p><strong>Telefon:</strong> <?php echo htmlspecialchars($isletme['isletme_tel']); ?></p>
        <p><strong>E-posta:</strong> <a href="mailto:<?php echo htmlspecialchars($isletme['isletme_gmail']); ?>">
          <?php echo htmlspecialchars($isletme['isletme_gmail']); ?></a></p>
          <div>
              <p>Kategori: <a href="#"><?php echo htmlspecialchars($isletme['kategori']); ?></a>
              </p>
              <p>
                Etiketler:
                <?php
                  $etiketler = explode(',', $isletme['etiket']);
                  foreach ($etiketler as $etiket) {
                    echo '<a href="#">#' . trim(htmlspecialchars($etiket)) . '</a> ';
                  }
                ?>
              </p>
            </div>
        </div>
      </div>
    </div>
  </div>
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const loadMoreBtn = document.getElementById("loadMoreBtn");
    if (loadMoreBtn) {
      loadMoreBtn.addEventListener("click", function () {
        document.querySelectorAll(".extra-comment").forEach(el => el.classList.remove("d-none"));
        loadMoreBtn.style.display = "none";
      });
    }
  });
</script>

  <?php require_once './footer.php'; ?>
