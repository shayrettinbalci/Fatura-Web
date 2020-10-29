<?php 
require_once 'SourcePHP/baglan.php';
require_once 'SourcePHP/start.php';
require_once 'header.php';

$damgavergiArr = array('yok' => 'Yok' , 'odeyecek' => 'Müşteri Ödeyecek', 'odeyecegiz' => 'Biz Ödeyeceğiz');
$isinturuArr = array('sd'=>'Sözleşmeli Danışmanlık','sdd'=>'Sözleşme Dışı Danışmanlık','st'=>'Sözleşmeli Tasdik','sdt'=>'Sözleşme Dışı Tasdik(Özel Amaçlı - YMM)','kdv'=>'KDV İadesi','my'=>'Masraf Yansıtma');
$fatura_turuArr=array("fatura" => "E-Fatura", "arsiv" => "E-Arşiv");
?>


<ul class="nav nav-pills mb-3 ml-2" id="pills-tab" role="tablist">
	<li class="nav-item">
		<?php
		if($yetki == "2" || $yetki == "1" || $yetki == "3"){ ?>
			<a class="nav-link" id="pills-goruntuleme-tab" data-toggle="pill" href="#pills-goruntuleme" role="tab" aria-controls="pills-goruntuleme" aria-selected="true">Düzenlenen Faturalar</a>
		<?php } ?>
	</li>
	<li class="nav-item">
		<?php
		if($yetki == "2" || $yetki == "3"){ ?>
			<a class="nav-link" id="pills-onaylama-tab" data-toggle="pill" href="#pills-onaylama" role="tab" aria-controls="pills-onaylama" aria-selected="true">Düzenlenecek Faturalar</a>
		<?php } ?>
	</li>
</ul>

<?php
if($yetki == "2" || $yetki == "1" || $yetki == "3"){ ?>
	<div class="tab-content" id="pills-tabContent">
		<div class="tab-pane fade" id="pills-goruntuleme" role="tabpanel" aria-labelledby="pills-goruntuleme-tab">
			<form>
				<div class="form-row ml-2">
					<div class="form-group col-md-2">
						<label for="minTutar">Tutar(min.):</label>
						<input type="text" id="minTutar" class="form-control filter" name="minTutar">
					</div>
					<div class="form-group col-md-2">
						<label for="maxTutar">Tutar(max.)</label>
						<input type="text" id="maxTutar" class="form-control filter" name="maxTutar">
					</div>
				</div>
				<div class="form-row ml-2">
					<div class="form-group col-md-2">
						<label for="baslangicTarih">Başlangıç Tarih:</label>
						<input type="date" id="baslangicTarih" class="form-control filter" name="baslangicTarih">
					</div>
					<div class="form-group col-md-2">
						<label for="bitisTarih">Bitiş Tarih:</label>
						<input type="date" id="bitisTarih" class="form-control filter" name="bitisTarih">
					</div>
					<div class="form-group col-md-1 mt-auto">
						<button type="button" id="araTarihTutar" class="btn btn-primary form-control filter" name="araTarihTutar">Ara</button>
					</div>
				</div>
			</form>
			<table id="goruntuleme_table" class="table table-sm table-hover">
				<thead>
					<tr>
						<th>Hazırlayan</th>
						<th>Müşteri</th>
						<th>Partner</th>
						<th>Manager</th>
						<th>Fatura Numarası</th>
						<th>Ay</th>
						<th>Giriş Tarihi</th>
						<th>Tutar</th>
						<th>Vergi Yüzdesi</th>
						<th>Damga Vergisi</th>
						<th>İş Türü</th>
						<th>Fatura Türü</th>
						<th>Ek Açıklama</th>
						<th>PDF İndir</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$faturasor=$db->prepare("SELECT * FROM fatura WHERE onay_durumu=1 order by giris_tarih DESC");
					$faturasor->execute();
					while ($faturacek=$faturasor->fetch(PDO::FETCH_ASSOC)){ ?>
						<tr>
							<td><?php echo $faturacek['kullanici_isim']?></td>
							<td><?php echo $faturacek['musteri']?></td>
							<td><?php echo $faturacek['partner']?></td>
							<td><?php echo $faturacek['manager']?></td>
							<td><?php echo $faturacek['fatura_no']?></td>
							<td><?php echo $faturacek['fatura_tarihi']?></td>
							<td>
								<?php 
								$date = new DateTime($faturacek['giris_tarih']);
								$shortdate = $date->format('d/m/Y');
								echo $shortdate;
								?>
							</td>
							<td>
								<?php 
								echo number_format($faturacek['tutar'],2,",",".");
								echo " ";
								echo $faturacek['birim'];
								?>	
							</td>
							<td>
								<?php 
								$yuzde = $faturacek['vergi_yuzde'];
								echo "$yuzde%";
								?>
							</td>
							<td><?php echo $damgavergiArr[$faturacek['damga_vergisi']]?></td>
							<td><?php echo $isinturuArr[$faturacek['isin_turu']]?></td>
							<td><?php echo $fatura_turuArr[$faturacek['fatura_turu']]?></td>
							<td class="aciklamaClm"><?php echo $faturacek['aciklama']?></td>
							<td>
								<form action="SourcePHP/pdfDownload.php" method="post" enctype="multipart/form-data">
									<input type="hidden" value="<?php echo $faturacek['faturaID']?>" name="faturaID">
									<input type="hidden" value="<?php echo $faturacek['kullanici_Fadi']?>" name="kullanici_Fadi">
									<button type="submit" name="submit">
										<img src="Img/pdf-icon.png" class="iconImg">
									</button>
								</form>
							</td>
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th class="search"></th>
						<th></th>
						<th></th>
					</tr>
				</tfoot>
			</table>
		</div>
	<?php } ?>
	<?php
	if($yetki == "2" || $yetki == "3"){?>
		<div class="tab-pane fade" id="pills-onaylama" role="tabpanel" aria-labelledby="pills-onaylama-tab">
			<table id="onay_table" class="table table-sm table-hover">
				<thead>
					<tr>
						<th>Hazırlayan</th>
						<th>Müşteri</th>
						<th>Partner</th>
						<th>Manager</th>
						<th>Fatura Numarası</th>
						<th>Ay</th>
						<th>Giriş Tarihi</th>
						<th>Tutar</th>
						<th>Vergi Yüzdesi</th>
						<th>Damga vergisi</th>
						<th>İş Türü</th>
						<th>Fatura Türü</th>
						<th>Ek Açıklama</th>
						<th>İptal Talebi</th>
						<th>Pdf Ekle</th>
						<th>Onay</th>
						<th>Sil</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$faturasor=$db->prepare("SELECT * FROM fatura WHERE onay_durumu=0 order by giris_tarih DESC");
					$faturasor->execute();
					while ($faturacek=$faturasor->fetch(PDO::FETCH_ASSOC)){ ?>
						<tr>
							<td><?php echo $faturacek['kullanici_isim']?></td>
							<td><?php echo $faturacek['musteri']?></td>
							<td><?php echo $faturacek['partner']?></td>
							<td><?php echo $faturacek['manager']?></td>
							<td class="faturaNo_input"><input type="text" class="form-control" name="faturaNo"></td>
							<td><?php echo $faturacek['fatura_tarihi']?></td>
							<td>
								<?php 
								$date = new DateTime($faturacek['giris_tarih']);
								$shortdate = $date->format('d/m/Y');
								echo $shortdate;
								?>
							</td>
							<td>
								<?php 
								echo number_format($faturacek['tutar'],2,",",".");
								echo " ";
								echo $faturacek['birim'];
								?>		
							</td>
							<td>
								<?php 
								$yuzde = $faturacek['vergi_yuzde'];
								echo "$yuzde%";
								?>
							</td>
							<td><?php echo $damgavergiArr[$faturacek['damga_vergisi']]?></td>
							<td><?php echo $isinturuArr[$faturacek['isin_turu']]?></td>
							<td><?php echo $fatura_turuArr[$faturacek['fatura_turu']]?></td>
							<td class="aciklamaClm"><?php echo $faturacek['aciklama']?></td> 
							<td><?php echo $faturacek['istek_iptal']?></td>
							<td>
								<form action="SourcePHP/pdfUpload.php" method="post" enctype="multipart/form-data">
									<div class="upload-btn-wrapper">
										<button class="buton">PDF</button>
										<input type="file" name="fileToUpload">
									</div>
									<input type="hidden" value="<?php echo $faturacek['faturaID']?>" name="faturaEkleID">
									<input type="hidden" value="<?php echo $faturacek['kullanici_Fadi']?>" name="kullanici_Fadi2">
								</form>
							</td>
							<td class="FonayClm">
								<form action="SourcePHP/faturaS.php" method="post">
									<input type="hidden" class="onayID" value="<?php echo $faturacek['faturaID']?>" name="faturaOnay_id"></input>
									<input type="hidden" class="kullaniciAdi" value="<?php echo $faturacek['kullanici_Fadi']?>" name="faturaOnay_name"></input>
								</form>
								<img src="Img/Icon-check.png" class="iconImg">
							</td>
							<td class="FsilClm">
								<form action="SourcePHP/faturaS.php" method="post">
									<input type="hidden" value="<?php echo $faturacek['faturaID']?>" name="faturaDelete_id"></input>
								</form>
								<img src="Img/Remove.png" class="iconImg">
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
	</div>
</div>
<script type="text/javascript" src="Js/Fgoruntuleme.js"></script>
<?php require_once 'footer.php'; ?>
