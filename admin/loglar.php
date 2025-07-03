<?php
session_start();
require_once '../conn.php';
function logla($conn, $ad, $detay)
{
    $sql = "INSERT INTO loglar (ad, detay, tarih) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$ad, $detay, date("Y-m-d H:i:s")]);
}
date_default_timezone_set('Europe/Istanbul');

?>
