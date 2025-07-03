<?php
ob_start();
require_once '../conn.php';

session_start(); // Eğer daha önce yapılmadıysa

$adminAdi = isset($_SESSION['kullanici']) ? $_SESSION['kullanici'] : 'Bilinmeyen Kullanıcı';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Istanbul');

// Bildirim mesajları
foreach (['isletme_basarili', 'kat_basarili', 'et_basarili'] as $key) {
    if (isset($_SESSION[$key])) {
        echo "<script>alert('" . htmlspecialchars($_SESSION[$key], ENT_QUOTES) . "');</script>";
        unset($_SESSION[$key]);
    }
}
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
        <a href="index.php" class="logout-button">Geri Dön</a>
    </div>
</div>
<div class="dashboard-content">
    <div class="dashboard-form">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="dashboard-list-box">
                    <h4 class="gray">İşletme Ekle</h4>
                    <div class="dashboard-list-box-static">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="edit-profile-photo">
                                <label for="isletme_resim" class="change-photo-btn" style="cursor:pointer;">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Resim Yükle</span>
                                    </div>
                                </label>
                                <img id="resim-onizleme" src="images/user-avatar.jpg" alt="" style="max-width: 100%; height: auto;">
                                <input type="file" id="isletme_resim" name="isletme_resim" style="display:none;" accept="image/*" required />
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
                                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['kategori']) . "</option>";
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
                                    if (isset($_FILES['isletme_resim']) && $_FILES['isletme_resim']['error'] === 0) {
                                        $hedefKlasor = "../uploads/";
                                        $dosyaAdi = basename($_FILES['isletme_resim']['name']);
                                        $hedefDosya = $hedefKlasor . $dosyaAdi;
                                        $geciciDosya = $_FILES['isletme_resim']['tmp_name'];

                                        if (move_uploaded_file($geciciDosya, $hedefDosya)) {
                                            $resimYolu = $hedefDosya;
                                        }
                                    }

                                    // Kullanıcı ID'sini al
                                    $yoneticiId = $_SESSION['kullanici_id'];  // Örneğin, kullanıcı ID'si oturumda saklanıyorsa

                                    // SQL sorgusu güncellendi: yoneticiid ekleniyor
                                    $sql = "INSERT INTO isletme (
                                        isletme_adi, kurulus_tarihi, personel_sayisi,
                                        yonetici_adi, yonetici_hakkinda, isletme_hakkinda,
                                        isletme_resim, isletme_konumu, isletme_tel,
                                        isletme_gmail, kategori, etiket, yoneticiid
                                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
    $yoneticiId,
]);

// ✅ Kategoriye ait adet sayısını 1 artır
$kategoriId = $_POST['kategori'];
$guncelle = $conn->prepare("UPDATE kategoriler SET adet = adet + 1 WHERE id = ?");
$guncelle->execute([$kategoriId]);

echo "<script>
    alert('İşletmeniz başarıyla eklendi.');
    window.location.href = 'index.php';
</script>";
exit;

                                }
                            } catch (PDOException $e) {
                                echo "<div style='color:red;'>Hata: " . htmlspecialchars($e->getMessage()) . "</div>";
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
// Kategori sayısını getir (örnek kullanım)
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
<script>
document.getElementById('isletme_resim').addEventListener('change', function(event) {
    const dosya = event.target.files[0];
    if (dosya) {
        const okuyucu = new FileReader();
        okuyucu.onload = function(e) {
            document.getElementById('resim-onizleme').src = e.target.result;
        };
        okuyucu.readAsDataURL(dosya);
    }
});
</script>
<?php ob_end_flush(); ?>
