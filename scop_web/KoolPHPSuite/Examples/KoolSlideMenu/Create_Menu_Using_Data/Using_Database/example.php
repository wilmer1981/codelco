<?php
	require $KoolControlsFolder."/KoolSlideMenu/koolslidemenu.php";	
	$ksm = new KoolSlideMenu("ksm");
	$ksm->scriptFolder =  $KoolControlsFolder."/KoolSlideMenu";	
	$ksm->styleFolder = $KoolControlsFolder."KoolSlideMenu/styles/bluearrow";
	$ksm->width="200px";
	$ksm->singleExpand = true;
	$ksm->boxHeight = 140;
	$result = mysql_query("select ID,ParentID,IsChild,Text from tb_slidemenu");
	while($row = mysql_fetch_assoc($result))
	{
		if($row['IsChild']==0)
		{
			$ksm->addParent($row['ParentID'], $row['ID'], $row['Text']);			
		}
		else
		{
			$ksm->addChild($row['ParentID'], $row['ID'], $row['Text']);
		}
	}	
?>
<form id="form1" method="post">
	<div style="padding-left:10px;">
		<?php echo $ksm->Render();?>
	</div>
</form>
