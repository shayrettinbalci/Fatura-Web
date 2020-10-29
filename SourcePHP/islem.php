<?php 
require_once 'baglan.php';

ob_start();
session_start();

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$count = 0;
//Execute true or false massages
$_SESSION["formValidateInfo"] = "";
$_SESSION["generalInformationModalContent"] = "";

//English Up-low case, digit, alt tire 
$adRegex="/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/";
//Minimum 6 maximum 16 characters, at least one letter and one number
$parolaRegex="/^(?=.*[A-Za-zşŞçÇğĞİöÖüÜı])(?=.*\d)[A-Za-zşŞçÇğĞİöÖüÜı\d]{6,16}$/";
//Ex:Martin Luther-King, Jr.
$isimRegex="/^[a-zA-ZşŞçÇğĞİöÖüÜı ,.'-]{2,36}+$/i";
//All prices to USD, TR, EURO
$tutarRegex="/^(?:^[+-]?[0-9]{1,3}(?:[0-9]*(?:[.,][0-9]{2})?|(?:,[0-9]{3})*(?:\.[0-9]{2})?|(?:\.[0-9]{3})*(?:,[0-9]{2})?)$)$/i";

?>