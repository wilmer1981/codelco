<?php
	require $KoolControlsFolder."/KoolTabs/kooltabs.php";

	$kts = new KoolTabs("kts");
	$kts->styleFolder = "hay";
	$kts->addTab("root","home","Home",null,true);	
	$kts->addTab("root","products","Products");
	$kts->addTab("root","services","Services");
	$kts->addTab("root","company","Company");
	$kts->addTab("root","contactus","Contact us");	
	$kts->width = "650px";
	
	$sel = "left";
	if (isset($_POST["alignmentSelect"]))
	{
		$sel = $_POST["alignmentSelect"];
	}
	$kts->align = $sel;
?>

<form id="form1" method="post">

	Select tab alignment:
	<div style="border:dotted 1px gray;width:150px;height:100px;">
		<input type="radio" name="alignmentSelect" id="left" value="left" onclick="submit()" <? if($sel=="left") echo "checked"?> /> <label for="left">Left</label><br />
		<input type="radio" name="alignmentSelect" id="right" value="right" onclick="submit()" <? if($sel=="right") echo "checked"?> /> <label for="right">Right</label><br />
		<input type="radio" name="alignmentSelect" id="center" value="center" onclick="submit()" <? if($sel=="center") echo "checked"?> /> <label for="center">Center</label><br />		
		<input type="radio" name="alignmentSelect" id="justify" value="justify" onclick="submit()" <? if($sel=="justify") echo "checked"?> /> <label for="justify">Jusitfy</label>		
	</div>
	
	<div style="padding:10px;">
		<?php echo $kts->Render();?>
		<div style="width:650px;height:20px;background-color:#F3F3E2"></div>
	</div>
	
</form>
