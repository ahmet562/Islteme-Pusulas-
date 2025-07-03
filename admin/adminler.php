<?php
require_once 'header.php';
require_once '../conn.php';
session_start();
$is_admin_id_1 = isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == 1;
?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box">
                <h4 class="gray">Adminler</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>AD</th>
                                <th>SOYAD</th>
                                <th>EMAİL</th>
                                <th>Pozisyon</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM admins WHERE id != 1");
                        $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . $row[0] . "</td>";
                            echo "<td>" . $row[1] . "</td>";
                            echo "<td>" . $row[2] . "</td>";
                            echo "<td>" . $row[3] . "</td>";
                            echo "<td>" . $row[9] . "</td>";
                            echo "<td style=\"display:flex; justify-content:center; \">";
                            if ($is_admin_id_1) {
                                echo "<a class=\"btn btn-danger\" href=\"sil.php?adminid=$row[0]\">SİL</a>";
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
