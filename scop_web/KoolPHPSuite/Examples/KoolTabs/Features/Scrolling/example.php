<?php
	require $KoolControlsFolder."/KoolTabs/kooltabs.php";

	$kts = new KoolTabs("kts");
	$kts->styleFolder = "hay";
	$kts->addTab("root","home","Home",null,true);	
	$kts->addTab("root","products","Products");
	$kts->addTab("root","services","Services");
	$kts->addTab("root","company","Company");
	$kts->addTab("root","testimonial","Testimonial");
	$kts->addTab("root","customer","Customers");
	$kts->addTab("root","planning","Planning");


	
	$kts->addTab("root","contactus","Contact us");
	$kts->width = "500px";
	
	$sel = "right";
	if (isset($_POST["scrolling"]))
	{
		$sel = $_POST["scrolling"];
	}
	$kts->scroll = $sel;
?>

<form id="form1" method="post">

	Select scroll buttons position :
	<div style="border:dotted 1px gray;width:150px;height:70px;">
		<input type="radio" name="scrolling" id="rdleft" value="left" onclick="submit()" <? if($sel=="left") echo "checked"?> /> <label for="rdleft">Left</label><br />
		<input type="radio" name="scrolling" id="rdright" value="right" onclick="submit()" <? if($sel=="right") echo "checked"?> /> <label for="rdright">Right</label><br />
		<input type="radio" name="scrolling" id="rdmiddle" value="middle" onclick="submit()" <? if($sel=="middle") echo "checked"?> /> <label for="rdmiddle">Middle</label><br />		
	</div>
	
	<div style="padding:10px;">
		<?php echo $kts->Render();?>
	</div>
</form>
