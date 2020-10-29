<?php 

//Çoklu Dil Mantığı if/else

//$_SESSION['tr'];
//veya
////$_SESSION['eng'];

try {
	$db=new PDO("mysql:host=localhost;dbname=faturadb;charset=utf8",'root','12501250');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch (PDOExpception $e) {

	echo $e->getMessage();
}
 ?>