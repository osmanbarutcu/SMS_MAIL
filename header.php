<?php
ob_start();
session_start();
date_default_timezone_set('Europe/Istanbul');
require_once 'nedmin/netting/baglan.php';

if (empty($_SESSION['title'])) {

  $ayarsor=$db->prepare("SELECT * FROM ayar");
  $ayarsor->execute();

  while($ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC)) {

   $_SESSION[$ayarcek['ayar_ad']]=$ayarcek['ayar_tur'];

 }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="keywords" content="<?php echo $_SESSION['keywords'] ?>">
  <meta name="description" content="<?php echo $_SESSION['description'] ?>">
  <meta name="author" content="">

  <title><?php echo $_SESSION['title'] ?></title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/round-about.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Jquery İnput Mask -->
  <script src="js/jquery-input-mask-phone-number.js"></script>


  <!-- Sweet Alert -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">Cum. Bşk. Seçim Anket Scripti</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">


          <li class="nav-item active">
            <a class="nav-link" href="http://www.edukey.com.tr">Script Eğitimine Kaydol!
              <span class="sr-only">(current)</span>
            </a>
          </li>

          <li class="nav-item">
              <a class="nav-link" href="javascript:void(0)">|</a>
            </li>

          <form id="sonucsorgula" method="POST" class="form-inline">
            <input class="form-control mr-sm-2" type="text" name="oy_araci" placeholder="Telefon yada Mail" aria-label="Search">
            <input type="hidden" name="sonucsorgula">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Sonuçlar</button>
          </form>

           <!--  <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li> -->

          </ul>
        </div>
      </div>
    </nav>