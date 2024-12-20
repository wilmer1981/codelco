<?php
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select customerNumber,customerName,phone,city from customers";
	$ds->InsertCommand = "INSERT INTO customers (customerNumber,customerName,contactLastName,contactFirstName,phone,addressLine1,city,country) values (@customerNumber,'@customerName','','','@phone','','@city','');";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="default";
	$grid->DataSource = $ds;
	$grid->Width = "655px";
	$grid->AllowInserting = true;
	$grid->AllowSorting = true;

	$grid->AjaxEnabled = true;
	$grid->AutoGenerateColumns = true;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();

	//Show Function Panel
	$grid->MasterTable->ShowFunctionPanel = true;
	//Insert Settings
	$grid->MasterTable->InsertSettings->Mode = "Form";
	$grid->MasterTable->InsertSettings->ColumnNumber = 2;
	
	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
</form>
