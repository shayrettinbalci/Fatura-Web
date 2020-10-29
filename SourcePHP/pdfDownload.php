<?php 
require_once 'islem.php';
require_once 'start.php';

ignore_user_abort(true);
set_time_limit(0); // disable the time limit for this script

$path = realpath("../Faturalar")."/".$_POST["kullanici_Fadi"]."/";
$test = realpath("Java");

$dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $_POST["faturaID"]); // simple file name validation
$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
$fullPath = $path.$dl_file.".pdf";

if ($fd = fopen ($fullPath, "r")) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=\"".$path_parts["basename"]."\""); // use 'inline' to force a file download
        break;
        // add more headers for other content types here
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
        break;
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) {
        $buffer = fread($fd, $fsize);
        echo $buffer;
    }
} else{
    $_SESSION["generalInformationModalContent"] = "Fatura PDF dosyası bulunamadı.";
}
fclose ($fd);
exit;
?>