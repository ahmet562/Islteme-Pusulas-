<?php require_once 'header.php';
require_once '../conn.php';
date_default_timezone_set('Europe/Istanbul');
 ?>
<div class="dashboard-content">

    <div class="row">

        <!-- Listings -->
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box">
                <h4 class="gray">Tüm Loglar</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>AD</th>
                                <th>DETAY</th>
                                <th>TARİH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM loglar ORDER BY tarih DESC");
                            $stmt->execute();
                            while ($row = $stmt->fetch()) {
                                echo "<tr>";
                                echo "<td>" . $row[1] . "</td>";
                                echo "<td>" . $row[2] . "</td>";
                                echo "<td>" . $row[3] . "</td>";
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
