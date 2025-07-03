<?php require_once 'header.php';
?>
<div class="dashboard-content">

    <div class="row">

        <!-- Listings -->
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box">
                <h4 class="gray">Mevcut Üyeler</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>AD</th>
                                <th>SOYAD</th>
                                <th>EMAİL</th>
                                <th>TARİH</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE rol IS NULL OR rol = ''");
                        $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . $row[0] . "</td>";
                            echo "<td>" . $row[1] . "</td>";
                            echo "<td>" . $row[2] . "</td>";
                            echo "<td>" . $row[3] . "</td>";
                            echo "<td>" . $row[6] . "</td>";
                            echo "<td style=\"display:flex; justify-content:center; \">";

                            // Eğer admin'in ID'si 1 ise, işlemleri göster
                            if ($is_admin_id_1) {
                                echo "<a class=\"btn btn-danger\" href=\"sil.php?uyeid=$row[0]\">SİL</a>";
                                echo "<a style=\"margin: 0px 5px;\" class=\"btn btn-success\" href=\"uyeguncelle.php?uyeid=$row[0]\">GÜNCELLE</a>";
                            }

                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once 'footer.php'; ?>
