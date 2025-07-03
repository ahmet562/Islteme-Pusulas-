<?php
require_once 'header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="container">
  <div class="row align-items-center justify-content-center text-center">
    <div class="col-md-10">

      <div class="row justify-content-center mb-4">
        <div class="col-md-10 text-center">
        <div class="row justify-content-center mb-4">
              <div class="col-md-10 text-center">
                <h1 data-aos="fade-up">İşletme Bul <span class="typed-words"></span></h1>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'miktar.php';?>
<?php require_once 'begenilen.php';?>
<!-- Harita Modalı -->
<div id="mapModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:#fff; z-index:9999;">
  <div id="map" style="height:100%; width:100%;"></div>
  <button onclick="closeMapPicker()" style="position:absolute; top:10px; right:10px; z-index:10001;">Kapat</button>
</div>

            <script>
            var typed = new Typed('.typed-words', {
            strings: ["Barınma"," Yiyecek"," Kişisel Bakım", " Giyim"],
            typeSpeed: 80,
            backSpeed: 80,
            backDelay: 4000,
            startDelay: 1000,
            loop: true,
            showCursor: true
            });
            </script>
<script>
let map, marker;

function openMapPicker() {
  document.getElementById("mapModal").style.display = "block";

  if (!map) {
    map = L.map('map').setView([39.9208, 32.8541], 6); // Türkiye merkez

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
    }).addTo(map);

    // Haritada tıklanan konum
    map.on('click', function (e) {
      const lat = e.latlng.lat.toFixed(6);
      const lng = e.latlng.lng.toFixed(6);

      // Marker'ı haritaya yerleştir
      if (marker) {
        marker.setLatLng(e.latlng);
      } else {
        marker = L.marker(e.latlng).addTo(map);
      }

      // Koordinattan şehir bilgisi al
      getCityFromCoords(lat, lng);
    });
  }
}

function getCityFromCoords(lat, lng) {
  fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
    .then(response => response.json())
    .then(data => {
      const address = data.address;
      const city = address.city || address.town || address.village || address.state || "Şehir bulunamadı";
      document.getElementById('location-input').value = city;
    })
    .catch(error => {
      console.error("Şehir bilgisi alınamadı:", error);
      document.getElementById('location-input').value = "Konum bilgisi alınamadı";
    });
}

function closeMapPicker() {
  document.getElementById("mapModal").style.display = "none";
}

</script>

<?php require_once './footer.php'; ?>
