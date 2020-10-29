<?php 
require_once 'SourcePHP/baglan.php';
require_once 'SourcePHP/start.php';
require_once 'header.php';


$damgavergiArr = array('yok' => 'Yok' , 'odeyecek' => 'Müşteri Ödeyecek', 'odeyecegiz' => 'Biz Ödeyeceğiz'); 
$isinturuArr = array('sd'=>'Sözleşmeli Danışmanlık','sdd'=>'Sözleşme Dışı Danışmanlık','st'=>'Sözleşmeli Tasdik','sdt'=>'Sözleşme Dışı Tasdik(Özel Amaçlı - YMM)','kdv'=>'KDV İadesi','my'=>'Masraf Yansıtma');
$fatura_turuArr=array("fatura" => "E-Fatura", "arsiv" => "E-Arşiv");
?>



<ul class="nav nav-pills ml-2 mb-3" id="pills-tab" role="tablist">
	<li class="nav-item">
		<a class="nav-link" id="pills-fatura_giris-tab" data-toggle="pill" href="#pills-fatura_giris" role="tab" aria-controls="pills-fatura_giris" aria-selected="false">Fatura Giriş</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="pills-PDF-tab" data-toggle="pill" href="#pills-PDF" role="tab" aria-controls="pills-PDF" aria-selected="false">Kesilen Faturalar</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="pills-onaylanmayan-tab" data-toggle="pill" href="#pills-onaylanmayan" role="tab" aria-controls="pills-PDF" aria-selected="false">Fatura Talimatları</a>
	</li>
</ul>

<div class="tab-content" id="pills-tabContent">
	<div class="tab-pane fade" id="pills-fatura_giris" role="tabpanel" aria-labelledby="pills-fatura_giris-tab"> 
			<form action="SourcePHP/faturaS.php" method="POST">		
				<div class="form-group col-md-3 mx-auto">
					<div>
						<input type="hidden" id="Fhazirlayan" value="<?php echo $kullanicicek['kullanici_isim']?>" name="kullanici_isim">
					</div>
					<div>
						<input type="hidden" id="FhazirlayanAdi" value="<?php echo $kullanicicek['kullanici_adi']?>" name="kullanici_Fadi">
					</div>
					<div class="ui-widget">
					<label for="Fmusteri">Müşteri:</label>
					<input type="text" id="Fmusteri" class="form-control" name="musteri" autocomplete="off">
					<small class="form-text text-danger">
						<?php 
						if ($_GET['durum']=="no") {
							echo $_SESSION["musteriErr"];
						}?>
					</small>
				</div>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Fpartner">Partner:</label>		
					<input type="text" id="Fpartner" class="form-control" name="partner">
					<small class="form-text text-danger">
						<?php 
						if ($_GET['durum']=="no") {
							echo $_SESSION["partnerErr"];
						}?>
					</small>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Fmanager">Manager:</label>
					<input type="text" id="Fmanager" class="form-control" name="manager">
					<small class="form-text text-danger">
						<?php 
						if ($_GET['durum']=="no") {
							echo $_SESSION["managerErr"];
						}?>
					</small>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Fay">Ay:</label>
					<select id="Fay" class="form-control" name="ay">
						<option value="Ocak">Ocak</option>
						<option value="Şubat">Şubat</option>
						<option value="Mart">Mart</option>
						<option value="Nisan">Nisan</option>
						<option value="Mayıs">Mayıs</option>
						<option value="Haziran">Haziran</option>
						<option value="Temmuz">Temmuz</option>
						<option value="Ağustos">Ağustos</option>
						<option value="Eylül">Eylül</option>
						<option value="Ekim">Ekim</option>
						<option value="Kasım">Kasım</option>
						<option value="Aralık">Aralık</option>
					</select>
				</div>
				<div class="row justify-content-md-center">
					<div class="form-group col-md-1">
						<label for="Ftutar">Tutar:</label>
						<input type="text" class="form-control" id="Ftutar" name="tutar">
						<small class="form-text text-danger">
							<?php 
							if ($_GET['durum']=="no") {
								echo $_SESSION["tutarErr"];
							}?>
						</small>
					</div>
					<div class="form-group col-md-1">
						<label for="Fbirim">Birim:</label>
						<select class="form-control" id="Fbirim" name="birim">
							<option value="₺">₺</option>
							<option value="$">$</option>
							<option value="€">€</option>
						</select>
					</div>
					<div class="form-group col-md-1">
						<label for="Fvergi_yuzde">Yüzde:</label>
						<select class="form-control" id="Fvergi_yuzde" name="vergi_yuzde">
							<option value="18">%18</option>
							<option value="8">%8</option>
							<option value="1">%1</option>
							<option value="0">%0</option>
						</select>
					</div>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Fisin_turu">İşin Türü:</label>
					<select id="Fisin_turu" class="form-control" name="isin_turu">
						<option value="sd">Sözleşmeli Danışmanlık</option>
						<option value="sdd">Sözleşme Dışı Danışmanlık</option>
						<option value="st">Sözleşmeli Tasdik</option>
						<option value="sdt">Sözleşme Dışı Tasdik(Özel Amaçlı - YMM)</option>
						<option value="kdv">KDV İadesi</option>
						<option value="my">Masraf Yansıtma</option>
					</select>
				</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Fdamga_vergisi">Damga Vergisi:</label>
					<select id="Fdamga_vergisi" class="form-control" name="damga_vergisi">
						<option value="yok">Yok</option>
						<option value="odeyecek">Müşteri ödeyecek</option>
						<option value="odeyecegiz">Biz ödeyeceğiz</option>
					</select> 
				</div>
				<div class="form-group col-md-3 mx-auto">
				<label for="fatura_Eturu">Fatura Türü</label>
				<select id="fatura_Eturu" class="form-control" name="fatura_turu">
					<option value="fatura">E-Fatura</option>
					<option value="arsiv">E-Arşiv</option>
				</select> 
			</div>
				<div class="form-group col-md-3 mx-auto">
					<label for="Faciklama">Açıklama:</label>
					<textarea cols="49" maxlength="1000" id="Faciklama" class="form-control" name="aciklama" placeholder="İsteğe Bağlı"></textarea>
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
					<button class="btn" name="fatura_kaydet" type="submit">Fatura Ekle</button>
				</div>
			</form>	
	</div>
	<div class="tab-pane fade" id="pills-PDF" role="tabpanel" aria-labelledby="pills-PDF-tab"> 
		<table id="PDF_table" class="table table-sm table-hover">
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
					<th>İptal Talebi</th>
					<th>Pdf indir</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$isim=$kullanicicek['kullanici_isim'];
				$faturasor=$db->prepare("SELECT * FROM fatura where kullanici_isim=:isim AND onay_durumu=1 order by giris_tarih DESC");
				$faturasor->execute(array(
					'isim' => $isim
				));
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
						<td class="iptalClm1">
							<form action="SourcePHP/faturaS.php" method="POST">
									<input type="hidden" class="Iptal_faturaID" value="<?php echo $faturacek['faturaID']?>" name="iptalFaturaID"></input>
									<input type="hidden" class="Iptal_kullaniciAdi" value="<?php echo $faturacek['kullanici_Fadi']?>" name="iptalFatura_name"></input>
							</form>İptal Talebi Gönder
						</td>
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
				<?php }?>
			</tbody>
		</table>	
	</div>
	<div class="tab-pane fade" id="pills-onaylanmayan" role="tabpanel" aria-labelledby="pills-onaylanmayan-tab"> 
		<table id="onaylanmayan_table" class="table table-sm table-hover">
			<thead>
				<tr>
					<th>Hazırlayan</th>
					<th>Müşteri</th>
					<th>Partner</th>
					<th>Manager</th>
					<th>Ay</th>
					<th>Giriş Tarihi</th>
					<th>Tutar</th>
					<th>Vergi Yüzdesi</th>
					<th>Damga Vergisi</th>
					<th>İş Türü</th>
					<th>Fatura Türü</th>
					<th>Ek Açıklama</th>
					<th>İptal Talebi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$isim=$kullanicicek['kullanici_isim'];
				$faturasor=$db->prepare("SELECT * FROM fatura where kullanici_isim=:isim AND onay_durumu=0 order by giris_tarih DESC");
				$faturasor->execute(array(
					'isim' => $isim
				));
				while ($faturacek=$faturasor->fetch(PDO::FETCH_ASSOC)){ ?>				
					<tr>
						<td><?php echo $faturacek['kullanici_isim']?></td>
						<td><?php echo $faturacek['musteri']?></td>
						<td><?php echo $faturacek['partner']?></td>
						<td><?php echo $faturacek['manager']?></td>
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
						<td class="iptalClm2">
							<form action="SourcePHP/faturaS.php" method="POST">
									<input type="hidden" class="Iptal_faturaID" value="<?php echo $faturacek['faturaID']?>" name="iptalFaturaID"></input>
									<input type="hidden" class="Iptal_kullaniciAdi" value="<?php echo $faturacek['kullanici_Fadi']?>" name="iptalFatura_name"></input>
							</form>İptal Talebi Gönder
						</td>
					</tr>
				<?php }?>
			</tbody>
		</table>	
	</div>
</div>

<script type="text/javascript" src="Js/Fgirme.js"></script>
<?php 
$musterisor=$db->prepare("SELECT * FROM musteri");
$musterisor->execute();
while ($mustericek=$musterisor->fetch(PDO::FETCH_ASSOC)){ 

	$musteriler[]=$mustericek["musteri_ad"];
}
	echo "<script>";
	echo 'var values = '.json_encode($musteriler).';';
	echo "$( '#Fmusteri' ).autocomplete({source: values});";
	echo "</script>";

require_once 'footer.php'; 

?>
