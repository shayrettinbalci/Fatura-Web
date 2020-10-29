<?php
require_once 'islem.php';
require_once 'password.php';

    //Giriş Kontrol
if (isset($_POST['kullanici_giris'])) {
	$kullanici_adi=$_POST['kullanici_adi'];
	$kullanici_parola=$_POST['kullanici_parola'];
	//1-Find input username in database table
	$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_adi=:ad");
	//2-Execute and retrieve assigned row
	$kullanicisor->execute(array('ad' => $kullanici_adi));

	$saydir=$kullanicisor->rowCount();
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
	if ($saydir==1&&password_verify($kullanici_parola,$kullanicicek['kullanici_parola'])) {
		$_SESSION['kullanici_adi']=$kullanici_adi;
		header("Location:../main-index");
		exit;
	} else {
		header("Location:../giris-panel?durum=no");
		exit;
	}
}
	//Parola Değiştir
if(isset($_POST["kullanici_parolaDegistir"])){
	$kullanici_adi=$_POST['kullanici_Fadi5'];
	//RegEx
	if (!preg_match($parolaRegex, $_POST["kullanici_parolaYeni"])||!preg_match($parolaRegex, $_POST["kullanici_parolaTekrar"]))
	{
		$_SESSION["generalInformationModalContent"] = "Uygun parola giriniz.";
		header("location: ../main-index");
		exit;
	} else	{
		$parolaEski=test_input($_POST["kullanici_parolaEski"]);
		$parolaYeni=test_input($_POST["kullanici_parolaYeni"]);
		$parolaYeniTekrar=test_input($_POST["kullanici_parolaTekrar"]);
	}
	//
	$sqlRetrieveQuery="SELECT * FROM kullanici where kullanici_adi=:ad";
	$sqlParolaUpdateQuery="UPDATE kullanici SET kullanici_parola=:yeniparola WHERE kullanici_adi=:ad";
	$parolaRetrievePre=$db->prepare($sqlRetrieveQuery);
	$parolaUpdatePre=$db->prepare($sqlParolaUpdateQuery);
	//2-Execute and retrieve assigned row
	$parolaRetrievePre->execute(array('ad' => $kullanici_adi));
	$retrieveUser=$parolaRetrievePre->fetch(PDO::FETCH_ASSOC);

	if($parolaYeniTekrar == $parolaYeni&&password_verify($parolaEski,$retrieveUser['kullanici_parola'])){
		$hashedPassword=password_hash($parolaYeni,PASSWORD_BCRYPT);
		if($parolaUpdatePre->execute(array('yeniparola' => $hashedPassword,'ad'=>$retrieveUser['kullanici_adi']))){
			$_SESSION["generalInformationModalContent"] = "Parola başarıyla değişti.";
			header("location: ../main-index");
		}
		else{
			$_SESSION["generalInformationModalContent"] = "Parola değiştirilemedi.";
			header("location: ../main-index");
		}
	} else{
		$_SESSION["generalInformationModalContent"] = "Parolalar eşleşmiyor.";
		header("location: ../main-index");
	}
}

	//Admin Parola Değiştir
if(isset($_POST["changePass"])){
	$kullanici_adi=$_POST["kullaniciName_changePass"];

	if (!preg_match($parolaRegex, $_POST["Fkullanici_changeparolaYeni"])||!preg_match($parolaRegex, $_POST["Fkullanici_changeparolaTekrar"]))
	{
		$_SESSION["generalInformationModalContent"] = "Uygun parola giriniz.";
		header("location: ../admin-panel");
		exit;
	} else	{
		$parolaYeni=test_input($_POST["Fkullanici_changeparolaYeni"]);
		$parolaYeniTekrar=test_input($_POST["Fkullanici_changeparolaTekrar"]);
	}

	$sqlParolaUpdateQuery="UPDATE kullanici SET kullanici_parola=:yeniparola WHERE kullanici_adi=:ad";
	$parolaUpdatePre=$db->prepare($sqlParolaUpdateQuery);

	if($parolaYeniTekrar == $parolaYeni){
		$hashedPassword=password_hash($parolaYeni,PASSWORD_BCRYPT);
		if($parolaUpdatePre->execute(array('yeniparola' => $hashedPassword,'ad'=>$kullanici_adi))){
			$_SESSION["generalInformationModalContent"] = "Parola başarıyla değişti.";
			header("location: ../admin-panel");
		} else{
			$_SESSION["generalInformationModalContent"] = "Parola değiştirilemedi.";
			header("location: ../admin-panel");
		}
	} else{
		$_SESSION["generalInformationModalContent"] = "Parolalar eşleşmiyor.";
		header("location: ../admin-panel");
	}	
}
	//Admin Email Değiştir
if(isset($_POST["changeEmail"])){
	$kullanici_adi=$_POST["kullaniciName_changeEmail"];

	if (!filter_var($_POST["Fkullanici_changeEmailYeni"], FILTER_VALIDATE_EMAIL) || empty($_POST["Fkullanici_changeEmailYeni"])) 
	{
		$_SESSION["generalInformationModalContent"] = "Uygun Email giriniz.";
		header("location: ../admin-panel");
		exit;
	} else	{
		$changeEmail=test_input($_POST["Fkullanici_changeEmailYeni"]);
	}

	$sqlEmailUpdateQuery="UPDATE kullanici SET kullanici_email=:yeniemail WHERE kullanici_adi=:ad";
	$emailUpdatePre=$db->prepare($sqlEmailUpdateQuery);

	if($emailUpdatePre->execute(array('yeniemail' => $changeEmail,'ad' => $kullanici_adi))){
		$_SESSION["generalInformationModalContent"] = "Email başarıyla değişti.";
		header("location: ../admin-panel");
	} else{
		$_SESSION["generalInformationModalContent"] = "Email başarıyla değişti.";
		header("location: ../admin-panel");
	}
}
?>