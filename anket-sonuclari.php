
<?php 

require_once 'header.php'; 


if (!isset($_SESSION['oydurum'])) {

  Header("Location:http://localhost/cbsecimanketi/?durum=oykullan");
  exit;
}


?>



<!-- Page Content -->
<div class="container my-4">

  <!-- Introduction Row -->
  <h1 class="my-4">Sonuçlar
    <small>Cumhurbaşkanlığı Seçim Anketi Sonuçları</small>
  </h1>
  <p>Anket sonuçları aşağıda bilginize sunulmuştur</p>

  
  <div class="col-md-12">
    <h3>Oy Alan Adaylar Sıralı Listeleme</h3>
    <p>Sıralı listelemede sadece oy alan adaylar gözükmektedir. Aday gözükmüyorsa henüz oy gelmemiştir.</p>
    <?php

    $oysor=$db->prepare("SELECT * FROM oy");
    $oysor->execute();
    $toplamoy=$oysor->rowCount();

    $cbadaysor=$db->prepare("SELECT oy.cbaday_id,cbaday.cbaday_adsoyad, COUNT(oy.cbaday_id) as oytoplam FROM oy INNER JOIN cbaday ON oy.cbaday_id=cbaday.cbaday_id GROUP BY oy.cbaday_id order by oytoplam DESC");
    $cbadaysor->execute();


    while($adaycek=$cbadaysor->fetch(PDO::FETCH_ASSOC)) { 

      $adayoy=$adaycek['oytoplam'];
      ?>

      <p><?php echo $adaycek['cbaday_adsoyad'] ?> <small>(Geçerli Oy Sayısı: <?php echo $adayoy ?>)</small></p>
      <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: <?php echo ($adayoy*100)/$toplamoy ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo number_format(($adayoy*100)/$toplamoy,2,",",".")  ?>%</div>
      </div>
      <hr>

      <?php } ?>
    </div>

    <div class="col-md-12">
      <h3>Sırasız Listeleme</h3>
      <?php

      $oysor=$db->prepare("SELECT * FROM oy");
      $oysor->execute();
      $toplamoy=$oysor->rowCount();

      $cbadaysor=$db->prepare("SELECT * FROM cbaday order by aday_sira ASC");
      $cbadaysor->execute();


      while($adaycek=$cbadaysor->fetch(PDO::FETCH_ASSOC)) { 

        $oysor=$db->prepare("SELECT * FROM oy where cbaday_id=:id");
        $oysor->execute(array(
          'id' => $adaycek['cbaday_id']
        ));

        $adayoy=$oysor->rowCount();
        ?>

        <p><?php echo $adaycek['cbaday_adsoyad'] ?> <small>(Geçerli Oy Sayısı: <?php echo $adayoy ?>)</small></p>
        <div class="progress">
          <div class="progress-bar" role="progressbar" style="width: <?php echo ($adayoy*100)/$toplamoy ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo number_format(($adayoy*100)/$toplamoy,2,",",".")  ?>%</div>
        </div>
        <hr>

        <?php } ?>
      </div>
    </div>
    <!-- /.container -->


    <?php require_once 'footer.php'; ?>

