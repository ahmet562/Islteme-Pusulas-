<?php
session_start();
date_default_timezone_set('Europe/Istanbul');

require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kayıt formu
    if (isset($_POST['form_tipi']) && $_POST['form_tipi'] === 'kayit') {
        $ad = $_POST['ad'];
        $soyad = $_POST['soyad'];
        $email = $_POST['email'];
        $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);

        try {
            // Aynı e-posta ile kullanıcı var mı kontrolü
            $kontrol = $conn->prepare("SELECT COUNT(*) FROM kullanicilar WHERE eposta = :email");
            $kontrol->execute([':email' => $email]);
            $say = $kontrol->fetchColumn();

            if ($say > 0) {
                $_SESSION['mesaj'] = "Bu e-posta adresiyle zaten bir hesap var!";
                header("Location: ".$_SERVER['PHP_SELF']);
                exit;
            }

            $tarih = date('Y-m-d H:i:s'); // Şu anki tarih-saat

            $sql = "INSERT INTO kullanicilar (ad, soyad, eposta, sifre, tarih)
                    VALUES (:ad, :soyad, :email, :sifre, :tarih)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':ad' => $ad,
                ':soyad' => $soyad,
                ':email' => $email,
                ':sifre' => $sifre,
                ':tarih' => $tarih
            ]);

            $_SESSION['mesaj'] = "Kayıt başarılı!";
            header("Location: signup.php");
            exit;
        } catch (PDOException $e) {
            $_SESSION['mesaj'] = "Hata: " . $e->getMessage();
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Giriş formu
if (isset($_POST['login_ad']) && isset($_POST['login_sifre'])) {
    $email = $_POST['login_ad'];
    $sifre = $_POST['login_sifre'];

    try {
        // 1. Önce admins tablosunda ara
        $adminQuery = $conn->prepare("SELECT * FROM admins WHERE email= :email");
        $adminQuery->execute([':email' => $email]);
        $admin = $adminQuery->fetch(PDO::FETCH_ASSOC);
        if ($admin) {
            if (password_verify($sifre, $admin['sifre'])) {
                echo "Admin şifresi doğru, yönlendiriyorum.";
                // Gerçek yönlendirme
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_ad'] = $admin['ad'];
                $_SESSION['giris_basarili'] = true;

                header("Location: admin/index.php");
                exit;
            } else {
                echo "Admin bulundu ama şifre yanlış.";
                exit;
            }
        } else {
            echo "Admin bulunamadı.";
            // Admin bulunamadıysa kullanıcı tablosuna bak
            $stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE eposta = :email");
            $stmt->execute([':email' => $email]);
            $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($kullanici && password_verify($sifre, $kullanici['sifre'])) {
                $_SESSION['kullanici_id'] = $kullanici['id'];
                $_SESSION['kullanici_ad'] = $kullanici['ad'];
                $_SESSION['kullanici_soyad'] = $kullanici['soyad'];
                $_SESSION['kullanici_eposta'] = $kullanici['eposta'];
                $_SESSION['giris_basarili'] = true;

                header("Location: users/index.php");
                exit;
            } else {
                echo "Kullanıcı da bulunamadı veya şifre yanlış.";
                exit;
            }
        }

    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
        exit;
    }
}


}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="shortcut icon" href="images/favicon.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<?php
if (isset($_SESSION['mesaj'])) {
    echo "<script>alert('" . $_SESSION['mesaj'] . "');</script>";
    unset($_SESSION['mesaj']); // Mesajı sadece bir kez göster
}
?>

<div class="site-blocks-cover overlay" style="background-image: url(images/hero_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <!-- Giriş Formu -->
        <div class="form-box login">
            <form action="#" method="post">
                <h1>Giriş Yap</h1>
                <div class="input-box">
                    <input type="text" placeholder="Kullanıcı Adı" name="login_ad" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Şifre" name="login_sifre" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn">Giriş Yap</button>
            </form>
        </div>

        <!-- Kayıt Ol Formu -->
        <div class="form-box register">
            <form action="" method="post">
                <input type="hidden" name="form_tipi" value="kayit">
                <h1>Kayıt Ol</h1>
                <div class="input-box">
                    <input type="text" name="ad" placeholder="Kullanıcı Adı" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="soyad" placeholder="Kullanıcı Soyadı" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="sifre" placeholder="Şifre" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn" name="kayit">Kayıt Ol</button>
            </form>
        </div>

        <!-- Toggle Box (Kayıt Ol/Giriş Yap) -->
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Merhaba, Hoşgeldiniz!</h1>
                <p>Hesabınız yok mu?</p>
                <button class="btn register-btn">Kayıt Olun</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Tekrar Hoşgeldiniz!</h1>
                <p>Hesabınız var mı?</p>
                <button class="btn login-btn">Giriş Yapın</button>
            </div>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
