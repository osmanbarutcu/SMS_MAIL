
<?php require_once 'header.php'; ?>



<!-- Page Content -->
<div class="container">

  <!-- Introduction Row -->
  <h1 class="my-4">CB
    <small>Cumhurbaşkanlığı Seçim Anketi</small>
  </h1>
  <p>Edukey tarafından kodlanan bu script eğitim amaçlı Cumhurbaşkanlığı anket sistemini içerir. Test amaçlı yer alan adaylara oy vermek ve sistemi test etmek amacıyla aşağıdan oy'lama yapabilirsiniz.</p>

  <!-- Team Members Row -->
  <div class="row">
    <div class="col-lg-12">
      <h2 class="my-4">Adaylar</h2>
    </div>

    <?php 

    $cbadaysor=$db->prepare("SELECT * FROM cbaday order by aday_sira ASC");
    $cbadaysor->execute();


    while($adaycek=$cbadaysor->fetch(PDO::FETCH_ASSOC)) { 
     ?>


     <div class="col-lg-4 col-sm-6 text-center mb-4">
      <img width="150" class="rounded-circle img-fluid d-block mx-auto" src="<?php echo $adaycek['cbaday_resimyol'] ?>" alt="<?php echo $cbadaycek['cbaday_adsoyad'] ?>">
      <h3><?php echo $adaycek['cbaday_adsoyad'] ?>
      </h3>
      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#oykutusu<?php echo $adaycek['cbaday_id'] ?>"> Oy ver!</button>



    </div>

    <?php if ($_SESSION['oyturu']==1) {?>




    <!-- Modal ve Mail İle Gönderim İşlemleri Start-->
    <div  class="modal fade" id="oykutusu<?php echo $adaycek['cbaday_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Oyunu Kullan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Oy verme işminizin geçerli sayılabilmesi için 4 haneli bir şifre gönderilecektir. Mail kutunuzun spam klasörünüde kontrol etmeyi unutmayın.</p>

            <p id="sonuc<?php echo $adaycek['cbaday_id'] ?>"></p>
            

            <form id="mailonaykodugonder<?php echo $adaycek['cbaday_id'] ?>" method="POST">


             <div id="mailadres<?php echo $adaycek['cbaday_id'] ?>" class="form-group">
              <label for="exampleFormControlInput1">Mail Adresiniz</label>
              <input type="email" class="form-control" name="kullanici_mail"  placeholder="Geçerli bir mail adresi giriniz.">
              <input id="oymails" type="hidden" name="oymail">
              <input type="hidden" name="cbaday_id" value="<?php echo $adaycek['cbaday_id'] ?>">
            </div>

            <div id="onaykodu<?php echo $adaycek['cbaday_id'] ?>" class="form-group">
              <label for="exampleFormControlInput1">Onay Kodunuz</label>
              <input type="text" class="form-control" name="kullanici_onaykodu"  placeholder="Gelen Onay Kodunu Giriniz">
              <input type="hidden" name="onaykodu">
              <input type="hidden" name="cbaday_id" value="<?php echo $adaycek['cbaday_id'] ?>">
            </div>
            
          </div>
          <div class="modal-footer">
            <button id="mailgonderbuton<?php echo $adaycek['cbaday_id'] ?>" type="submit" class="btn btn-primary">Doğrulama Kodu İste</button>
            <button id="dogrulamakodbuton<?php echo $adaycek['cbaday_id'] ?>" type="submit" class="btn btn-success">Oyunu Kullan</button>

            <a href="anket-sonuclari" id="sonucbuton<?php echo $adaycek['cbaday_id'] ?>" class="btn btn-danger">Sonuçları Gör</a>

          </div>
        </form>
      </div>
    </div>
  </div>


  <script type="text/javascript">

    $(document).ready(function(){

     $("#onaykodu<?php echo $adaycek['cbaday_id'] ?>").hide();
     $("#dogrulamakodbuton<?php echo $adaycek['cbaday_id'] ?>").hide();
     $("#sonucbuton<?php echo $adaycek['cbaday_id'] ?>").hide();

   });

    $("#mailonaykodugonder<?php echo $adaycek['cbaday_id'] ?>").on('submit',(function(e){

      $.ajax({

        url:"nedmin/netting/islem.php",
        type:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success: function(data) {

          /*$("#mesaj").html(data);*/

          veri=JSON.parse(data);
          swal("İşlem Sonucu",veri.message,veri.status)

          /* console.log(data);*/

          if (veri.oydurum=="1") {

            $("#mailgonderbuton<?php echo $adaycek['cbaday_id'] ?>").hide();
            $("#sonucbuton<?php echo $adaycek['cbaday_id'] ?>").show();


          }

          if (veri.islemno=="1") {

            $("#oymails").attr('disabled');
            $("#mailadres<?php echo $adaycek['cbaday_id'] ?>").hide();
            $("#mailadres<?php echo $adaycek['cbaday_id'] ?>").remove();
            $("#mailgonderbuton<?php echo $adaycek['cbaday_id'] ?>").hide();
            $("#dogrulamakodbuton<?php echo $adaycek['cbaday_id'] ?>").show();
            $("#onaykodu<?php echo $adaycek['cbaday_id'] ?>").show();

          } else if (veri.islemno=="2") {

            $("#onaykodu<?php echo $adaycek['cbaday_id'] ?>").remove();
            $("#dogrulamakodbuton<?php echo $adaycek['cbaday_id'] ?>").remove();
            $("#sonuc<?php echo $adaycek['cbaday_id'] ?>").text("Oyunuz Başarıyla Kaydedildi");
            $("#sonucbuton<?php echo $adaycek['cbaday_id'] ?>").show();
          }

        }


      });

      return false;

    }));
  </script>

  <!-- Modal ve Mail İle Gönderim İşlemleri Finish-->

  <?php } else if ($_SESSION['oyturu']==0) { ?>

  
  <!-- Modal ve SMS İle Gönderim İşlemleri Start-->
  <div  class="modal fade" id="oykutusu<?php echo $adaycek['cbaday_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Oyunu Kullan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Oy verme işminizin geçerli sayılabilmesi için Cep Telefonunuza 4 haneli bir şifre gönderilecektir. </p>

          <p id="sonuc<?php echo $adaycek['cbaday_id'] ?>"></p>


          <form id="mailonaykodugonder<?php echo $adaycek['cbaday_id'] ?>" method="POST">


           <div id="mailadres<?php echo $adaycek['cbaday_id'] ?>" class="form-group">
            <label for="exampleFormControlInput1">Gsm Numaranız</label>
            <input type="text" class="form-control" name="kullanici_gsm" id="yourphone2<?php echo $adaycek['cbaday_id'] ?>" placeholder="Cep Telefon Numaranızı Giriniz">
            <input id="oymails" type="hidden" name="oysms">
            <input type="hidden" name="cbaday_id" value="<?php echo $adaycek['cbaday_id'] ?>">
          </div>

          <script type="text/javascript">

            $(document).ready(function(){

              $("#yourphone2<?php echo $adaycek['cbaday_id'] ?>").usPhoneFormat();

            });
          </script>



          <div id="onaykodu<?php echo $adaycek['cbaday_id'] ?>" class="form-group">
            <label for="exampleFormControlInput1">Onay Kodunuz</label>
            <input type="text" class="form-control" name="kullanici_smsonaykodu"  placeholder="Gelen Onay Kodunu Giriniz">
            <input type="hidden" name="onaykodusms">
            <input type="hidden" name="cbaday_id" value="<?php echo $adaycek['cbaday_id'] ?>">
          </div>

          <div id="resultm"></div>

        </div>
        <div class="modal-footer">
          <button id="mailgonderbuton<?php echo $adaycek['cbaday_id'] ?>" type="submit" class="btn btn-primary">Doğrulama Kodu İste</button>
          <button id="dogrulamakodbuton<?php echo $adaycek['cbaday_id'] ?>" type="submit" class="btn btn-success">Oyunu Kullan</button>

          <a href="anket-sonuclari" id="sonucbuton<?php echo $adaycek['cbaday_id'] ?>" class="btn btn-danger">Sonuçları Gör</a>

        </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">

  $(document).ready(function(){

   $("#onaykodu<?php echo $adaycek['cbaday_id'] ?>").hide();
   $("#dogrulamakodbuton<?php echo $adaycek['cbaday_id'] ?>").hide();
   $("#sonucbuton<?php echo $adaycek['cbaday_id'] ?>").hide();

 });

  $("#mailonaykodugonder<?php echo $adaycek['cbaday_id'] ?>").on('submit',(function(e){

    $.ajax({

      url:"nedmin/netting/islem.php",
      type:"POST",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      success: function(data) {

        /*$("#mesaj").html(data);*/

        veri=JSON.parse(data);
        swal("İşlem Sonucu",veri.message,veri.status)

        console.log(data);

        

        if (veri.oydurum=="1") {



          $("#mailgonderbuton<?php echo $adaycek['cbaday_id'] ?>").hide();
          $("#sonucbuton<?php echo $adaycek['cbaday_id'] ?>").show();


        }

        if (veri.islemno=="1") {

          $("#oymails").attr('disabled');
          $("#mailadres<?php echo $adaycek['cbaday_id'] ?>").hide();
          $("#mailadres<?php echo $adaycek['cbaday_id'] ?>").remove();
          $("#mailgonderbuton<?php echo $adaycek['cbaday_id'] ?>").hide();
          $("#dogrulamakodbuton<?php echo $adaycek['cbaday_id'] ?>").show();
          $("#onaykodu<?php echo $adaycek['cbaday_id'] ?>").show();

        } else if (veri.islemno=="2") {

          $("#onaykodu<?php echo $adaycek['cbaday_id'] ?>").remove();
          $("#dogrulamakodbuton<?php echo $adaycek['cbaday_id'] ?>").remove();
          $("#sonuc<?php echo $adaycek['cbaday_id'] ?>").text("Oyunuz Başarıyla Kaydedildi");
          $("#sonucbuton<?php echo $adaycek['cbaday_id'] ?>").show();
        }

      }


    });

    return false;

  }));
</script>

<!-- Modal ve SMS İle Gönderim İşlemleri Finish-->

<?php } } ?>



</div>

</div>
<!-- /.container -->


<?php require_once 'footer.php'; ?>

