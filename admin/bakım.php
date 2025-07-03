<?php require_once 'header.php';
require_once 'loglar.php';
?>
<div class="dashboard-content">
     <div class="dashboard-form">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 padding-right-30">
                <div class="dashboard-list-box">
                    <h4 class="gray">Bakım Ayarları</h4>
                    <div class="dashboard-list-box-static">

                        <?php
                        $stmt = $conn->prepare("SELECT*FROM bakımda");
                        $stmt->execute();
                        $user= $stmt->fetch();
                        $logoPath = $user['logo']; // Eski logo yolu

                        if (isset($_POST['guncelle'])) {
                            // Eğer yeni bir logo yüklenmişse, önce eskiyi sil
                            if (isset($_FILES['logofile']) && $_FILES['logofile']['error'] == 0) {
                                // Eski logoyu sil
                                if (file_exists("../" . $logoPath) && $logoPath != 'default-logo.jpg') {
                                    unlink("../" . $logoPath); // Eski resmi sil
                                }

                                // Yeni logo yükleme
                                $targetDir = "uploads/"; // uploads klasörü
                                $targetFile = $targetDir . basename($_FILES["logofile"]["name"]);
                                $tempfile = $_FILES["logofile"]["tmp_name"];

                                if (move_uploaded_file($tempfile, $targetFile)) {
                                    $logoPath = $targetFile; // Yeni resmin yolunu kaydet
                                }
                            }

                            // Diğer veriler
                            $baslik = $_POST['baslik'];
                            $icerik = $_POST['icerik'];
                            $altbaslik = $_POST['altbaslik'];

                            // Veritabanını güncelleme
                            $sql = "UPDATE bakımda SET baslik=?, icerik=?, altbaslik=?, logo=? ";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([$baslik, $icerik, $altbaslik, $logoPath]);

                            if ($stmt->rowCount() > 0) {
                                ?> <script>alert("Bakımda ayarları Güncellendi")</script>
                                <?php
                            }
                            logla($conn, "Ayarlar güncellendi", "Admin bakım ayarlarını güncelledi.");
                        }
                        ?>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="edit-profile-photo">
                                <img src="images/user-avatar.jpg" alt="">
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Logo Yükle</span>
                                        <input type="file" name="logofile" class="upload" />
                                    </div>
                                </div>
                            </div>
                            <label>Logo Yolu <img src="<?= $user['logo']; ?>" style="width: 50px; height: 50px; border-radius: 50%;" alt="Logo">
                            </label>
                            <input name="logoyol" disabled value="<?= $user['logo']; ?>" type="text">
                            <label>Bakımda Başlığı *</label>
                            <input value="<?= $user['baslik']; ?>" name="baslik" type="text">
                            <label>Bakımda Alt Başlık *</label>
                            <input value="<?= $user['altbaslik']; ?>" type="text" name="altbaslik">
                            <label>Bakımda İçerik Yazısı *</label>
                            <input value="<?= $user['icerik']; ?>" type="text" name="icerik">
                            <button class="button" name="guncelle">Değişiklikleri Kaydet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
