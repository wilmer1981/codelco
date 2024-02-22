<?php
	require $KoolControlsFolder."/KoolUploader/kooluploader.php";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";

	$kul = new KoolUploader("kul");
	$kul->scriptFolder = $KoolControlsFolder."/KoolUploader";
	$kul->styleFolder=$KoolControlsFolder."/KoolUploader/styles/default";
	$kul->handlePage = "handle.php";
	$kul->allowedExtension = "txt,jpg,gif,doc,pdf";
	$kul->maxFileSize = 512*1024; //500KB
	$kul->progressTracking = true;
	
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<style type="text/css">
		.defaultKUL .kulClearAll
		{
			display:none;
		}
		.defaultKUL .kulUploadAll
		{
			display:none;
		}		
	</style>
	
	<div style="padding:10px;">
		<?php echo $kul->Render();?>
	</div>
</form>
