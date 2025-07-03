<?php
ob_start();
require_once 'header.php';
require_once '../conn.php';
require_once 'loglar.php';
$adminAdi = isset($_SESSION['kullanici']) ? $_SESSION['kullanici'] : 'Bilinmeyen Kullanıcı';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Istanbul');
if (isset($_SESSION['isletme_basarili'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['isletme_basarili'], ENT_QUOTES) . "');</script>";
    unset($_SESSION['isletme_basarili']);
}
if (isset($_SESSION['kat_basarili'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['kat_basarili'], ENT_QUOTES) . "');</script>";
    unset($_SESSION['kat_basarili']);
}
if (isset($_SESSION['et_basarili'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['et_basarili'], ENT_QUOTES) . "');</script>";
    unset($_SESSION['et_basarili']);
}
?>
<div class="dashboard-content">
    <div class="dashboard-form">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 padding-right-30">
                <div class="dashboard-list-box">
                    <h4 class="gray">Kategori Ekle</h4>
                    <form action="" method="POST">
                        <label>Kategori İsmi</label>
                        <input required name="kat-isim" type="text">
                        <button name="kat-ekle" class="button">Kategori Ekle</button>
                    </form>
                    <?php
                    if (isset($_POST['kat-ekle'])) {
                        try {
                            $katIsim = trim($_POST['kat-isim']);
                            $kontrol = $conn->prepare("SELECT COUNT(*) FROM kategoriler WHERE kategori = ?");
                            $kontrol->execute([$katIsim]);
                            $varMi = $kontrol->fetchColumn();
                            if ($varMi > 0) {
                                echo "<div style='color:red;'>Bu kategori zaten mevcut!</div>";
                            } else {
                                $sql = "INSERT INTO kategoriler (kategori, tarih) VALUES (?, ?)";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute([$katIsim, date("Y-m-d H:i:s")]);
                                logla($conn, "Yeni Kategori Eklendi", "$adminAdi yeni bir kategori ekledi!");
                                $_SESSION['kat_basarili'] = "Kategori başarıyla eklendi.";
                                header("Location: ".$_SERVER['PHP_SELF']);
                                exit;
                            }
                        } catch (PDOException $e) {
                            echo "<div style='color:red;'>Hata: " . $e->getMessage() . "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="dashboard-list-box">
                    <h4 class="gray">İşletme Ekle</h4>
                    <div class="dashboard-list-box-static">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="edit-profile-photo">
                                <img src="images/user-avatar.jpg" alt="">
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i>Resim Yükle</span>
                                        <input type="file" class="upload" name="isletme_resim" required />
                                    </div>
                                </div>
                            </div>
                            <label>İşletme Adı</label>
                            <input required name="isletme_adi" type="text">
                            <label>Kuruluş Tarihi</label>
                            <input required name="kurulus_tarihi" type="date">
                            <label>Personel Sayısı</label>
                            <input required name="personel_sayisi" type="number">
                            <label>Yönetici Adı</label>
                            <input required name="yonetici_adi" type="text">
                            <label>Yönetici Hakkında</label>
                            <textarea name="yonetici_hakkinda" rows="5" required></textarea>
                            <label>İşletme Hakkında</label>
                            <textarea name="isletme_hakkinda" rows="5" required></textarea>
                            <label>Konum</label>
                            <input required name="isletme_konumu" type="text">
                            <label>Telefon</label>
                            <input required name="isletme_tel" type="text">
                            <label>Email</label>
                            <input required name="isletme_gmail" type="email">
                            <label>Kategori</label>
                            <select required name="kategori">
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM kategoriler");
                                $stmt->execute();
                                while ($row = $stmt->fetch()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['kategori'] . "</option>";
                                }
                                ?>
                            </select>
                            <label>Etiketler (virgül ile ayırın)</label>
                            <input name="etiket" type="text">
                            <button name="isletme-ekle" class="button">İşletme Ekle</button>
                        </form>
                        <?php
                        if (isset($_POST['isletme-ekle'])) {
                            try {
                                $isletmeAdi = trim($_POST['isletme_adi']);
                                $kontrol = $conn->prepare("SELECT COUNT(*) FROM isletme WHERE isletme_adi = ?");
                                $kontrol->execute([$isletmeAdi]);
                                $varMi = $kontrol->fetchColumn();
                                if ($varMi > 0) {
                                    echo "<div style='color:red;'>Bu işletme adı zaten mevcut!</div>";
                                } else {
                                    $resimYolu = "";
                                    if (isset($_FILES['isletme_resim'])) {
                                        $hedefKlasor = "../uploads/";
                                        $hedefDosya = $hedefKlasor . basename($_FILES['isletme_resim']['name']);
                                        $geciciDosya = $_FILES['isletme_resim']['tmp_name'];
                                        if (move_uploaded_file($geciciDosya, $hedefDosya)) {
                                            $resimYolu = $hedefDosya;
                                        }
                                    }
                                    $sql = "INSERT INTO isletme (
                                        isletme_adi, kurulus_tarihi, personel_sayisi,
                                        yonetici_adi, yonetici_hakkinda, isletme_hakkinda,
                                        isletme_resim, isletme_konumu, isletme_tel,
                                        isletme_gmail, kategori, etiket
                                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute([
                                        $isletmeAdi,
                                        $_POST['kurulus_tarihi'],
                                        $_POST['personel_sayisi'],
                                        $_POST['yonetici_adi'],
                                        $_POST['yonetici_hakkinda'],
                                        $_POST['isletme_hakkinda'],
                                        $resimYolu,
                                        $_POST['isletme_konumu'],
                                        $_POST['isletme_tel'],
                                        $_POST['isletme_gmail'],
                                        $_POST['kategori'],
                                        $_POST['etiket'],
                                    ]);
                                    // Kategori sayısını güncelle
$kategoriId = $_POST['kategori'];
$guncelle = $conn->prepare("UPDATE kategoriler SET adet = adet + 1 WHERE id = ?");
$guncelle->execute([$kategoriId]);

                                    logla($conn, "Yeni İşletme Eklendi", "$adminAdi yeni bir işletme ekledi!");
                                    $_SESSION['isletme_basarili'] = "İşletme başarıyla eklendi.";
                                    header("Location: " . $_SERVER['PHP_SELF']);
                                    exit;
                                }
                            } catch (PDOException $e) {
                                echo "<div style='color:red;'>Hata: " . $e->getMessage() . "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  fetch('kategori_sayı_getir.php?kategori=Yemek')
    .then(response => response.json())
    .then(data => {
      if (data.sayi !== undefined) {
        document.getElementById('yemek-sayi').innerText = data.sayi;
      } else {
        console.error("Hata:", data.hata);
      }
    })
    .catch(error => {
      console.error("İstek sırasında bir hata oluştu:", error);
    });
</script>
<?php require_once 'footer.php'; ?>
<?php
ob_end_flush();
?>
