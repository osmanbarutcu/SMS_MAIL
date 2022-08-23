 <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; EDUKEY Eğitim Sürümü <a style="color:white" href="https://www.edukey.com.tr" target="_blank">Edukey.Com.Tr</a></p>
      </div>
      <!-- /.container -->
    </footer>
<script type="text/javascript">

    $(document).ready(function(){



    });

    $("#sonucsorgula").on('submit',(function(e){

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
          if (veri.oyyok==0) {
            swal("İşlem Sonucu",veri.message,veri.status);

          } else if (veri.oyyok==1) {


            window.location.href = 'anket-sonuclari';



          } else {
           swal("İşlem Sonucu",veri.message,veri.status);

         }

         /* console.log(data);*/


       }


     });

      return false;

    }));
  </script>
    

  </body>

</html>