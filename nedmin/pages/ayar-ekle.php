<?php require_once 'header.php' ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-9">
            <h1 >Site Ayar Ekleme</h1>
            
        </div>
        <div style="margin-top:20px;" class="col-lg-3" align="right">
               <a href="ayarlar.php"> <button class="btn btn-danger">Geri Dön</button></a>
            </div>

        
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">


     <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
             Site Ayar Ekleme
         </div>
         <div class="panel-body">


            <form id="uploadform" method="POST" >

               <div class="form-group">
                <div id="mesaj"></div>
            </div>

           
           

            <div class="form-group">
                <label >Ayar Adı</label>
                <input type="text" class="form-control" name="ayar_ad"  placeholder="Çağrılacak ayar adınız giriniz">
                <small  class="form-text text-muted">$_SESSION değişkeniyle çağrılacak ad</small>
            </div>


            <div class="form-group">
                <label >Ayar Türü</label>
                <input type="text" class="form-control" name="ayar_tur"  placeholder="Ayar Açıklamasını Giriniz">
                <small  class="form-text text-muted">$_SESSION değişkenine atanacak açıklama.</small>
            </div>

            <input type="hidden" name="ayarekle">

            <div align="right">
                <button class="btn btn-success">Kaydet</button>
            </div>
        </form>



    </div>


</div>


</div>

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            Bilgilendirme
        </div>
        <div class="panel-body">

         <p>Dilediğiniz kadar site ayarı ekleyebilirsiniz.</p>
     </div>


 </div>


</div>
<!-- /.row -->

<!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php require_once 'footer.php' ?>


<script type="text/javascript">


    $(document).ready(function(e) {

        $("#uploadform").on('submit',(function(e){

            $.ajax({

                url:"../netting/islem.php",
                type:"POST",
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success: function(data) {

                    /*$("#mesaj").html(data);*/

                    veri=JSON.parse(data);
                    swal("İşlem Sonucu",veri.message,veri.status)

                }


            });

            return false;

        }));

     
    });


</script>