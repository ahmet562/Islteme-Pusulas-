<?php
ob_start();
require_once '../conn.php';
date_default_timezone_set('Europe/Istanbul');
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
      <a href="isletme-düzenle.php" class="logout-button">Geri Dön</a>
    </div>
</div>
<div class="dashboard-content">
    <div class="dashboard-form">
        <div class="row">
            <!-- Sol Kısım: İşletme ve Yönetici Bilgileri -->
            <div class="col-lg-6 col-md-6 col-xs-12 padding-right-30">
                <div class="dashboard-list-box">
                    <h1 class="gray">İşletme ve Yönetici Diğer Bilgiler</h1>
                    <div class="dashboard-list-box-static">
                        <?php
                        if (isset($_GET['blogid'])) {
                            $id = $_GET['blogid'];
                            $stmt = $conn->prepare("SELECT * FROM isletme WHERE id=?");
                            $stmt->execute([$id]);
                            $user = $stmt->fetch();
                        } else {
                            header('location: isletme-düzenle.php');
                            exit;
                        }

                        $ikonPath = $user[8]; // Mevcut resim yolu

                        if (isset($_POST['ekle'])) {
                            $id = $_GET['blogid'];

                            // Yeni resim varsa işle
                            if (isset($_FILES['resim']) && $_FILES['resim']['size'] > 0) {
                                $targetDir = "../uploads/";
                                $targetFile = $targetDir . basename($_FILES['resim']['name']);
                                $tempFile = $_FILES['resim']['tmp_name'];

                                // Eski resmi sil
                                if (!empty($ikonPath) && file_exists($ikonPath)) {
                                    unlink($ikonPath);
                                }

                                // Yeni resmi yükle
                                if (move_uploaded_file($tempFile, $targetFile)) {
                                    $ikonPath = $targetFile;
                                }
                            }

                            // Diğer alanlar
                            $baslik = $_POST['baslik'];
                            $icerik = $_POST['icerik'];
                            $baslik2 = $_POST['baslik2'];
                            $icerik2 = $_POST['icerik2'];
                            $etiketler = $_POST['etiket'];
                            $tarih = $_POST['tarih'];
                            $kategori = $_POST['kategori'];
                            $sayi = $_POST['sayi'];
                            $konum = $_POST['konum'];
                            $tel = $_POST['tel'];
                            $mail = $_POST['mail'];

                            // Veritabanı güncelle
                            $sql = "UPDATE isletme SET
                                isletme_adi=?, isletme_hakkinda=?, yonetici_adi=?, yonetici_hakkinda=?,
                                etiket=?, kurulus_tarihi=?, isletme_resim=?, personel_sayisi=?,
                                isletme_konumu=?, isletme_tel=?, isletme_gmail=?, kategori=?
                                WHERE id=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([
                                $baslik, $icerik, $baslik2, $icerik2, $etiketler,
                                $tarih, $ikonPath, $sayi, $konum, $tel, $mail, $kategori, $id
                            ]);
                            echo "<script>alert('İşletme başarıyla güncellendi.'); window.location='isletme-düzenle.php';</script>";
                            exit;
                        }
                        ?>

                        <form action="" method="POST" enctype="multipart/form-data">

                           <div class="edit-profile-photo">
                                <!-- Varsayılan veya Mevcut Resim -->
                                <img id="resim-onizleme"
                                    src="<?= (!empty($ikonPath) && file_exists($ikonPath)) ? $ikonPath : '../images/user-avatar.jpg' ?>"
                                    alt="İşletme Resmi"
                                    style="max-width: 200px; height: auto; border: 1px solid #ccc; margin-bottom: 10px;">

                                <!-- Yükleme Butonu -->
                                <label for="isletme_resim" class="change-photo-btn" style="display:inline-block; background:#ff5a5f; color:#fff; padding:10px 15px; border-radius:5px; cursor:pointer;">
                                    <i class="fa fa-upload"></i> Yeni Resim Seç
                                </label>
                                <input type="file" id="isletme_resim" name="resim" accept="image/*" style="display: none;">
                            </div>
                            <label>İşletme Adı</label>
                            <input required name="baslik" type="text" value="<?= $user[2] ?>">

                            <label>İşletme Hakkında</label>
                            <textarea name="icerik" cols="30" required rows="5"><?= $user[7] ?></textarea>

                            <label>Kuruluş Tarihi</label>
                            <input required name="tarih" type="text" value="<?= $user[3] ?>">

                            <label>Yönetici Adı</label>
                            <input required name="baslik2" type="text" value="<?= $user[5] ?>">

                            <label>Yönetici Hakkında</label>
                            <textarea name="icerik2" cols="30" required rows="6"><?= $user[6] ?></textarea>
                            <label>Etiket</label>
                            <input name="etiket" type="text" value="<?= $user[13] ?>">

                            <label>Personel Sayısı</label>
                            <input required name="sayi" type="text" value="<?= $user[4] ?>">

                            <label>İşletme Konumu</label>
                            <input required name="konum" type="text" value="<?= $user[9] ?>">
                            <label>Telefon Numarası</label>
                            <input required name="tel" type="text" value="<?= $user[10] ?>">

                            <label>E-Posta</label>
                            <input required name="mail" type="text" value="<?= $user[11] ?>">

                            <label>Kategori</label>
                            <select required name="kategori">
                                <?php
                                $katID = $user[12]; // Bu ID, işletmeye ait kategori ID'si
                                $stmt = $conn->prepare("SELECT * FROM kategoriler");
                                $stmt->execute();
                                while ($row = $stmt->fetch()) {
                                    $selected = ($katID == $row['id']) ? "selected" : "";
                                    echo "<option value='{$row['id']}' $selected>{$row['kategori']}</option>";
                                }
                                ?>
                            </select>

                            <button name="ekle" class="button">İşletme Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('isletme_resim').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('resim-onizleme');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?php ob_end_flush(); ?>
