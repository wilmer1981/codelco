<?php
	require $KoolControlsFolder."/KoolTabs/kooltabs.php";

	$kts = new KoolTabs("kts");
	$kts->scriptFolder = $KoolControlsFolder."/KoolTabs";
	$kts->styleFolder="black";
		
	$kts->addTab("root","cadillac","Cadillac","javascript:showPage(\"cadillac_page\")",true);	
	$kts->addTab("root","porsche","Porsche","javascript:showPage(\"porsche_page\")");
	$kts->addTab("root","mercedes","Mercedes","javascript:showPage(\"mercedes_page\")");
	
	$position_select = "top";
	
	if(isset($_POST["position_select"]))
	{
		$position_select = $_POST["position_select"];
	}
	$kts->position = $position_select;
	
	if ($position_select=="left" || $position_select =="right")
	{
		$kts->width = "120px";	
	}

?>

<form id="form1" method="post">

<style type="text/css">
	.multipages
	{
		display:inline-block;
		vertical-align:top;
		<?php
		if($kts->position=="left")
		{
			echo "margin-left:-3px;";	
			echo "zoom:1;";
			echo "*display:inline;";
			
		}
		else if ($kts->position=="right")
		{
			echo "margin-right:-3px;";				
			echo "zoom:1;";
			echo "*display:inline;";
		}
		?>
	}
	
	*:first-child+html .multipages
	{
		margin-right:0px;
		margin-left:0px;
	}	
	
	.navi
	{
		display:inline-block;
		<?php
		if($kts->position=="left")
		{
			echo "zoom:1;";
			echo "*display:inline;";
		}
		else if ($kts->position=="right")
		{
			echo "zoom:1;";
			echo "*display:inline;";			
		}
		?>		
	}	
	
	#cadillac_page
	{
		width:480px;
		height:360px;
		background-image:url(Images/Cadillac.JPG);		
	}
	#porsche_page
	{
		width:480px;
		height:360px;
		background-image:url(Images/Porsche.JPG);		
	}
	#mercedes_page
	{
		width:480px;
		height:360px;
		background-image:url(Images/Mercedes.JPG);		
	}
	.bound
	{
		width:650px;
	}
	.multipages div
	{
		display:none;
	}

	#controlpanel
	{
		margin-bottom:20px;	
	}	
</style>
	
	
	<div id="controlpanel">
		Select tab position:
		<select id="position_select" name="position_select" onchange="submit();">
			<option value="top"			<?php if ($position_select=="top") echo "selected" ?> >Top Position</option>
			<option value="bottom"		<?php if ($position_select=="bottom") echo "selected" ?> >Bottom Position</option>
			<option value="left"		<?php if ($position_select=="left") echo "selected" ?> >Left Position</option>
			<option value="right"		<?php if ($position_select=="right") echo "selected" ?> >Right Position</option>
		</select>		
	</div>
	
	<div class="bound">
		
	<?php
	if($kts->position=="top" || $kts->position=="left")
	{
	?>
		<div class="navi">
			<?php echo $kts->Render();?>
		</div>
	<?php
	}
	?>
		<div class="multipages">
			<div id="cadillac_page" style="display:block"></div>
			<div id="porsche_page"></div>
			<div id="mercedes_page"></div>
		</div>
	
	<?php
	if($kts->position=="bottom" || $kts->position=="right")
	{
	?>
		<div class="navi">
			<?php echo $kts->Render();?>
		</div>
	<?php
	}
	?>
	<div style="clear:both;"></div>
	</div>

	<script type="text/javascript">
		function showPage(_id)
		{
			document.getElementById("cadillac_page").style.display="none";
			document.getElementById("porsche_page").style.display="none";
			document.getElementById("mercedes_page").style.display="none";
			
			document.getElementById(_id).style.display="block";
		}
	</script>
	
</form>
