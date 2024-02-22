<?php
	require $KoolControlsFolder."/KoolSlideMenu/koolslidemenu.php";
			
	$xmlDoc = new DOMDocument();
	$xmlDoc->load("SlideMenu.xml");
	
	$ksm = new KoolSlideMenu("ksm");
	$ksm->loadXML($xmlDoc->saveXML());
	
?>
<div style="height:200px;width:650px;padding-left:10px;">
	<?php echo $ksm->Render();?>
</div>
