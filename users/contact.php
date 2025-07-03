<?php
require_once 'header.php';
if (isset($_SESSION['kullanici_id'])) {
  $ad = isset($_SESSION['kullanici_ad']) ? $_SESSION['kullanici_ad'] : '';
  $soyad = isset($_SESSION['kullanici_soyad']) ? $_SESSION['kullanici_soyad'] : '';
  $email = isset($_SESSION['kullanici_eposta']) ? $_SESSION['kullanici_eposta'] : '';
} else {
  $ad = '';
  $soyad = '';
  $email = '';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adsoyad = $_POST['adsoyad'];
    $email = $_POST['email'];
    $mesaj = $_POST['message'];
    $sql = "INSERT INTO mesajlar (ad, email, mesaj, tarih, okundu) VALUES (?, ?, ?, CURRENT_TIMESTAMP(), 0)";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$adsoyad, $email, $mesaj]);
        $_SESSION['success_message'] = "Mesajınız başarıyla gönderildi.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Mesaj gönderilirken bir hata oluştu: " . $e->getMessage() . "</div>";
    }
}
?>
<div class="container">
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
        unset($_SESSION['success_message']);
    }
    ?>
    <div class="row align-items-center justify-content-center text-center">
        <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1>İletişim</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-7 mb-5" data-aos="fade">
                <form action="" method="POST" class="p-5" style="margin-top: -150px; background-color: hsl(198, 73%, 90%);">
                    <div class="row form-group">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-black" for="fname">Adın</label>
                            <input type="text" id="fname" name="adsoyad" class="form-control" value="<?php echo htmlspecialchars($ad); ?>" <?php echo isset($_SESSION['kullanici_ad']) ? 'readonly' : ''; ?>>
                        </div>
                        <div class="col-md-6">
                            <label class="text-black" for="lname">Soyadın</label>
                            <input type="text" id="lname" name="soyad" class="form-control" value="<?php echo htmlspecialchars($soyad); ?>" <?php echo isset($_SESSION['kullanici_ad']) ? 'readonly' : ''; ?>>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" <?php echo isset($_SESSION['kullanici_ad']) ? 'readonly' : ''; ?>>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="subject">Açıklama</label>
                            <input type="text" id="subject" name="subject" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="message">Mesaj</label>
                            <textarea name="message" id="message" cols="30" rows="7" class="form-control" placeholder="Notlarınızı veya sorularınızı buraya yazın..."></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="submit" value="Mesajı gönder" class="btn btn-primary btn-md text-white">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5" data-aos="fade" data-aos-delay="100">
                <div class="p-4 mb-3" style="background-color: hsl(198, 73%, 90%);">
                    <h3 class="h5 text-black mb-3">Bizimle iletişime geçin!</h3>
                    <p class="text-black">Bize soru sorun,
                        biz de bilmek istediklerinizi yanıtlayalım.</p>
                    <p class="mb-0 font-weight-bold text-black">Email Adresimiz</p>
                    <p class="mb-0"><a href="#">youremail@domain.com</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'footer.php';
?>
