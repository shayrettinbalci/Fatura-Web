<?php
require_once 'islem.php';
require_once 'password.php';


//Kullanıcı kaydet regular Exp.
$kullanici_adi = $parola = $parolatekrar = $isim = $soyisim = $email = $yetki = "";
$yetkiArr=array('3'=>'1','2'=>'1','1'=>'1','0'=>'1');
$_SESSION["kullanici_adiErr"] = $_SESSION["parolaErr"] = $_SESSION["parolatekrarErr"] = $_SESSION["isimErr"] = $_SESSION["soyisimErr"] = $_SESSION["emailErr"] = "";

	//Kullanıcı Ekleme
if (isset($_POST['kullanici_ekle'])) {

	if (!preg_match($adRegex, $_POST["kullanici_adi"]) || empty($_POST["kullanici_adi"])) 
	{
		$_SESSION["kullanici_adiErr"] = "Kullanıcı adı: Geçersiz karakter girildi ya da boş";
		$count++;
	} else {
		$kullanici_adi=test_input($_POST["kullanici_adi"]);
	}

	if (!preg_match($parolaRegex, $_POST["parola"]) || empty($_POST["parola"])) 
	{
		$_SESSION["parolaErr"] = "Parola: Uzunluk(6-16) ve en az 1 karakter, sayı.";
		$count++;
	} else	{
		$parola=test_input($_POST["parola"]);
	}

	if (!preg_match($parolaRegex, $_POST["parolatekrar"]) || empty($_POST["parolatekrar"])) 
	{
		$_SESSION["parolatekrarErr"] = "Parola(Tekrar): Uzunluk(6-16) ve en az 1 karakter, sayı.";
		$count++;
	} else	{
		$parolatekrar=test_input($_POST["parolatekrar"]);
	}

	if (!preg_match($isimRegex, $_POST["isim"]) || empty($_POST["isim"])) 
	{
		$_SESSION["isimErr"] = "Ad Soyad: Geçersiz karakter girildi ya da boş";
		$count++;
	} else	{
		$isim=test_input($_POST["isim"]);
	}

	if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) 
		|| empty($_POST["email"])) 
	{
		$_SESSION["emailErr"] = "Geçersiz email";
		$count++;
	} else	{
		$email=test_input($_POST["email"]);
	}
	if(!$yetkiArr[$_POST['yetki']]){
		$count++;
	} else{
		$yetki=test_input($_POST['yetki']);
	}

	if($count == 0){
		$kullaniciekle=$db->prepare("INSERT INTO kullanici SET
			kullanici_adi=:kullanici_adi,
			kullanici_parola=:kullanici_parola,
			kullanici_isim=:kullanici_isim,
			kullanici_email=:kullanici_email,
			kullanici_yetki=:kullanici_yetki
			");
		if ($parola == $parolatekrar){
			$hashedPassword=password_hash($parola,PASSWORD_BCRYPT);
			$insert=$kullaniciekle->execute(array(
				'kullanici_adi' => $kullanici_adi,
				'kullanici_parola' => $hashedPassword,
				'kullanici_isim' => $isim,
				'kullanici_email' => $email,
				'kullanici_yetki' => $yetki
			));
			if ($insert) {
				$_SESSION["formValidateInfo"] = "*Kullanıcı başarıyla eklenmiştir.";
				header("Location:../admin-panel?durum=ok");

			} else {
				$_SESSION["formValidateInfo"] = "*Kullanıcı eklenemedi.";
				header("Location:../admin-panel?durum=no");
			}
		}else{
			$_SESSION["formValidateInfo"] = "*Parola eşleşmiyor.";
			header("Location:../admin-panel?durum=no");
		}
	}else{
		$_SESSION["formValidateInfo"] = "*Kullanıcı eklenemedi.";
		header("Location:../admin-panel?durum=no");
	}	
}
	//Kullanıcı silme
if(isset($_POST["kullaniciDeleteID"]) && !empty($_POST["kullaniciDeleteID"])){
	$id = $_POST["kullaniciDeleteID"];
    // Prepare a delete statement
	$sql = "DELETE FROM kullanici WHERE id = $id";

	if($stmt = $db->prepare($sql)){
        // Attempt to execute the prepared statement
		if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
			$_SESSION["generalInformationModalContent"] = "Kullanıcı başarıyla silindi.";
			header("location: ../admin-panel");
		} else{
			$_SESSION["generalInformationModalContent"] = "Kullanıcı silinemedi.";
			header("location: ../admin-panel");
		}
	}
    // Close statement
	unset($stmt);
}

?>