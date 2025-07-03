<?php
require_once 'header.php';
require_once '../conn.php';
?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box">
                <h4 class="gray">Tüm Yorumlar</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>İşletme ID</th>
                                <th>Yorum</th>
                                <th>Yıldız</th>
                                <th>Tarih</th>
                                <th class="textright">Sil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM yorumlar");
                            $stmt->execute();
                            while ($row = $stmt->fetch()) {
                                echo "<tr>";
                                echo "<td>" . $row[0] . "</td>";
                                echo "<td>" . $row[1] . "</td>";
                                echo "<td>
                                        <div class='border p-2 rounded'>
                                            <a data-toggle='collapse' href='#yorum-{$row[0]}' role='button' aria-expanded='false'
                                               aria-controls='yorum-{$row[0]}' class='d-block text-primary'>
                                                Yorumu Görüntüle
                                            </a>
                                            <div class='collapse mt-2' id='yorum-{$row[0]}'>
                                                <p class='mb-0'>" . nl2br(htmlspecialchars($row[4])) . "</p>
                                            </div>
                                        </div>
                                      </td>";
                                echo "<td>" . $row[5] . "</td>";
                                echo "<td>" . $row[3] . "</td>";
                                echo "<td><a style='color:red' href='sil.php?yorumid={$row[0]}'>SİL</a></td>";
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php require_once 'footer.php'; ?>
