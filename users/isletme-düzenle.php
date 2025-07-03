<?php
require_once '../conn.php';
session_start();

// Kullanıcı ID'sini oturumdan alalım (örneğin, 'kullanici_id' session'da saklanıyorsa)
$yoneticiId = $_SESSION['kullanici_id'];

$title = "Destek";
?>
<title>Destek</title>
<link rel="shortcut icon" href="../images/favicon.png">
<link rel="stylesheet" href="../css/ekle.css">

<div class="header-container">
    <div class="header-left">
        <img src="../images/işletme.png" alt="Logo" class="logo">
        <h1 class="panel-title">İşletme Paneli</h1>
    </div>
    <div class="header-right">
      <a href="isletme-ekle.php" class="logout-button">İşletme Ekle</a>
      <a href="index.php" class="logout-button">Geri Dön</a>
    </div>
</div>

<style>
  .listing-horizontal {
    display: flex;
    margin-bottom: 30px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }

  .listing-horizontal .img {
    width: 250px;
    height: 180px;
    background-size: cover;
    background-position: center;
    position: relative;
    text-decoration: none;
  }

  .listing-horizontal .category {
    position: absolute;
    bottom: 0;
    left: 0;
    background: #ff5a5f;
    color: white;
    padding: 5px 10px;
    font-size: 14px;
    border-top-right-radius: 8px;
  }

  .listing-horizontal .lh-content {
    padding: 20px;
    flex: 1;
    position: relative;
  }

  .listing-horizontal .lh-content h2 {
    margin-top: 0;
    margin-bottom: 10px;
    color: #ff5a5f;
  }

  .listing-horizontal .lh-content p {
    margin: 5px 0;
  }

  .listing-horizontal .bookmark {
    position: absolute;
    right: 20px;
    top: 20px;
    color: #ccc;
    font-size: 20px;
    text-decoration: none;
  }

  .actions {
    margin-top: 10px;
  }

  .edit-btn,
  .delete-btn {
    padding: 6px 12px;
    font-size: 14px;
    margin-right: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
    text-decoration: none;
    display: inline-block;
  }

  .edit-btn {
    background-color: #4CAF50;
  }

  .delete-btn {
    background-color: #f44336;
  }
</style>

<div class="dashboard-content">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 dashboard-list-box">
        <center><h4 class="gray">İşletmeleri Düzenle</h4></center>

        <?php
        // Kullanıcı ID'sine göre sorgu yapalım
        $stmt = $conn->prepare("SELECT isletme.*, kategoriler.kategori
        FROM isletme
        LEFT JOIN kategoriler ON isletme.kategori = kategoriler.id
        WHERE isletme.yoneticiid = :yoneticiid"); // Filtreleme işlemi eklendi
        $stmt->bindParam(':yoneticiid', $yoneticiId, PDO::PARAM_INT);
        $stmt->execute();

        // İlgili kullanıcıya ait işletmeleri listeleyelim
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="listing-horizontal">
              <a href="#" class="img d-block" style="background-image: url('<?= $row['isletme_resim']; ?>')">
                <span class="category"><?= htmlspecialchars($row['kategori']) ?></span>
              </a>

              <div class="lh-content">
                <h2><?= htmlspecialchars($row['isletme_adi']) ?></h2>
                <p><?= htmlspecialchars($row['isletme_konumu']) ?></p>
                <p><?= htmlspecialchars($row['yonetici_adi']) ?> tarafından yönetiliyor</p>

                <div class="actions">
                  <a class="edit-btn" href="düzenle-isletme.php?blogid=<?= $row['id'] ?>">Düzenle</a>
                  <a class="delete-btn" href="sil.php?isletmeid=<?= $row['id'] ?>" onclick="return confirm('İşletmeyi silmek istediğinizden emin misiniz?')">Sil</a>
                </div>
              </div>
            </div>
            <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
