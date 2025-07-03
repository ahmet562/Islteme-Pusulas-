<?php
$serverName = "sql112.infinityfree.com";
$username = "if0_38963941";
$password = "Ahmet123698745";
$database = "if0_38963941_isletme_pusulasi";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Bağlantı başarılı!"; // Test için açabilirsin
} catch (PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}
?>

