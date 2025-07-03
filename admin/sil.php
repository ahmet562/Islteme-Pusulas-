<?php
require_once '../conn.php';
require_once 'loglar.php';

// Oturumu güvenli şekilde başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kullanıcı bilgilerini al
$kullaniciAd = isset($_SESSION['kullanici_ad']) ? $_SESSION['kullanici_ad'] : 'Bilinmeyen';
$kullaniciRol = isset($_SESSION['kullanici_rol']) && $_SESSION['kullanici_rol'] != '' ? $_SESSION['kullanici_rol'] : null;
$kim = $kullaniciRol ? "$kullaniciAd $kullaniciRol" : $kullaniciAd;


if (isset($_GET['mesajid'])) {
    $mesajID = $_GET['mesajid'];
    $sql = "DELETE FROM mesajlar WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$mesajID]);

    if ($stmt) {
        logla($conn, "Mesaj Silindi", "$kim bir mesajı sildi.");
        header("location: mesaj.php");
    }
}

if (isset($_GET['uyeid'])) {
    $uyeID = $_GET['uyeid'];
    $sql = "DELETE FROM kullanicilar WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$uyeID]);

    if ($stmt) {
        logla($conn, "Üye Silindi", "$kim bir üyeyi sildi.");
        header("location: üyeler.php");
    }
}
if (isset($_GET['adminid'])) {
    $adminID = $_GET['adminid'];
    $sql = "DELETE FROM admins WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$adminID]);

    if ($stmt) {
        logla($conn, "Admin Silindi", "$kim bir admini sildi.");
        header("location: adminler.php");
    }
}
if (isset($_GET['yorumid'])) {
    $yorumID = $_GET['yorumid'];
    $sql = "DELETE FROM yorumlar WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$yorumID]);

    if ($stmt) {
        logla($conn, "Yorum Silindi", "$kim bir yorumu sildi.");
        header("location: yorumlar.php");
    }
}

if (isset($_GET['isletmeid'])) {
    $isletmeID = $_GET['isletmeid'];
    $sql = "DELETE FROM isletme WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$isletmeID]);

    if ($stmt) {
        logla($conn, "İşletme Silindi", "$kim bir işletme sildi.");
        header("location: isletme-düzenle.php");
    }
}
if (isset($_GET['katid'])) {
    $katID = $_GET['katid'];
    $sql = "DELETE FROM kategoriler WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$katID]);

    if ($stmt) {
        logla($conn, "Kategori Silindi", "$kim bir kategoriyi sildi.");
        header("location: kat-düzenle.php");
    }
}

if (isset($_GET['etid'])) {
    $etID = $_GET['etid'];
    $sql = "DELETE FROM etiketler WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$etID]);

    if ($stmt) {
        logla($conn, "Etiket Silindi", "$kim bir etiketi sildi.");
        header("location: kat-düzenle.php");
    }
}

if (isset($_GET['sliderid'])) {
    $sliderID = $_GET['sliderid'];
    $sql = "DELETE FROM slider WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$sliderID]);

    if ($stmt) {
        logla($conn, "Slider Silindi", "$kim bir slider öğesini sildi.");
        header("location: slider-düzenle.php");
    }
}

?>
