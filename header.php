<!DOCTYPE html>
<html lang="tr">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.0.0/jq-3.2.1/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/sl-1.2.5/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/random.css"/>
	<link rel="stylesheet" type="text/css" href="Js/jquery-ui/jquery-ui.min.css"/>
	<link rel="icon" href=Img/example-logo.png>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.0.0/jq-3.2.1/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/sl-1.2.5/datatables.min.js"></script>
	<script type="text/javascript" src="http://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.js"></script>
	<script type="text/javascript" src="Js/jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="Js/AAl.js"></script>
</head>
<body>
	
	<!-- Change Password Modal -->
	<div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="changePass" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="changePass">Parola Değiştir</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="SourcePHP/kullaniciS.php" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<label for="Fkullanici_parolaEski">Eski Parola</label>
							<input type="password" id="Fkullanici_parolaEski" class="form-control" name="kullanici_parolaEski">
						</div>
						<div>
							<input type="hidden" value="<?php echo $kullanicicek['kullanici_adi']?>" name="kullanici_Fadi5">
						</div>
						<div class="form-group">
							<label for="Fkullanici_parolaYeni">Yeni Parola:</label>
							<input type="password" id="Fkullanici_parolaYeni" class="form-control" name="kullanici_parolaYeni">
						</div>
						<div class="form-group">
							<label for="Fkullanici_parolaTekrar">Yeni Parola(Tekrar):</label>
							<input type="password" id="Fkullanici_parolaTekrar" class="form-control" name="kullanici_parolaTekrar">
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" name="kullanici_parolaDegistir" type="submit">Uygula</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- General Modal -->
	<div class="modal fade" id="generalModal" tabindex="-1" role="dialog" aria-labelledby="generalModalTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
	<!-- Canceling Modal -->
	<div class="modal fade" id="iptalModal" tabindex="-1" role="dialog" aria-labelledby="generalModalTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button class="btn btn-primary" id="iptalSubmit" >Talebi Gönder</button>
					<button class="btn btn-secondary" data-dismiss="modal">Kapat</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<header>
		<?php	date_default_timezone_set('Europe/Istanbul'); ?>
			<nav class="navbar navbar-fluid navbar-expand-lg bd-navbar navbar-light bg-light">
				<a href="main-index" class="navbar-brand"><img src="Img/example-logo.png"></a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="main-index">Anasayfa</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="fatura-giris-sayfasi">Fatura Sayfası</a>
						</li>
						<?php if($yetki == "1" || $yetki == "2" || $yetki == "0"){ ?>
						<li class="nav-item">
							<a class="nav-link" href="musteri-sayfasi">Müşteriler</a>
						</li>
						<?php } ?>
						<?php if($yetki == "1" || $yetki == "2" || $yetki == "3"){ ?>
							<li class="nav-item">
								<a class="nav-link" href="fatura-duzenleme-sayfasi">Fatura Görüntüleme</a>
							</li>
						<?php }
						?>
						<?php if($yetki == "2"){ ?>
							<li class="nav-item">
								<a class="nav-link" href="admin-panel">Admin</a>
							</li>
						<?php } ?>
					</ul>

					<div class="dropdown my-2 my-lg-0">
						<a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php echo $kullanicicek['kullanici_isim']?>
						</a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							<button class="dropdown-item" type="button" data-toggle="modal" data-target="#changePassModal">Parola değiştir</button>
							<button class="dropdown-item" onclick="location.href='SourcePHP/logout.php'" type="button">Çıkış</button>
						</div>
					</div>
				</div>
			</nav>
		</header>

		<main role="main" class="mb-5">
			
