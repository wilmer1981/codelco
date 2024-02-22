<?php
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select customerNumber,customerName,phone,addressLine1, city, country from customers";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="default";
	$grid->DataSource = $ds;
	$grid->AjaxEnabled = true;

	$grid->AllowResizing = true;
	$grid->Width = "655px";
	$grid->PageSize = 20;
	$grid->RowAlternative = true;
	$grid->AllowScrolling = true;
	$grid->Height = "300px";
	$grid->MasterTable->ColumnWidth = "200px";

	$grid->AutoGenerateColumns = true;
		
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();	
	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
</form>
