<?php
	session_start();
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";

	if(isset($_POST["style_select"]))
	{
		$_SESSION["style_select"] = $_POST["style_select"];
	}
	else
	{
		if (!$koolajax->isCallback)
		{
			//Page Init: show default style
			$_SESSION["style_select"] = "default";
		}
	}
		
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select customerNumber,customerName,phone,city from customers";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->DataSource = $ds;
	$grid->AjaxEnabled = true;
	$grid->AutoGenerateColumns = true;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "655px";
	
	$grid->styleFolder=$_SESSION["style_select"];
	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	Select style:
	<select id="style_select" name="style_select" onchange="submit();">
		<option value="default"		<?php if ($_SESSION["style_select"]=="default") echo "selected" ?> >Default</option>
		<option value="outlook"		<?php if ($_SESSION["style_select"]=="outlook") echo "selected" ?> >Outlook</option>		
	</select>
	
	<div style="padding-top:10px;">
		<?php echo $grid->Render();?>
	</div>
</form>
