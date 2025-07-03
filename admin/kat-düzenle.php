<?php
require_once 'header.php';
require_once '../conn.php'; ?>
<div class="dashboard-content">

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box">
                <h4 class="gray">Tüm Kategoriler</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>AD</th>
                                <th>TARİH</th>
                                <th class="textright">Sil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM kategoriler");
                            $stmt->execute();
                            while ($row = $stmt->fetch()) {
                                echo "<tr>";
                                echo "<td>" . $row[0] . "</td>";
                                echo "<td>" . $row[1] . "</td>";
                                echo "<td>" . $row[2] . "</td>";
                                echo "<td>
                                 <a style=\"color:red\" href=\"sil.php?katid=$row[0]\">SİL</a>
                                  </td>";
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
