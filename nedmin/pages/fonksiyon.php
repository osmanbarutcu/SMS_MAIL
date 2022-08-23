<?php 
ob_start();
session_start();
date_default_timezone_set('Europe/Istanbul');

function mailgonder($kullanici_mail,$mailKonu,$mesaj) {

	$from="cbaday@emrahyuksel.com.tr"; // Mail
	$host="mail.emrahyuksel.com.tr"; //SMTP sunucu
	$pass="Şifre Girilecek";


	$mail = new PHPMailer();
	$mail->IsSMTP(true);
	$mail->From     = $from;
	$mail->Sender   = $from;
	$mail->AddAddress($kullanici_mail); 
	$mail->AddReplyTo=($kullanici_mail);
	$mail->FromName = $gonderici;
	$mail->Host     = $host;
	$mail->SMTPAuth = true;
	$mail->Port     = 587;
	$mail->CharSet = 'UTF-8';
	$mail->Username = $from;
	$mail->Password = $pass;
	$mail->Subject  = $mailKonu;
	$mail->IsHTML(true);
	$mail->Body = "
	Anket Onay Kodunuz : $mesaj
	<hr><br>
	<p>Anket Onay Kodunuz Yukarıda Paylaşılmıştır</p><br>
	";


	$mail->Send();




}



function sendsms($msg, $telno, $header) 
{
  $username= "username"; //Kullanıcı Adı
  $pass= "şifre"; // Şifre

  //Not NET Gsmden kullanıcı adı parola alındıktan sonra panelden apilere izinleri vermelisiniz.
  
  $startdate=date('d.m.Y H:i');
  $startdate=str_replace('.', '',$startdate );
  $startdate=str_replace(':', '',$startdate);
  $startdate=str_replace(' ', '',$startdate);
  
  $stopdate=date('d.m.Y H:i', strtotime('+1 day'));
  $stopdate=str_replace('.', '',$stopdate );
  $stopdate=str_replace(':', '',$stopdate);
  $stopdate=str_replace(' ', '',$stopdate);

  
	$url="http://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=$telno&message=$msg&msgheader=$header&startdate=$startdate&stopdate=$stopdate";
	//echo $url;
	
    $ch = curl_init(); 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
    $output=curl_exec($ch);
    curl_close($ch);
    return $output;
	
}



?>