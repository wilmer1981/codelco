<?php
	require $KoolControlsFolder."/KoolComboBox/koolcombobox.php";

	$kcb = new KoolComboBox("kcb");
	$kcb->scriptFolder = $KoolControlsFolder."/KoolComboBox";
	$kcb->styleFolder= "inox";
	$kcb->width = "180px";
	$kcb->itemTemplate = "<table><tr><td valign='middle' style='width:22px;height:20px;'><img src='../../Resources/Flags/{image}' alt='{text}' title='{text}' /></td><td valign='middle'>{text}</td></tr></table>";
	
	$kcb->addItem("Canada","Canada",array("image"=>"flag_canada.png"),true);
	$kcb->addItem("Finland","Finland",array("image"=>"flag_finland.png"));
	$kcb->addItem("France","France",array("image"=>"flag_france.png"));
	$kcb->addItem("Germany","Germany",array("image"=>"flag_germany.png"));
	$kcb->addItem("Great Britain","Great Britain",array("image"=>"flag_great_britain.png"));
	$kcb->addItem("USA","USA",array("image"=>"flag_usa.png"));	

?>

<form id="form1" method="post">
	<div style="padding-left:10px;">	
		Choose a nation:
	</div>	
	<div style="padding:10px;">	
	<?php echo $kcb->Render();?>
	</div>	
</form>