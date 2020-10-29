<?php
require_once 'islem.php';

//Fatura kaydet regular Exp. and Input Check Arrays
$musteri = $partner = $manager = $ay = $tutar = $birim = $vergi_yuzde = $isin_turu = $damga_vergisi = $aciklama = "";
$ayArr=array('Ocak'=>'1','Şubat'=>'1','Mart'=>'1','Nisan'=>'1','Mayıs'=>'1','Haziran'=>'1','Temmuz'=>'1','Ağustos'=>'1','Eylül'=>'1','Ekim'=>'1','Kasım'=>'1','Aralık'=>'1');
$birimArr=array('₺'=>'1','$'=>'1','€'=>'1');
$vergi_yuzdeArr=array(18=>'1',8=>'1',1=>'1',0=>'1');
$isin_turuArr=array('sd'=>'1','sdd'=>'1','st'=>'1','sdt'=>'1','kdv'=>'1','my'=>'1');
$damgavergiArr=array('yok'=>'1','odeyecek'=>'1','odeyecegiz'=>'1'); 
$fatura_turuArr=array('fatura' =>'1', 'arsiv' => '1');
$_SESSION["musteriErr"] = $_SESSION["partnerErr"] = $_SESSION["managerErr"] = $_SESSION["tutarErr"] = $_SESSION["aciklamaErr"] = "";

//Musteri kaydet regular Exp.
$musteri_adi = $musteri_adresi = $musteri_vergiNumarasi = "";
$_SESSION["musteri_adiErr"] = $_SESSION["musteri_adresiErr"] = $_SESSION["musteri_vergiNumarasiErr"] =  "";
$musteri_faturaturuArr=array('fatura' =>'1', 'arsiv' => '1');

	//Fatura Girme
if (isset($_POST['fatura_kaydet'])) {

	if (empty($_POST["musteri"])) 
	{
		$_SESSION["musteriErr"] = "Müşteri: Boş bırakmayınız.";
		$count++;
	} else {
		$musteri=test_input($_POST["musteri"]);
	}
	if (empty($_POST["partner"])) 
	{
		$_SESSION["partnerErr"] = "Partner: Boş bırakmayınız.";
		$count++;
	} else {
		$partner=test_input($_POST["partner"]);
	}
	if (empty($_POST["manager"])) 
	{
		$_SESSION["managerErr"] = "Manager: Boş bırakmayınız.";
		$count++;
	} else {
		$manager=test_input($_POST["manager"]);
	}
	if(!$ayArr[$_POST["ay"]]){
		$count++;
	} else {
		$ay=test_input($_POST["ay"]);
	}
	if (!preg_match($tutarRegex, $_POST["tutar"]) || empty($_POST["tutar"])) 
	{
		$_SESSION["tutarErr"] = "Tutar: Geçersiz karakter girildi ya da boş";
		$count++;
	} else {
		$tutar=test_input($_POST["tutar"]);
		//CleanUp
		//For DataBase

		//number and all ',','.'
		$tutar = preg_replace('#[^0-9,.]+#', '', $tutar);
		//decimal string(',' or '.')
		$dec = substr($tutar, -3, 1);
		//existing check
		if ( $dec == ',' || $dec == '.' ) {
			$dec = 2;
		} else {
			$dec = 0;
		}
		//Taking just number and after adding decimal point
		$tutar = preg_replace('#[^0-9]+#', '', $tutar);
		if ( $dec ) {
			$tutar = $tutar/100;
		}
		$tutar = number_format($tutar, $dec, '.', '');
	}
	if(!$birimArr[$_POST["birim"]]){
		$count++;
	} else {
		$birim=test_input($_POST["birim"]);
	}
	if(!$vergi_yuzdeArr[$_POST["vergi_yuzde"]]){
		$count++;
	} else {
		$vergi_yuzde=test_input($_POST["vergi_yuzde"]);
	}
	if(!$isin_turuArr[$_POST['isin_turu']]){
		$count++;
	} else {
		$isin_turu=test_input($_POST['isin_turu']);
	}
	if(!$damgavergiArr[$_POST['damga_vergisi']]){
		$count++;
	} else {
		$damga_vergisi=test_input($_POST['damga_vergisi']);
	}
	if(!$fatura_turuArr[$_POST['fatura_turu']]){
		$count++;
	} else {
		$fatura_turu=test_input($_POST["fatura_turu"]);
	}
	$aciklama=test_input($_POST["aciklama"]);//no regex for text

	if($count == 0){

		$faturakaydet=$db->prepare("INSERT into fatura SET
			kullanici_isim=:kullanici_isim,
			kullanici_Fadi=:kullanici_Fadi,
			musteri=:musteri,
			partner=:partner,
			manager=:manager,
			fatura_tarihi=:fatura_tarihi,
			tutar=:tutar,
			birim=:birim,
			vergi_yuzde=:vergi_yuzde,
			isin_turu=:isin_turu,
			damga_vergisi=:damga_vergisi,
			fatura_turu=:fatura_turu,
			aciklama=:aciklama
			");

		$insert=$faturakaydet->execute(array(
			'kullanici_isim' => $_POST['kullanici_isim'],
			'kullanici_Fadi' => $_POST['kullanici_Fadi'],
			'musteri' => $musteri,
			'partner' => $partner,
			'manager' => $manager,
			'fatura_tarihi' => $ay,
			'tutar' => $tutar,
			'birim' => $birim,
			'vergi_yuzde' => $vergi_yuzde,
			'isin_turu' => $isin_turu,
			'damga_vergisi' => $damga_vergisi,
			'fatura_turu' => $fatura_turu,
			'aciklama' => $aciklama
		));
	}

	if ($insert) {
		$_SESSION["formValidateInfo"] = "*Fatura başarıyla eklenmiştir.";
		header("Location: ../fatura-giris-sayfasi?durum=ok");

	} else {
		$_SESSION["formValidateInfo"] = "*Fatura eklenemedi.";
		header("Location: ../fatura-giris-sayfasi?durum=no");
	}
}
	//Musteri Kaydetme
if(isset($_POST["musteri_kaydet"])){
	if (empty($_POST["musteri_adi"])) 
	{
		$_SESSION["musteri_adiErr"] = "Müşteri Adı: Boş bırakmayınız.";
		$count++;
	} else {
		$musteri_adi=test_input($_POST["musteri_adi"]);
	}
	if (empty($_POST["musteri_adresi"])) 
	{
		$_SESSION["musteri_adresiErr"] = "Müşteri Adresi: Boş bırakmayınız.";
		$count++;
	} else {
		$musteri_adresi=test_input($_POST["musteri_adresi"]);
	}
	if (empty($_POST["musteri_vergiNumarasi"])) 
	{
		$_SESSION["musteri_vergiNumarasiErr"] = "Müşteri Vergi Numarası: Boş bırakmayınız.";
		$count++;
	} else {
		$musteri_vergiNumarasi=test_input($_POST["musteri_vergiNumarasi"]);
	}
	if(!$musteri_faturaturuArr[$_POST['musteri_turu']]){
		$count++;
	} else {
		$musteri_turu=test_input($_POST["musteri_turu"]);
	}
		

	if($count == 0){

		$musterikaydet=$db->prepare("INSERT into musteri SET
			musteri_ad=:ad,
			musteri_adres=:adres,
			musteri_vergino=:no,
			musteri_turu=:tur
			");

		$insert=$musterikaydet->execute(array(
			'ad' => $musteri_adi,
			'adres' => $musteri_adresi,
			'no' => $musteri_vergiNumarasi,
			'tur' => $musteri_turu
		));
	}

	if ($insert) {
		$_SESSION["formValidateInfo"] = "*Müşteri başarıyla eklenmiştir.";
		header("Location: ../musteri-sayfasi?durum=ok");

	} else {
		$_SESSION["formValidateInfo"] = "*Müşteri eklenemedi.";
		header("Location: ../musteri-sayfasi?durum=no");
	}
}
	//Fatura silme
if(isset($_POST["faturaDelete_id"]) && !empty($_POST["faturaDelete_id"])){
	$fatura_id = $_POST["faturaDelete_id"];
    // Prepare a delete statement
	$sql = "DELETE FROM fatura WHERE faturaID = $fatura_id";

	if($stmt = $db->prepare($sql)){
        // Attempt to execute the prepared statement
		if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
			$_SESSION["generalInformationModalContent"] = "Fatura başarıyla silindi.";
			header("location: ../fatura-duzenleme-sayfasi");
		} else{
			$_SESSION["generalInformationModalContent"] = "Fatura silinemedi.";
			header("location: ../fatura-duzenleme-sayfasi");
		}
	}
    // Close statement
	unset($stmt);
} 
	//Müşteri silme
if(isset($_POST["musteriDeleteID"]) && !empty($_POST["musteriDeleteID"])){
	$id = $_POST["musteriDeleteID"];
    // Prepare a delete statement
	$sql = "DELETE FROM musteri WHERE musteri_ID = $id";

	if($stmt = $db->prepare($sql)){
        // Attempt to execute the prepared statement
		if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
			$_SESSION["generalInformationModalContent"] = "Müşteri başarıyla silindi.";
			header("location: ../musteri-sayfasi");
		} else{
			$_SESSION["generalInformationModalContent"] = "Müşteri silinemedi.";
			header("location: ../musteri-sayfasi");
		}
	}
    // Close statement
	unset($stmt);
}
	//Fatura Onay
if(isset($_POST["faturaOnay_id"]) && !empty($_POST["faturaOnay_id"])){
	$onay=1;
	$fatura_id=$_POST["faturaOnay_id"];
	$fatura_name=$_POST["faturaOnay_name"];
	$fatura_No=test_input($_POST["faturaNoName"]);
	$controlPath ="../Faturalar/".$fatura_name."/" . $fatura_id . ".pdf";

	if(empty($fatura_No)){
		$_SESSION["generalInformationModalContent"] = "Fatura Numarası doldurulmamış.";
		header("location: ../fatura-duzenleme-sayfasi");
		exit;
	}
    // Prepare a delete statement
	$sql = "UPDATE fatura SET onay_durumu=:onay_durumu,fatura_no=:fatura_no WHERE faturaID=:faturaID";
	if(file_exists($controlPath)){
		if($stmt = $db->prepare($sql)){
        // Attempt to execute the prepared statement
			if($stmt->execute(array('onay_durumu'=>$onay,'fatura_no'=>$fatura_No,'faturaID'=>$fatura_id))){
            // Records deleted successfully. Redirect to landing page
				$_SESSION["generalInformationModalContent"] = "Fatura başarıyla onaylandı.";
				header("location: ../fatura-duzenleme-sayfasi");
			} else{
				$_SESSION["generalInformationModalContent"] = "Fatura onaylanamadı.";
				header("location: ../fatura-duzenleme-sayfasi");
			}
		}
	} else {
		$_SESSION["generalInformationModalContent"] = "PDF eklemeden onaylamayın.";
		header("location: ../fatura-duzenleme-sayfasi");
	}	
    // Close statement
	unset($stmt);
} 
	//Fatura iptal
if(isset($_POST["iptalFaturaID"]) && !empty($_POST["iptalFaturaID"])){
	$fatura_id=$_POST["iptalFaturaID"];
	$fatura_name=$_POST["iptalFatura_name"];
	$iptaltaleb=$_POST["istek_iptal"];
	$onay=0;

	$sqlRetrieveQuery="SELECT * FROM fatura where faturaID=:iptalID";
	$iptalRetrievePre=$db->prepare($sqlRetrieveQuery);
	$iptalRetrievePre->execute(array('iptalID' => $fatura_id));
	$iptalRetrieve=$iptalRetrievePre->fetch(PDO::FETCH_ASSOC);
	$iptalonay=$iptalRetrieve['onay_durumu'];

	if($iptalonay==0){
		$sql = "UPDATE fatura SET istek_iptal=:iptaltalep WHERE faturaID=:fatura_idd";
		if($stmt = $db->prepare($sql)){
        // Attempt to execute the prepared statement
			if($stmt->execute(array('iptaltalep' => $iptaltaleb,'fatura_idd' => $fatura_id))){
				$_SESSION["generalInformationModalContent"] = "İptal talebi gönderildi";
				header("location: ../fatura-giris-sayfasi");
			} else{
				$_SESSION["generalInformationModalContent"] = "Fatura talebi gönderilemedi.";
				header("location: ../fatura-giris-sayfasi");
			}
		}
	}
	else{
		$sqlonay = "UPDATE fatura SET onay_durumu=:onay WHERE faturaID = $fatura_id";
		$sql = "UPDATE fatura SET istek_iptal=:iptaltalep WHERE faturaID=:fatura_idd";
		if($stmt1 = $db->prepare($sql)){
        // Attempt to execute the prepared statement
			$stmt2 = $db->prepare($sqlonay);
			if($stmt1->execute(array('iptaltalep' => $iptaltaleb,'fatura_idd' => $fatura_id))){
				$stmt2->execute(array('onay'=>$onay));
				$_SESSION["generalInformationModalContent"] = "İptal talebi gönderildi";
				header("location: ../fatura-giris-sayfasi");
			} else{
				$_SESSION["generalInformationModalContent"] = "Fatura talebi gönderilemedi.";
				header("location: ../fatura-giris-sayfasi");
			}
		}

	}
	unset($stmt2);
	unset($stmt1);
}
?>