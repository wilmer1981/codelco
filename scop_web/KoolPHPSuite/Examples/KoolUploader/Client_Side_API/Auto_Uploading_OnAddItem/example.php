<?php
	require $KoolControlsFolder."/KoolUploader/kooluploader.php";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";

	$kul = new KoolUploader("kul");
	$kul->scriptFolder = $KoolControlsFolder."/KoolUploader";
	$kul->handlePage = "handle.php";
	$kul->allowedExtension = "gif,jpg,txt,doc,pdf";
	$kul->styleFolder=$KoolControlsFolder."/KoolUploader/styles/default";
	$kul->progressTracking = true;
	$kul->maxFileSize = 512*1024; //500KB	
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<style type="text/css">
		.defaultKUL .kulUploadAll
		{
			display:none;
		}
		
	</style>
	<?php echo $kul->Render();?>
	<script type="text/javascript">
		kul.registerEvent("OnAddItem",function(sender,arg){
			var _item = kul.getItem(arg.ItemId);
			_item.upload();
		});
	</script>
	
	<div style="padding-top:20px;">
		<i>*Note:</i> Please test uploading with *.txt, *.doc, *.pdf, *.jpg, *.gif ( size &lt; 500KB )
	</div>	

</form>
