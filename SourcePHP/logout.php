<?php 
session_start();

session_destroy();
header("Location:../giris-panel?durum=exit");

?>