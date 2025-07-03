<?php
require_once '../conn.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$kullaniciAd = isset($_SESSION['kullanici_ad']) ? $_SESSION['kullanici_ad'] : 'Bilinmeyen';
$kullaniciRol = isset($_SESSION['kullanici_rol']) && $_SESSION['kullanici_rol'] != '' ? $_SESSION['kullanici_rol'] : null;
$kim = $kullaniciRol ? "$kullaniciAd $kullaniciRol" : $kullaniciAd;

if (isset($_GET['isletmeid'])) {
    $isletmeID = $_GET['isletmeid'];
    $sql = "DELETE FROM isletme WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$isletmeID]);

    if ($stmt) {
        header("location: isletme-düzenle.php");
    }
}
?>
