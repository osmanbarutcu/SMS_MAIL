<?php 
ob_start();
session_start();
require_once 'baglan.php';
require_once '../pages/fonksiyon.php';

if (isset($_POST['login'])) {



	if (empty($_POST['kullanici_mail']) or empty($_POST['kullanici_password'])) {
		

		$data['status']="error";
		$data['message']="Mail yada şifre boş olamaz";
		echo json_encode($data);
		exit;

	}


	$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail and kullanici_password=:password");
	$kullanicisor->execute(array(
		'mail' => $_POST['kullanici_mail'],
		'password' => md5($_POST['kullanici_password'])
	));

	$say=$kullanicisor->rowCount();

	if ($say>0) {

		$_SESSION['userkullanici_mail']=$_POST['kullanici_mail'];
		
		$data['status']="success";
		$data['message']="Giriş Başarılı";
		echo json_encode($data);

	} else {

		$data['status']="error";
		$data['message']="Kullanıcı Bulunamadı";
		echo json_encode($data);
		

	}


}


if (isset($_POST['adayekle'])) {

	
	if ($_FILES['file']['size']>1000000) {
		
		$data['status']="error";
		$data['message']="Resim boyutu 1Mb 'tan büyük olamaz.";
		echo json_encode($data);
		exit;

	}

	$izinli_uzantilar=array('jpg','png');

	$ext=strtolower(substr($_FILES['file']['name'],strpos($_FILES['file']['name'],'.')+1));

	if (in_array($ext, $izinli_uzantilar)===false) {
		
		$data['status']="error";
		$data['message']="Sadece Jpg ve Png Uzantılı Resimler Yüklenebilir";
		echo json_encode($data);
		exit;

	}

	$uploads_dir='../../dimg/adayresim';

	@$tmp_name=$_FILES['file']['tmp_name'];
	@$name=$_FILES['file']['name'];

	$uniq=uniqid();
	$refimgyol=substr($uploads_dir,6)."/".$uniq.".".$ext;

	@move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");


	
	$kaydet=$db->prepare("INSERT INTO cbaday SET 
		cbaday_adsoyad=:adsoyad,
		cbaday_resimyol=:resimyol

		");

	$insert=$kaydet->execute(array(

		'adsoyad' => htmlspecialchars($_POST['cbaday_adsoyad']),
		'resimyol' => $refimgyol

	));


	if ($insert) {

		$data['status']="success";
		$data['message']="Kayıt Başarılı";
		echo json_encode($data);
		exit;
		
	} else {
		$data['status']="error";
		$data['message']="Kayıt Başarısız";
		echo json_encode($data);
		exit;

	}

}



if (isset($_POST['adayduzenle'])) {

	
	if ($_FILES['file']['size']>1000000) {
		
		$data['status']="error";
		$data['message']="Resim boyutu 1Mb 'tan büyük olamaz.";
		echo json_encode($data);
		exit;

	}

	$izinli_uzantilar=array('jpg','png');

	$ext=strtolower(substr($_FILES['file']['name'],strpos($_FILES['file']['name'],'.')+1));

	if (in_array($ext, $izinli_uzantilar)===false) {
		
		$data['status']="error";
		$data['message']="Sadece Jpg ve Png Uzantılı Resimler Yüklenebilir";
		echo json_encode($data);
		exit;

	}

	$uploads_dir='../../dimg/adayresim';

	@$tmp_name=$_FILES['file']['tmp_name'];
	@$name=$_FILES['file']['name'];

	$uniq=uniqid();
	$refimgyol=substr($uploads_dir,6)."/".$uniq.".".$ext;

	@move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");


	
	$kaydet=$db->prepare("UPDATE cbaday SET 
		cbaday_adsoyad=:adsoyad,
		cbaday_resimyol=:resimyol

		WHERE cbaday_id={$_POST['cbaday_id']}");

	$update=$kaydet->execute(array(

		'adsoyad' => htmlspecialchars($_POST['cbaday_adsoyad']),
		'resimyol' => $refimgyol

	));


	if ($update) {

		unlink("../../{$_POST['eski_yol']}");

		$data['status']="success";
		$data['message']="Güncelleme Başarılı";
		echo json_encode($data);
		exit;
		
	} else {
		$data['status']="error";
		$data['message']="Güncelleme Başarısız";
		echo json_encode($data);
		exit;

	}

}


if ($_GET['adaysil']=="ok") {
	
	$sil=$db->prepare("DELETE from cbaday where cbaday_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['cbaday_id']
	));

	if ($kontrol) {
		
		Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarili");

	} else {

		Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarisiz");


	}
}





if (isset($_POST['ayarekle'])) {

	
	if (strlen($_POST['ayar_ad'])==0 or strlen($_POST['ayar_tur'])==0) {
		
		$data['status']="error";
		$data['message']="Tüm alanları doldurmalısınız";
		echo json_encode($data);
		exit;

	}
	
	
	$kaydet=$db->prepare("INSERT INTO ayar SET 
		ayar_ad=:ad,
		ayar_tur=:tur

		");

	$insert=$kaydet->execute(array(

		'ad' => htmlspecialchars($_POST['ayar_ad']),
		'tur' => htmlspecialchars($_POST['ayar_tur'])

	));


	if ($insert) {

		session_destroy();

		$data['status']="success";
		$data['message']="Kayıt Başarılı";
		echo json_encode($data);
		exit;
		
	} else {
		$data['status']="error";
		$data['message']="Kayıt Başarısız";
		echo json_encode($data);
		exit;

	}

}


if (isset($_POST['ayarduzenle'])) {

	
	if (strlen($_POST['ayar_ad'])==0 or strlen($_POST['ayar_tur'])==0) {
		
		$data['status']="error";
		$data['message']="Tüm alanları doldurmalısınız";
		echo json_encode($data);
		exit;

	}
	
	$ayar_id=base64_decode($_POST['ayar_id']);

	$kaydet=$db->prepare("UPDATE ayar SET 
		ayar_ad=:ad,
		ayar_tur=:tur

		WHERE ayar_id=$ayar_id");

	$update=$kaydet->execute(array(

		'ad' => htmlspecialchars($_POST['ayar_ad']),
		'tur' => htmlspecialchars($_POST['ayar_tur'])

	));


	if ($update) {
		session_destroy();

		$data['status']="success";
		$data['message']="Kayıt Başarılı";
		echo json_encode($data);
		exit;
		
	} else {
		$data['status']="error";
		$data['message']="Kayıt Başarısız";
		echo json_encode($data);
		exit;

	}

}


if ($_GET['ayarsil']=="ok") {
	
	$sil=$db->prepare("DELETE from ayar where ayar_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['ayar_id']
	));

	if ($kontrol) {
		
		Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarili");

	} else {

		Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarisiz");


	}
}



if (isset($_POST['oymail'])) {


	if (empty($_POST['kullanici_mail'])) {
		

		$data['status']="error";
		$data['message']="Mail Adresinizi Giriniz...";
		echo json_encode($data);
		exit;

	} 


	$oysor=$db->prepare("SELECT * FROM oy where oy_araci=:araci");
	$oysor->execute(array(
		'araci' => $_POST['kullanici_mail']
	));

	$say=$oysor->rowCount();

	if ($say>0) {

		$_SESSION['oydurum']=1;

		$data['status']="info";
		$data['message']="Malesef Daha önce oy kullandınız. Sonuçları Görebilirsiniz.";
		$data['oydurum']=1;
		echo json_encode($data);
		exit;

	}


	


	$mailKonu="CB Anket Onay Kodunuz";
	$mesaj=rand(1000,9999);
	$_SESSION['anketmailonaymesaj']=$mesaj;
	$_SESSION['kullanici_mail']=$_POST['kullanici_mail'];

	mailgonder($_POST['kullanici_mail'],$mailKonu,$mesaj);

	$data['status']="success";
	$data['message']="Mail Onay Kodunuz Gönderilmiştir. Mail Adresinizi Kontrol Ediniz. Spam Klasörüne Düşebilir.";
	$data['islemno']="1";
	echo json_encode($data);
	exit;



}


if (isset($_POST['onaykodu'])) {

	if ($_SESSION['anketmailonaymesaj']==$_POST['kullanici_onaykodu']) {



		$kaydet=$db->prepare("INSERT INTO oy SET 
			cbaday_id=:id,
			oy_araci=:araci

			");

		$insert=$kaydet->execute(array(

			'id' =>  $_POST['cbaday_id'],
			'araci' => $_SESSION['kullanici_mail']

		));


		if ($insert) {

			$_SESSION['oydurum']=1;

			$data['status']="success";
			$data['message']="Oyunuz Başarıyla Kaydedildi";
			$data['islemno']="2";

			echo json_encode($data);
			exit;

		} else {
			$data['status']="error";
			$data['message']="Oy Verme İşlemi Başarısız.";
			echo json_encode($data);
			exit;

		}


		
	} else {

		$data['status']="error";
		$data['message']="Onay Kodu Hatalı";
		echo json_encode($data);
		exit;
	}
	
	

}



if (isset($_POST['sonucsorgula'])) {


	if (empty($_POST['oy_araci'])) {
		

		$data['status']="error";
		$data['message']="Oy Kullanmadan Sonuçları Göremezsiniz. Oy Kullandıysanız Mail Adresinizi yada Cep Telefonunuzu Girmelisiniz.";
		echo json_encode($data);
		exit;

	} 

	

	$oysor=$db->prepare("SELECT * FROM oy where oy_araci=:araci");
	$oysor->execute(array(
		'araci' => $_POST['oy_araci']
	));

	$say=$oysor->rowCount();

	if ($say>0) {

		$_SESSION['oydurum']=1;

		$data['status']="info";
		$data['message']="Malesef Daha önce oy kullandınız. Sonuçları Görebilirsiniz.";
		$data['oydurum']=1;
		$data['oyyok']=1;
		echo json_encode($data);
		exit;

	} else {

		$data['status']="info";
		$data['message']="Malesef henüz oy kullanmadınız. Sonuçları sadece oy kullananlar görebilir.";
		$data['oyyok']=0;
		echo json_encode($data);
		exit;
	}


	


	$mailKonu="CB Anket Onay Kodunuz";
	$mesaj=rand(1000,9999);
	$_SESSION['anketmailonaymesaj']=$mesaj;
	$_SESSION['kullanici_mail']=$_POST['kullanici_mail'];

	mailgonder($_POST['kullanici_mail'],$mailKonu,$mesaj);

	$data['status']="success";
	$data['message']="Mail Onay Kodunuz Gönderilmiştir. Mail Adresinizi Kontrol Ediniz. Spam Klasörüne Düşebilir.";
	$data['islemno']="1";
	echo json_encode($data);
	exit;



}


//Sms İşlemleri

if (isset($_POST['oysms'])) {


	if (empty($_POST['kullanici_gsm'])) {
		

		$data['status']="error";
		$data['message']="Cep Telefon Numaranızı Girmelisiniz...";
		echo json_encode($data);
		exit;

	} 

	

	$oysor=$db->prepare("SELECT * FROM oy where oy_araci=:araci");
	$oysor->execute(array(
		'araci' => $_POST['kullanici_gsm']
	));

	$say=$oysor->rowCount();

	if ($say>0) {

		$_SESSION['oydurum']=1;

		$data['status']="info";
		$data['message']="Malesef Daha önce oy kullandınız. Sonuçları Görebilirsiniz.";
		$data['oydurum']=1;
		echo json_encode($data);
		exit;

	}

	

	
	$onaykodu=rand(1000,9999);
	$mesaj="Cum. Bşk. Seçimi Anket Onay Kodunuz: $onaykodu";
	$tel=str_replace("-", "", $_POST['kullanici_gsm']);
	$baslik='EDUKEYCOMTR';

	$mesaj = html_entity_decode($mesaj, ENT_COMPAT, "UTF-8"); 
	$mesaj = rawurlencode($mesaj); 

	$baslik = html_entity_decode($baslik, ENT_COMPAT, "UTF-8"); 
	$baslik = rawurlencode($baslik); 


	$smssonuc=sendsms($mesaj,$tel,$baslik);




	

	$_SESSION['anketsmsonaymesaj']=$onaykodu;
	$_SESSION['kullanici_gsm']=$tel;



	$data['status']="success";
	$data['message']="Anket Onay Kodunuz Gönderilmiştir.";
	$data['islemno']="1";
	echo json_encode($data);
	exit;



}




if (isset($_POST['onaykodusms'])) {

	if ($_SESSION['anketsmsonaymesaj']==$_POST['kullanici_smsonaykodu']) {



		$kaydet=$db->prepare("INSERT INTO oy SET 
			cbaday_id=:id,
			oy_araci=:araci

			");

		$insert=$kaydet->execute(array(

			'id' =>  $_POST['cbaday_id'],
			'araci' => $_SESSION['kullanici_gsm']

		));


		if ($insert) {

			$_SESSION['oydurum']=1;

			$data['status']="success";
			$data['message']="Oyunuz Başarıyla Kaydedildi";
			$data['islemno']="2";

			echo json_encode($data);
			exit;

		} else {
			$data['status']="error";
			$data['message']="Oy Verme İşlemi Başarısız.";
			echo json_encode($data);
			exit;

		}


		
	} else {

		$data['status']="error";
		$data['message']="Onay Kodu Hatalı";
		echo json_encode($data);
		exit;
	}
	
	

}

?>