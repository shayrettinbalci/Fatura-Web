<!DOCTYPE html>
<html lang="tr">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.0.0/jq-3.2.1/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/sl-1.2.5/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/login.css"/>
	<link rel="icon" href=Img/example-logo.png>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.0.0/jq-3.2.1/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/sl-1.2.5/datatables.min.js"></script>
	<script type="text/javascript" src="http://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.js"></script>
	<script type="text/javascript" src="Js/AAl.js"></script>
</head>
<body>
	<?php date_default_timezone_set('Europe/Istanbul'); ?>
<form class="form-signin" action="SourcePHP/kullaniciS.php" method="POST">
	<div class="text-center">
		<img class="mb-4" src="Img/example-logo.png" alt="Img/example-logo.png" class="rounded">
		<h1 class="h3 mb-3 font-weight-normal" >Giriş Yapınız</h1>
		<label for="Fkullanici_adi" class="sr-only">Kullanıcı Adı</label>
		<input type="text" id="Fkullanici_adi" name="kullanici_adi" placeholder="Kullanıcı Adı" class="form-control">
		<label for="Fkullanici_parola" class="sr-only">Parola</label>
		<input type="password" id="Fkullanici_parola" name="kullanici_parola" placeholder="Parola" class="form-control">
		<br>
		<button class="btn btn-lg btn-primary btn-block" name="kullanici_giris" type="submit">Giriş</button>
		<p class="mt-5 mb-3 text-muted">Copyright &copy; <?php echo date('Y') ?></p>
	</div>
</form>
</body>