<?php
	require $KoolControlsFolder."/KoolUploader/kooluploader.php";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";

	$kul = new KoolUploader("kul");
	$kul->scriptFolder = $KoolControlsFolder."/KoolUploader";
	$kul->handlePage = "handle.php";
	$kul->styleFolder=$KoolControlsFolder."/KoolUploader/styles/default";
	$kul->maxFileSize = 512*1024; //500KB
	$kul->progressTracking = true;
			
	$kul->allowedExtension = "txt,jpg,gif,doc,pdf";

?>

<form id="form1" method="post">	
	<?php echo $koolajax->Render();?>

	<?php echo $kul->Render();?>
	<div style="padding-top:20px;">
		<i>*Note:</i> Please test uploading with *.txt, *.doc, *.pdf, *.jpg, *.gif ( size &lt; 500KB )
	</div>	

</form>
