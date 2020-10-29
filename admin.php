<?php 
require_once 'SourcePHP/baglan.php';
require_once 'SourcePHP/start.php';
require_once 'header.php';

$yetkichar = array("Kullanıcı","Moderatör","Admin","Muhasebe");
?>


<?php
if($yetki == "2"){?>
	<!-- Change Email-Password Modal -->
	<div class="modal fade" id="changeEmailPass" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<nav>
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav-changePass-tab" data-toggle="tab" href="#nav-changePass" role="tab" aria-controls="nav-changePass" aria-selected="true">Parola Değiştir</a>
							<a class="nav-item nav-link" id="nav-changeEmail-tab" data-toggle="tab" href="#nav-changeEmail" role="tab" aria-controls="nav-changeEmail" aria-selected="false">Email Değiştir</a>
						</div>
					</nav>
				</div>
				<div class="modal-body">
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-changePass" role="tabpanel" aria-labelledby="nav-changePass-tab">
							<form action="SourcePHP/kullaniciS.php" method="POST">
								<div id="changePass_Uname"></div>
								<div class="form-group">
									<label for="Fkullanici_changeparolaYeni">Yeni Parola:</label>
									<input type="password" id="Fkullanici_changeparolaYeni" class="form-control" name="Fkullanici_changeparolaYeni">
								</div>
								<div class="form-group">
									<label for="Fkullanici_changeparolaTekrar">Yeni Parola(Tekrar):</label>
									<input type="password" id="Fkullanici_changeparolaTekrar" class="form-control" name="Fkullanici_changeparolaTekrar">
								</div>
								<div class="form-group">
									<button type="submit" class="btn" id="changePass" name="changePass">Değiştir</button>
								</div>
							</form>
						</div>
						<div class="tab-pane fade" id="nav-changeEmail" role="tabpanel" aria-labelledby="nav-changeEmail-tab">
							<form action="SourcePHP/kullaniciS.php" method="POST">
								<div id="changeEmail_Uname"></div>
								<div class="form-group">
									<label for="Fkullanici_changeEmailYeni">Yeni Email:</label>
									<input type="email" class="form-control" id="Fkullanici_changeEmailYeni" name="Fkullanici_changeEmailYeni">
								</div>
								<div class="form-group">
									<button type="submit" class="btn" id="changeEmail" name="changeEmail">Değiştir</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					 <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
				</div>
			</div>
		</div>
	</div>

	<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
		<li class="nav-item">
			<a class="nav-link" id="pills-kullanici-tab" data-toggle="pill" href="#pills-kullanici" role="tab" aria-controls="pills-kullanici" aria-selected="true">Kullanıcılar</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="pills-kullanici_ekle-tab" data-toggle="pill" href="#pills-kullanici_ekle" role="tab" aria-controls="pills-kullanici_ekle" aria-selected="false">Kullanıcı Ekle</a>
		</li>
	</ul>
	<div class="tab-content" id="pills-tabContent">
		<div class="tab-pane fade" id="pills-kullanici" role="tabpanel" aria-labelledby="pills-kullanici-tab">
			<table id="kullanici_table" class="table"> 
				<thead>
					<tr>
						<th>Ad Soyad</th>
						<th>Kullanıcı Adı</th>
						<th>E-mail</th>
						<th>Yetki</th>
						<th>Sil</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$kullanicisor=$db->prepare("SELECT * FROM kullanici order by kullanici_adi ASC");
					$kullanicisor->execute();
					while ($kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC)){ ?>
						<tr>
							<td><?php echo $kullanicicek['kullanici_isim']?></td>
							<td class="changeEmailPass"><?php echo $kullanicicek['kullanici_adi']?></td>
							<td><?php echo $kullanicicek['kullanici_email']?></td>
							<td><?php echo $yetkichar[$kullanicicek['kullanici_yetki']]?></td>
							<td class="silClm">
								<form action="SourcePHP/adminS.php" method="POST">
									<input type="hidden" value="<?php echo $kullanicicek['ID']?>" name="kullaniciDeleteID"></input>
								</form>
								<img src="Img/Remove.png" class="iconImg">
							</td>
						</tr>
					<?php } ?>
				</tbody>     
			</table>
		</div>
		<div class="tab-pane fade" id="pills-kullanici_ekle" role="tabpanel" aria-labelledby="pills-kullanici_ekle-tab">
			<form action="SourcePHP/adminS.php" method="POST">	
				<div class="form-group col-md-3 mx-auto">
					<label for="Fkullanici_adi">Kullanıcı Adı:</label>
					<input type="text" id="Fkullanici_adi" class="form-control" name="kullanici_adi">
					<small class="form-text text-danger">
						<?php 
						if ($_GET['durum']=="no") {
							echo $_SESSION["kullanici_adiErr"];
						}?>
					</small>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Fparola">Parola:</label>
					<input type="password" id="Fparola" class="form-control" name="parola">
					<small class="form-text text-danger">
						<?php 
						if ($_GET['durum']=="no") {
							echo $_SESSION["parolaErr"];
						}?>
					</small>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Fparolatekrar">Parola(Tekrar):</label>
					<input type="password" id="Fparolatekrar" class="form-control" name="parolatekrar">
					<small class="form-text text-danger">
						<?php 
						if ($_GET['durum']=="no") {
							echo $_SESSION["parolatekrarErr"];
						}?>
					</small>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Fisim">Ad Soyad:</label>
					<input type="text" id="Fisim" class="form-control" name="isim">
					<small class="form-text text-danger">
						<?php 
						if ($_GET['durum']=="no") {
							echo $_SESSION["isimErr"];
						}?>
					</small>				
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Femail">E-mail:</label>
					<input type="email" id="Femail" class="form-control" name="email">
					<small class="form-text text-danger">
						<?php 
						if ($_GET['durum']=="no") {
							echo $_SESSION["emailErr"];
						}?>
					</small>				
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Fyetki">Yetki:</label>
					<select id="Fyetki" class="form-control" name="yetki">
						<option value="2">Admin</option>
						<option value="1">Moderator</option>
						<option value="3">Muhasebe</option>
						<option value="0">Kullanıcı</option>
					</select>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<?php 
					if ($_GET['durum']=="ok") {
						echo "<strong class=\"form-text text-primary\">";
						echo $_SESSION["formValidateInfo"];
						echo "</strong>";
					}
					if ($_GET['durum']=="no") {
						echo "<strong class=\"form-text text-danger\">";
						echo $_SESSION["formValidateInfo"];
						echo "</strong>";
					}
					?>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<button class="btn" name="kullanici_ekle" type="submit">Ekle</button>
				</div>
			</form>		
		</div>
	</div>
<?php } ?>

<script type="text/javascript" src="Js/Fadmin.js"></script>

<?php require_once 'footer.php'; ?>