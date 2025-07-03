<?php
require_once 'header.php';
require_once '../conn.php';
?>
<div class="dashboard-content">

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box">
                <h4 class="gray">
                    Gelen Mesajlar
                </h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>AD</th>
                                <th>E-POSTA</th>
                                <th>MESAJ</th>
                                <th>TARİH</th>
                                <th>Okundu</th>
                                <th class="textright">Sil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM mesajlar");
                            $stmt->execute();
                            while ($row = $stmt->fetch()) {
                                echo "<tr>";
                                echo "<td>" . $row['ad'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>
                                        <div class='border p-2 rounded'>
                                            <a data-toggle='collapse' href='#mesaj-{$row['id']}' role='button' aria-expanded='false'
                                               aria-controls='mesaj-{$row['id']}' class='d-block text-primary'>
                                                Mesajı Görüntüle
                                            </a>
                                            <div class='collapse mt-2' id='mesaj-{$row['id']}'>
                                                <p class='mb-0'>" . nl2br(htmlspecialchars($row['mesaj'])) . "</p>
                                            </div>
                                        </div>
                                      </td>";
                                echo "<td>" . $row['tarih'] . "</td>";

                                // Okundu checkbox
                                $checked = $row['okundu'] ? "checked" : "";
                                echo "<td>
                                        <input type='checkbox' class='okundu-kontrol' data-id='{$row['id']}' {$checked}>
                                      </td>";

                                echo "<td><a style='color:red' href='sil.php?mesajid={$row['id']}'>SİL</a></td>";
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
<script>
    $(document).on('change', '.okundu-kontrol', function() {
        var mesajID = $(this).data('id');
        var okundu = $(this).is(':checked') ? 1 : 0;

        $.post("okundu_guncelle.php", {
            mesajid: mesajID,
            okundu: okundu
        }, function(response) {
            console.log(response); // Geri dönüş varsa kontrol için
        });
    });
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php require_once 'footer.php'; ?>
