<?php 
require_once 'islem.php';
require_once 'start.php';

$kullanici_adii = $_POST["kullanici_Fadi2"];
if(!file_exists("../Faturalar/")){
	mkdir("../Faturalar/", 0777, true);
}
if (!file_exists("../Faturalar/" . $kullanici_adii . "/")) {
	mkdir("../Faturalar/" . $kullanici_adii . "/", 0777, true);
}
$target_dir = "../Faturalar/" . $kullanici_adii . "/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$pdfFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$fileName = basename($_FILES["fileToUpload"]["name"]);
$newName = $_POST["faturaEkleID"] . "." . $pdfFileType;//new file name with absolute path

// Check if pdf file is a actual pdf or fake pdf
if(isset($_POST["faturaEkleID"]) && isset($kullanici_adii)) {
	$check = filesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		echo "File is an pdf - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an pdf.";
		$uploadOk = 0;
	}
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 20000000) {
	$_SESSION["generalInformationModalContent"] = "PDF dosyası boyutu 20MB'den az olmalı.";
	header("Location:../fatura-duzenleme-sayfasi");
	$uploadOk = 0;
}
// Allow certain file formats
if($pdfFileType != "pdf" ) {
	$_SESSION["generalInformationModalContent"] = "Sadece PDF dosyası yüklenebilir.";
	header("Location:../fatura-duzenleme-sayfasi");
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	$_SESSION["generalInformationModalContent"] = "PDF dosyası yüklenemedi.";
	header("Location:../fatura-duzenleme-sayfasi");
// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		rename($target_file, $target_dir . $newName);
		$_SESSION["generalInformationModalContent"] = $fileName." dosyası başarıyla eklendi.";
		header("Location:../fatura-duzenleme-sayfasi");
	} else {
		$_SESSION["generalInformationModalContent"] = $fileName." dosyası eklenemedi";
		header("location:../fatura-duzenleme-sayfasi");
	}
}
?>