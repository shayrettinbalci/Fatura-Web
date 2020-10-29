<?php 
if($_SESSION["generalInformationModalContent"]!=NULL){
	$content=$_SESSION["generalInformationModalContent"];
	echo "<script type=\"text/javascript\">$(document).ready(function(){"
	."$('#generalModal').find('.modal-header').html('<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Kapat\"><span aria-hidden=\"true\">&times;</span></button>');"
	."$('#generalModal').find('.modal-body').html('$content');"
	."$('#generalModal').find('.modal-footer').html('<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Kapat</button>');"
	."$('#generalModal').modal('show');"
	."});</script>";
	$_SESSION["generalInformationModalContent"]="";
}

?>

</main>
<footer class="mastfoot mt-auto fixed-bottom bg-light">
	<div class="col-md-12 text-center">
		<!-- <div><a target="_blank" href="#">Acil Yardım</a> </div> -->
		<div> Copyright &copy; <?php echo date('Y') ?></div>
	</div>
</footer>
</div>

</body>
</html>