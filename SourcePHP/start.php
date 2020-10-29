<?php
ob_start();
session_start();
$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_adi=:ad");
$kullanicisor->execute(array(
	'ad' => $_SESSION['kullanici_adi']));

$saydir=$kullanicisor->rowCount();
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
if ($saydir==0){	
	Header("Location: giris-panel?durum=izinsiz");
	exit;
}
$yetki = $kullanicicek['kullanici_yetki'];

$faturasor=$db->prepare("SELECT * FROM fatura order by giris_tarih DESC");
$faturasor->execute();
?>