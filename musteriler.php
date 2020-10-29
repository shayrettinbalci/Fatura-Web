<?php 
require_once 'SourcePHP/baglan.php';
require_once 'SourcePHP/start.php';
require_once 'header.php';

$musteri_turuArr=array("fatura" => "E-Fatura", "arsiv" => "E-Arşiv");

?>

<ul class="nav nav-pills ml-2 mb-3" id="pills-tab" role="tablist">
	<li class="nav-item">
		<?php
		if($yetki == "2" || $yetki == "1"){ ?>
			<a class="nav-link" id="pills-musteriler-tab" data-toggle="pill" href="#pills-musteriler" role="tab" aria-controls="pills-musteriler" aria-selected="false">Müşteriler</a>
		<?php } ?>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="pills-musteri_giris-tab" data-toggle="pill" href="#pills-musteri_giris" role="tab" aria-controls="pills-musteri_giris" aria-selected="true">Müşteri Ekle</a>
	</li>
</ul>

<div class="tab-content" id="pills-tabContent">
	<?php
	if($yetki == "2" || $yetki == "1"){ ?>
		<div class="tab-pane fade" id="pills-musteriler" role="tabpanel" aria-labelledby="pills-musteriler-tab">
			<table id="musteri_table" class="table table-sm table-hover">
				<thead>
					<tr>
						<th>Müşteri Adı</th>
						<th>Müşteri Adresi</th>
						<th>Müşteri Vergi No</th>
						<th>Fatura Türü</th>
						<?php if($yetki == "2"){?>
						<th>Sil</th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php 
					$musterisor=$db->prepare("SELECT * FROM musteri");
					$musterisor->execute();
					while ($mustericek=$musterisor->fetch(PDO::FETCH_ASSOC)){ ?>				
						<tr>
							<td><?php echo $mustericek['musteri_ad']?></td>
							<td><?php echo $mustericek['musteri_adres']?></td>
							<td><?php echo $mustericek['musteri_vergino']?></td>
							<td><?php echo $musteri_turuArr[$mustericek['musteri_turu']]?></td>
							<?php if($yetki == "2"){?>
							<td class="silClm">
								<form action="SourcePHP/faturaS.php" method="POST">
									<input type="hidden" value="<?php echo $mustericek['musteri_ID']?>" name="musteriDeleteID"></input>
								</form>
								<img src="Img/Remove.png" class="iconImg">
							</td>
						<?php }?>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	<?php } ?>
	<div class="tab-pane fade" id="pills-musteri_giris" role="tabpanel" aria-labelledby="pills-musteri_giris-tab">
		<form action="SourcePHP/faturaS.php" method="POST">		
			<div class="form-group col-md-3 mx-auto">
				<label for="musteri_adi">Müşteri Adı:</label>
				<input type="text" id="musteri_adi" class="form-control" name="musteri_adi">
				<small class="form-text text-danger">
					<?php 
					if ($_GET['durum']=="no") {
						echo $_SESSION["musteri_adiErr"];
					}?>
				</small>
			</div>
			<div class="form-group col-md-3 mx-auto">
				<label for="musteri_adresi">Müşteri Adresi:</label>
				<input type="text" id="musteri_adresi" class="form-control" name="musteri_adresi">
				<small class="form-text text-danger">
					<?php 
					if ($_GET['durum']=="no") {
						echo $_SESSION["musteri_adresiErr"];
					}?>
				</small>
			</div>
			<div class="form-group col-md-3 mx-auto">
				<label for="musteri_vergiNumarasi">Müşteri Vergi Numarası:</label>
				<input type="text" id="musteri_vergiNumarasi" class="form-control" name="musteri_vergiNumarasi">
				<small class="form-text text-danger">
					<?php 
					if ($_GET['durum']=="no") {
						echo $_SESSION["musteri_vergiNumarasiErr"];
					}?>
				</small>
			</div>
			<div class="form-group col-md-3 mx-auto">
				<label for="musteri_Eturu">Fatura Türü</label>
				<select id="musteri_Eturu" class="form-control" name="musteri_turu">
					<option value="fatura">E-Fatura</option>
					<option value="arsiv">E-Arşiv</option>
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
				<button class="btn" name="musteri_kaydet" type="submit">Müşteri Ekle</button>
			</div>
		</form>
	</div>
</div>


<script type="text/javascript" src="Js/Fmusteri.js"></script>

<?php require_once 'footer.php'; ?>
