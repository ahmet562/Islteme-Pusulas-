<?php
ob_start();
require_once 'header.php';
require_once '../conn.php';
require_once 'loglar.php'; ?>
<div class="dashboard-content">
    <div class="dashboard-form">
        <div class="row">

            <!-- Profile -->
            <div class="col-lg-6 col-md-6 col-xs-12 padding-right-30">
                <div class="dashboard-list-box">
                    <h4 class="gray">Üye Güncelle</h4>
                    <div class="dashboard-list-box-static">

                        <?php
                        if (isset($_GET['uyeid'])) {
                            $id = $_GET['uyeid'];
                            $stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE id=?");
                            $stmt->execute([$id]);
                            $user = $stmt->fetch();

                            if (isset($_POST['gonder'])) {
                                $ad = $_POST['ad'];
                                $soyad = $_POST['soyad'];
                                $posta = $_POST['posta'];
                                $sifre = $_POST['sifre'];

                                // Şifreyi hash'leyelim
                                $hashedSifre = password_hash($sifre, PASSWORD_BCRYPT);

                                // Veritabanına güncelleme yapalım
                                $sql = "UPDATE kullanicilar SET ad=?, soyad=?, eposta=?, sifre=? WHERE id=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute([$ad, $soyad,  $posta, $hashedSifre, $id]);

                                logla($conn, "Üye Güncellendi", "Admin bir üye güncelledi!");
                            }
                        } else {
                            header('location: index.php');
                        }
                        ?>


                        <form action="" method="POST">
                            <label>Üye Ad</label>
                            <input name="ad" value="<?= htmlspecialchars($user[1]) ?>" type="text">

                            <label>Üye Soyad</label>
                            <input name="soyad" value="<?= htmlspecialchars($user[2]) ?>" type="text">

                            <label>Üye E-Posta</label>
                            <input name="posta" value="<?= htmlspecialchars($user[3]) ?>" type="text">

                            <label>Üye Şifre</label>
                            <input name="sifre" type="text">

                            <label>Üye Kayıt Tarihi</label>
                            <input disabled name="twit" value="<?= htmlspecialchars($user[6]) ?>" type="text">
                            <button name="gonder" class="button">Güncelle</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Content / End -->
<?php require_once 'footer.php'; ?>
