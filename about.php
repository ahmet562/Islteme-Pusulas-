<?php require_once 'header.php';
 ?>
<div class="container">
  <div class="row align-items-center justify-content-center text-center">
    <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <h1>Hakkımızda</h1>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="site-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <img src="images/img_1.jpg" alt="Free website template by Free-Template.co" class="img-fluid rounded">
      </div>
      <div class="col-md-5 ml-auto">
        <h2 class="text-primary mb-3">Tarihimiz</h2>
        <p>Sitemiz ilk olarak bir okul projesi olarak hayata geçirildi. Proje kapsamında, dijital çözümler üretme
          hedefiyle başladığımız bu yolculuk zamanla çok daha anlamlı bir hâl aldı. Geliştirdiğimiz fikirlerin ve
          sunduğumuz içeriklerin özellikle yerel işletmelere önemli katkılar sağlayabileceğini fark ettik. Bu yüzden
          sitemizi yalnızca bir proje olarak bırakmak yerine, herkesin kullanımına sunmaya karar verdik.</p>
        <p class="mb-4">Bugün, hem bilgi paylaşımını destekleyen hem de yerel kalkınmaya katkı sağlamayı hedefleyen
          bir platform olarak yolumuza devam ediyoruz. </p>
        <ul class="ul-check list-unstyled success">
          <li>Kullanışlı</li>
          <li>Yararlı</li>
          <li>Yerel</li>
          <li>İlham verici</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="site-section " data-aos="fade">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-8">
        <h3>Başarıya Giden Yolda Pusulanız Olalım.</h3>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-4 mx-auto">
        <h3>Biz Kimiz</h3>
      </div>
    </div>
    <div class="row mb-5">
      <div class="col-md-4 ml-auto">
        <p>Biz; genç, yaratıcı ve çözüm odaklı bir ekibiz. Teknolojiyi ve tasarımı bir araya getirerek, işletmelerin
          dijitaldeki varlığını güçlendirmeye yardımcı oluyoruz.</p>
      </div>
      <div class="col-md-4">
        <p>Hedefimiz, küçük ve yerel işletmelerin dijitalde büyümesini kolaylaştırmak. Onlara ilham vermek, çözüm
          sunmak ve başarı yolculuklarında yanında olmak istiyoruz..</p>
      </div>
    </div>
    <div class="row mb-5">
      <div class="col-md-4 text-left border-primary">
        <h2 class="font-weight-light text-primary">Bizim takımımız</h2>
        <p class="color-black-opacity-5">Birimiz tasarımı düşünür, diğerimiz kelimeleri konuşturur,bir başkası da
          kodlarla dans eder.</p>
      </div>
    </div>
    <div class="row">
      <?php
      $stmt = $conn->prepare("SELECT * FROM admins");
      $stmt->execute();
      $admins = $stmt->fetchAll();
      foreach ($admins as $admin) {
        ?>
        <div class="col-md-6 col-lg-6 mb-4 mb-lg-5 mt-md-5">
          <img src="<?= htmlspecialchars($admin['resim']) ?>" alt="Profil Resmi" class="img-fluid mb-3">
          <h3 class="h4"><?= htmlspecialchars($admin['ad']) ?>  <?= htmlspecialchars($admin['soyad']) ?></h3>
          <p class="caption text-primary"><?= htmlspecialchars($admin['rol']) ?></p>
          <p><?= nl2br(htmlspecialchars($admin['hakkimda'])) ?></p>
          <ul class="ul-check list-unstyled success">
              <?php
               $etiketler = explode(',', $admin['etiket']);
                foreach ($etiketler as $etiket) {
                    echo '<li>' . htmlspecialchars(trim($etiket)) . '</li>';
                  }
              ?>
          </ul>
        </div>
       <?php
      }
      ?>
    </div>
  </div>
</div>
<div class="site-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 text-center border-primary">
        <h2 class="font-weight-light text-primary">Sıkça Sorulan Sorular</h2>
        <p class="color-black-opacity-5">Merak Edilen Herşey...</p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-8">
        <div class="border p-3 rounded mb-2">
          <a data-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1"
            class="accordion-item h5 d-block mb-0">Sitenin amacı nedir?</a>
          <div class="collapse" id="collapse-1">
            <div class="pt-2">
              <p class="mb-0">Sitemizin amacı kullanıcılar bir iş yerini ziyaret etmeden önce o mekanla ilgili bilgi
                edinmek, kullanıcı deneyimlerini ve değerlendirmelerini görmek istemektedir. Ancak mevcut dijital
                platformlar genellikle sınırlı kategori seçenekleri sunmakta ya da belirli işletme türlerine
                odaklanmaktadır. Yerel işletmelerin dijitalde yeterince görünür olmaması, kullanıcıların doğru bilgiye
                ulaşmasını zorlaştırmaktadır. Bu nedenle, farklı sektörlerdeki işletmeleri tanıtan ve kullanıcıların
                değerlendirme yapabildiği kapsamlı bir platform ihtiyacı sebebi ile doğmuştur.</p>
            </div>
          </div>
        </div>
        <div class="border p-3 rounded mb-2">
          <a data-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4"
            class="accordion-item h5 d-block mb-0">Bu şehirde mevcut mu?</a>
          <div class="collapse" id="collapse-4">
            <div class="pt-2">
              <p class="mb-0">Sitemize her şehirden ekleme yapılabilir.Yani ekleme yapıldığı sürece mevcuttur.</p>
            </div>
          </div>
        </div>
        <div class="border p-3 rounded mb-2">
          <a data-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2"
            class="accordion-item h5 d-block mb-0">Ücretsiz mi?</a>
          <div class="collapse" id="collapse-2">
            <div class="pt-2">
              <p class="mb-0">Evet sitemiz tamamen ücretsizdir.</p>
            </div>
          </div>
        </div>
        <div class="border p-3 rounded mb-2">
          <a data-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3"
            class="accordion-item h5 d-block mb-0">Siteye kayıt olmak zorunlu mu?</a>
          <div class="collapse" id="collapse-3">
            <div class="pt-2">
              <p class="mb-0">Siteye kayıt olmak zorunlu değildir ama eğer iş yerinizi tanıtmak istiyorsanız yada
                herhangi bir işlem yapacaksanız kayıt olmanız gereklidir. </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once 'footer.php';?>
