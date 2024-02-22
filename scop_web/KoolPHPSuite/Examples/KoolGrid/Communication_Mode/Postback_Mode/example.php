<?php
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select customerNumber,customerName,phone,city from customers";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="default";
	$grid->DataSource = $ds;
	$grid->Width = "655px";
	$grid->RowAlternative = true;
	$grid->AutoGenerateColumns = true;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	
	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $grid->Render();?>
</form>
