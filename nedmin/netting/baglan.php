
<?php 


try {


	$db=new PDO("mysql:host=localhost;dbname=cbsecim;charset=utf8",'root','');

/*	echo "başarılı";
*/
} 
catch (PDOException $e) {


	echo $e->getMessage();

}

require_once 'class.phpmailer.php';

 ?>