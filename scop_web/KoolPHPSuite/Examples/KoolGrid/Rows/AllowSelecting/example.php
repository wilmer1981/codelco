<?php
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select customerNumber,customerName,phone,city from customers";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="default";
	$grid->MasterTable->DataSource = $ds;
	$grid->MasterTable->DataKeyNames = "customerNumber"; // Need to set to get selection.
	$grid->Width = "655px";

	$grid->AllowSelecting = true;// Allow row selecting

	$grid->AjaxEnabled = true;
	$grid->AutoGenerateColumns = true;
		
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	
	$grid->Process();
	
	//Get selected keys after grid processing
	$selected_keys = $grid->GetInstanceMasterTable()->SelectedKeys;
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
	
	<div style="padding-top:10px;">
		<input type="submit" value = "Submit" />
	</div>
	<div style="padding-top:10px;">
		<?php
			if (sizeof($selected_keys)>0)
			{
				echo "You select row with <b>customerNumber = ".$selected_keys[0]["customerNumber"]."</b>";
			}
		?>
	</div>	
</form>
