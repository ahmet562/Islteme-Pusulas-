<?php
require_once '../conn.php';

if (isset($_POST['mesajid']) && isset($_POST['okundu'])) {
    $stmt = $conn->prepare("UPDATE mesajlar SET okundu = :okundu WHERE id = :id");
    $stmt->execute([
        ':okundu' => $_POST['okundu'],
        ':id' => $_POST['mesajid']
    ]);
    echo "ok";
} else {
    echo "Eksik veri";
}
?>
