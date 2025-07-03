<?php
ob_start();
session_start();
require_once 'header.php';

// Admin ekleme işlemi
if (isset($_POST['gonder'])) {
    // Verileri al
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $posta = $_POST['mail'];
    $sifre = password_hash($_POST['yeni_sifre'], PASSWORD_BCRYPT); // Şifreyi şifrele
    $hakkimda = isset($_POST['hakkimda']) ? $_POST['hakkimda'] : $user['hakkimda'];
    $etiket = $_POST['etiket'];
    $rol = $_POST['rol'];
    $sosyalmedya = $_POST['sosyalmedya'];

    // Resim dosyasını yükle
    $targetDir = "../uploads/"; // Yükleme dizini
    $fileName = basename($_FILES["yeni_resim"]["name"]);
    $newFilePath = "uploads/" . $fileName; // Veritabanına sadece 'uploads/' yolunu kaydedeceğiz

    if ($_FILES['yeni_resim']['error'] == 0) {
        move_uploaded_file($_FILES["yeni_resim"]["tmp_name"], $targetDir . $fileName); // Dosyayı yükle
    } else {
        $newFilePath = ''; // Resim yüklenmemişse boş bırak
    }

    // Veritabanına ekle
    $sql = "INSERT INTO admins (ad, soyad, email, sifre,hakkimda, etiket, rol, sosyalmedya, resim)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$ad, $soyad, $posta, $sifre, $hakkimda, $etiket, $rol, $sosyalmedya, $newFilePath]);

    header("Location: admin-ekle.php?ekle=ok");
    exit;
}
?>

<div class="dashboard-content">
    <div class="dashboard-form">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 ">
                <div class="dashboard-list-box">
                    <h4 class="gray">Profil Resmi ve Pozisyon</h4>
                    <div class="dashboard-list-box-static">
                    <form action="" method="POST" enctype="multipart/form-data">
                            <label>Ad</label>
                            <input name="ad" type="text" required>

                            <label>Soyad</label>
                            <input name="soyad" type="text" required>

                            <label>E-Posta</label>
                            <input name="mail" type="text" required>

                            <label>Şifre</label>
                            <input name="yeni_sifre" type="password" required>

                            <label>Etiketler</label>
                            <input name="etiket" type="text">

                            <label>Sosyal Medya</label>
                            <input name="sosyalmedya" type="text">

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12 padding-right-30">
                <div class="dashboard-list-box">
                    <h4 class="gray">Yeni Admin Ekle</h4>
                    <div class="dashboard-list-box-static">

                            <label>Profil Resmi</label>
                            <input type="file" name="yeni_resim"><br><br>

                            <label>Pozisyon</label>
                            <input name="rol" type="text"><br><br>
                            <label>Hakkımda</label>
                            <textarea name="hakkimda"></textarea><br><br>
                            <button name="gonder" class="button">Admin Ekle</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
