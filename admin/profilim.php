<?php
ob_start();
session_start();
require_once 'header.php';

// Veritabanından gelen telefon bilgisini ayırıyoruz
if (isset($_SESSION['admin_id'])) {
    $id = $_SESSION['admin_id'];
    $stmt = $conn->prepare("SELECT * FROM admins WHERE id=?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $tel = $user['tel'];
    $countryCode = "+90";
    $number = "";
    if (strpos($tel, '+') === 0) {
        $countryCode = substr($tel, 0, strpos($tel, ' '));
        $number = trim(substr($tel, strpos($tel, ' ')));
    } else {
        $number = $tel;
    }
}
?>
<div class="dashboard-content">
    <div class="dashboard-form">
        <div class="row">
            <?php
            if (isset($_SESSION['admin_id'])) {
                $id = $_SESSION['admin_id'];
                $stmt = $conn->prepare("SELECT * FROM admins WHERE id=?");
                $stmt->execute([$id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($_POST['gonder'])) {
                    $ad = !empty($_POST['ad']) ? $_POST['ad'] : $user['ad'];
                    $soyad = !empty($_POST['soyad']) ? $_POST['soyad'] : $user['soyad'];
                    $posta = !empty($_POST['mail']) ? $_POST['mail'] : $user['email'];
                    $hakkimda = isset($_POST['hakkimda']) ? $_POST['hakkimda'] : $user['hakkimda'];
                    $etiket = isset($_POST['etiket']) ? $_POST['etiket'] : $user['etiket'];
                    $rol = isset($_POST['rol']) ? $_POST['rol'] : $user['rol'];
                    $sosyalmedya = isset($_POST['sosyalmedya']) ? $_POST['sosyalmedya'] : $user['sosyalmedya'];
                    $tel = isset($_POST['full_phone']) ? $_POST['full_phone'] : $user['tel'];
                    if (!empty($_POST['yeni_sifre'])) {
                        $sifre = password_hash($_POST['yeni_sifre'], PASSWORD_BCRYPT);
                        $sql = "UPDATE admins SET ad=?, soyad=?, email=?, sifre=?, hakkimda=?, etiket=?, sosyalmedya=?, rol=?, tel=? WHERE id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$ad, $soyad, $posta, $sifre, $hakkimda, $etiket, $sosyalmedya, $rol,$tel, $id]);
                    } else {
                        $sql = "UPDATE admins SET ad=?, soyad=?, email=?, hakkimda=?, etiket=?, sosyalmedya=?, rol=?, tel=? WHERE id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$ad, $soyad, $posta, $hakkimda, $etiket, $sosyalmedya, $rol,$tel,$id]);
                    }
                    if (isset($_FILES['yeni_resim']) && $_FILES['yeni_resim']['error'] == 0) {
                        $targetDir = "../uploads/";
                        $fileName = basename($_FILES["yeni_resim"]["name"]);
                        $newFilePath = $targetDir . $fileName;
                        if (!empty($user['resim']) && file_exists($user['resim'])) {
                            unlink($user['resim']);
                        }
                        move_uploaded_file($_FILES["yeni_resim"]["tmp_name"], $newFilePath);
                        $sql = "UPDATE admins SET resim=? WHERE id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([ "uploads/" . $fileName, $id ]);
                    }
                    header("Location: " . basename(__FILE__) . "?guncelle=ok");
                    exit;
                }
            } else {
                header('Location: login.php');
                exit;
            }
            ?>
            <div class="col-lg-6 col-md-6 col-xs-12 padding-right-30">
                <div class="dashboard-list-box">
                    <h4 class="gray">Bilgileri Güncelle</h4>
                    <div class="dashboard-list-box-static">
                        <form action="" method="POST" enctype="multipart/form-data" onsubmit="preparePhone()">
                            <label>Ad</label>
                            <input name="ad" value="<?= htmlspecialchars($user['ad']) ?>" type="text" required>
                            <label>Soyad</label>
                            <input name="soyad" value="<?= htmlspecialchars($user['soyad']) ?>" type="text" required>
                            <label>Telefon</label>
                            <div style="display: flex; gap: 5px;">
                                <select id="countryCode" onchange="updatePhone()">
                                    <option value="<?= htmlspecialchars($countryCode) ?>"><?= htmlspecialchars($countryCode) ?></option>
                                </select>
                                <input id="phoneInput" type="tel" name="tel" maxlength="20" value="<?= htmlspecialchars($number) ?>"
                                    oninput="formatPhone()" required>
                            </div>
                            <input type="hidden" name="full_phone" id="fullPhone">
                            <label>E-Posta</label>
                            <input name="mail" value="<?= htmlspecialchars($user['email']) ?>" type="text" required>
                            <label>Yeni Şifre</label>
                            <input name="yeni_sifre" type="password">
                            <label>Etiketler</label>
                            <input name="etiket" value="<?= htmlspecialchars($user['etiket']) ?>" type="text">
                            <label>Sosyal Medya</label>
                            <input name="sosyalmedya" value="<?= htmlspecialchars($user['sosyalmedya']) ?>" type="text">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="dashboard-list-box">
                    <h4 class="gray">Profil Resmi ve Hakkımda</h4>
                    <div class="dashboard-list-box-static">
                            <?php if (!empty($user['resim'])): ?>
                                <img src="<?= htmlspecialchars('../' . $user['resim']) ?>" alt="Profil Resmi" width="120" style="border-radius:10px;"><br><br>
                            <?php else: ?>
                                <p>Henüz profil resmi yok.</p>
                            <?php endif; ?>
                            <input type="file" name="yeni_resim"><br><br>
                            <label>Pozisyon</label>
                            <input name="rol" value="<?= htmlspecialchars($user['rol']) ?>" type="text">
                            <label>Hakkımda</label>
                            <textarea name="hakkimda"><?= htmlspecialchars($user['hakkimda']) ?></textarea><br><br>
                            <button name="gonder" class="button">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>

<script>
window.onload = function() {
  fetchCountries();
  setTimeout(() => {
    formatPhone(); // Sayfa açılır açılmaz eski numarayı formatla
  }, 300);
};

function fetchCountries() {
  fetch('https://restcountries.com/v3.1/all')
    .then(response => response.json())
    .then(data => {
      const select = document.getElementById('countryCode');

      // Ülkeleri alfabetik olarak sıralıyoruz
      data.sort((a, b) => a.name.common.localeCompare(b.name.common));

      data.forEach(country => {
        if (country.idd && country.idd.root) {
          const code = country.idd.root + (country.idd.suffixes ? country.idd.suffixes[0] : "");
          const option = document.createElement('option');
          option.value = code;
          option.text = `${country.name.common} (${code})`;
          select.appendChild(option);
        }
      });

      // PHP tarafından dinamik olarak gelen ülke kodunu seçili yapmak
      select.value = "<?= htmlspecialchars($countryCode) ?>";
    })
    .catch(error => console.error('Ülke kodları alınamadı:', error));
}


function updatePhone() {
  formatPhone();
}

function preparePhone() {
  formatPhone();
}

function formatPhone() {
  const countryCode = document.getElementById('countryCode').value;
  let phone = document.getElementById('phoneInput').value.replace(/\D/g, '');
  let formatted = "";

  if (phone.length > 0) {
    formatted += `(${phone.substring(0, 3)}`;
  }
  if (phone.length >= 3) {
    formatted += `) ${phone.substring(3, 6)}`;
  }
  if (phone.length >= 6) {
    formatted += ` ${phone.substring(6, 8)}`;
  }
  if (phone.length >= 8) {
    formatted += ` ${phone.substring(8, 10)}`;
  }

  document.getElementById('phoneInput').value = formatted;
  document.getElementById('fullPhone').value = countryCode + ' ' + formatted;
}
</script>
