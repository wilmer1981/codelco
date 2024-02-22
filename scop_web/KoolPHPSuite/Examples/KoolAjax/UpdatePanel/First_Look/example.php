<?php
    require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";
	if ($koolajax->isCallback)
	{
		//If it is callback request, Slow down processing to see loading effect
		sleep(1);
	}
	
	$country1_value = $_POST["country1"];
	$country2_value = $_POST["country2"];
?>

<div>
	<?php echo $koolajax->Render();?>
	<style type="text/css">
		.box
		{
			float:left;
			background:#EEEEEE;
			border:solid 1px #CCCCCC;
			width:280px;
			height:180px;
			margin:10px;
			padding:10px;
		}
		.UPDATEpanel
		{
			background:#DFF3FF;
			border:solid 1px #C6E1F2;			
		}
		.clear
		{
			clear:both;
		}
		.countryselect
		{
			width:130px;
		}
		.notification
		{
			font-style:italic;
			padding-top:10px;
		}
	</style>

	<div class="box">
		<form id='form1' method="post">
			<b>No UpdatePanel</b>
			<hr/>
			Country:
			<select name="country1" class="countryselect">
				<option value="Canada">Canada</option>
				<option value="France">France</option>
				<option value="Great Britain">Great Britain</option>
				<option value="Germany">Germany</option>
				<option value="USA">USA</option>
			</select>
			<input type="submit" value="Submit"/>
			<div class="notification">
				<?php
					if($country1_value!=null)
					{
						echo "You selected <b>$country1_value</b>";
					}
				?>
			</div>
		</form>
	</div>
	
	<?php echo KoolScripting::Start();?>
		<UPDATEpanel id="country_UPDATEpanel" class="box UPDATEpanel">
			<content>
				<![CDATA[ 
				<b>UpdatePanel</b>
				<hr/>
				Country:
				<select name="country2" class="countryselect">
					<option value="Canada">Canada</option>
					<option value="France">France</option>
					<option value="Great Britain">Great Britain</option>
					<option value="Germany">Germany</option>
					<option value="USA">USA</option>
				</select>
				<input type="submit" value="Submit"/>
				<div class="notification">
					<?php
						if($country2_value!=null)
						{
							echo "You selected <b>$country2_value</b>";
						}
					?>
				</div>					
			 	]]>					
			</content>
			<loading image="<?php echo $KoolControlsFolder;?>/KoolAjax/loading/5.gif" />
		</UPDATEpanel>
	<?php echo KoolScripting::End();?>
	<div class="clear"></div>
</div>
