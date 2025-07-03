<?php
require_once 'header.php';
$stmt = $conn->prepare("SELECT * FROM kullanicilar");
$stmt->execute();
echo "Sorgu çalıştı ve " . $stmt->rowCount() . " kullanıcı bulundu.";
?>
<div class="dashboard-content">
    <div class="row">
        <?php
        function kisalt($metin, $uzunluk = 100, $ek = '...')
        {
            if (mb_strlen($metin) <= $uzunluk) {
                return $metin;
            } else {
                return mb_substr($metin, 0, $uzunluk) . $ek;
            }
        }
        $stmt = $conn->prepare("SELECT * FROM kategoriler");
        $stmt->execute();
        $kategoriAdet = $stmt->rowCount();
        $stmt = $conn->prepare("SELECT * FROM isletme");
        $stmt->execute();
        $blogAdet = $stmt->rowCount();
        $stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE rol IS NULL OR rol = ''");
        $stmt->execute();
        $uyelerAdet = $stmt->rowCount();
        $stmt = $conn->prepare("SELECT * FROM yorumlar");
        $stmt->execute();
        $yorumlarAdet = $stmt->rowCount();
        ?>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <a href="kat-düzenle.php">
            <div class="dashboard-stat color-1">
                <div class="dashboard-stat-content">
                    <h4>
                        <?= $kategoriAdet; ?>
                    </h4> <span>Kategoriler</span>
                </div>
                <div class="dashboard-stat-icon"><i class="fa fa-map"></i></div>
                <div class="dashboard-stat-item">
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <a href="isletme-düzenle.php">
            <div class="dashboard-stat color-2">
                <div class="dashboard-stat-content">
                    <h4>
                        <?= $blogAdet; ?>
                    </h4> <span>Toplam İşletme</span>
                </div>
                <div class="dashboard-stat-item">
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <a href="üyeler.php">
            <div class="dashboard-stat color-3">
                <div class="dashboard-stat-content">
                    <h4>
                        <?= $uyelerAdet; ?>
                    </h4> <span>Toplam Üyeler</span>
                </div>
                <div class="dashboard-stat-item">
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <a href="yorumlar.php">
            <div class="dashboard-stat color-4">
                <div class="dashboard-stat-content">
                    <h4>
                        <?= $yorumlarAdet; ?>
                    </h4> <span>Toplam Yorum</span>
                </div>
                <div class="dashboard-stat-icon"><i class="sl sl-icon-heart"></i></div>
                <div class="dashboard-stat-item">
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 traffic">
            <div class="dashboard-list-box">
                <h4 class="gray">Son 5 İşletme</h4>
                <div class="table-box">
                    <table class="basic-table">
                        <thead>
                            <tr>
                                <th>İşletme adı</th>
                                <th>Kategori</th>
                                <th>Telefon</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM isletme ORDER BY id DESC LIMIT 5");
                            $stmt->execute();
                            while ($user = $stmt->fetch()) {
                                echo "<tr>";
                                echo "<td>" . $user[2] . "</td>";
                                echo "<td>" . $user[13] . "</td>";
                                echo "<td>" . $user[10] . "</td>";
                                echo "<td>" . $user[14] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 col-md-12 col-xs-12 traffic">
            <div class="dashboard-list-box with-icons margin-top-20">
                <h4 class="gray">Son 5 Aktivite</h4>
                <ul>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM loglar ORDER BY id DESC LIMIT 5");
                    $stmt->execute();
                    while ($user = $stmt->fetch()) { ?>
                        <li>
                            <i class="list-box-icon sl sl-icon-star"></i>
                            <?= $user[2] ?>
                        </li>
                    <?php }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-xs-12 traffic">
            <div class="dashboard-list-box margin-top-20 user-list">
                <h4 class="gray">Son 5 Üye</h4>
                <ul>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE rol IS NULL OR rol = '' ORDER BY id DESC LIMIT 5");
                    $stmt->execute();
                    while ($user = $stmt->fetch()) { ?>
                        <li>
                            <div class="user-list-item">
                                <div class="user-list-content">
                                    <h4>
                                        <?= $user[1] . " " . $user[2]  ?>
                                    </h4>
                                    <span>
                                        <?php echo $user[6] ?>
                                    </span>
                                </div>
                            </div>
                        </li>
                    <?php }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php'; ?>
