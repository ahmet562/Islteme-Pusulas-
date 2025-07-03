<?php
require_once '../conn.php';
session_start(); // Oturum başlat

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $isletme_id = (int)$_POST['isletme_id'];
  $yorum = trim($_POST['message']);
  $puan = (int)$_POST['rating'];

  // Kullanıcı giriş yapmış mı ve diğer alanlar geçerli mi kontrolü
  if ($isletme_id && $yorum && $puan >= 1 && $puan <= 5) {
    // Yorumları veritabanına ekleme
    $stmt = $conn->prepare("INSERT INTO yorumlar (isletme_id, yildiz, yorum)
                            VALUES (:isletme_id, :puan, :yorum)");
    $stmt->execute([
      ':isletme_id' => $isletme_id,
      ':puan' => $puan,
      ':yorum' => $yorum
    ]);

    // Ortalama puanı hesaplama
    $stmt = $conn->prepare("SELECT AVG(yildiz) AS ortalama_yildiz, COUNT(*) AS yorum_sayisi
                            FROM yorumlar WHERE isletme_id = :isletme_id");
    $stmt->execute([':isletme_id' => $isletme_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $ortalama_yildiz = $result['ortalama_yildiz'] ?? 0;
    $yorum_sayisi = $result['yorum_sayisi'] ?? 0;

    if ($yorum_sayisi > 0) {
      $stmt = $conn->prepare("UPDATE isletme SET ortalama_yildiz = :ortalama_yildiz WHERE id = :isletme_id");
      $stmt->execute([
        ':ortalama_yildiz' => round($ortalama_yildiz, 2),
        ':isletme_id' => $isletme_id
      ]);
    }
  }

  header("Location: isletme-detay.php?id=" . $isletme_id);
  exit;
}
?>
