<?php
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
		
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select orderNumber,orderDate,status,comments from orders";
	$ds->UpdateCommand = "UPDATE orders set orderDate='@orderDate', status='@status', comments='@comments' where orderNumber=@orderNumber";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="default";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "655px";
	$grid->ColumnWrap = true;
	$grid->AllowEditing = true;

	$column = new GridBoundColumn();
	$column->DataField = "orderNumber";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridDateTimeColumn();
	$column->DataField = "orderDate";
	$column->HeaderText = "Date";
	$column->FormatString = "M d, Y";
	$grid->MasterTable->AddColumn($column);

	$column = new GridDropDownColumn();
	$column->DataField = "status";
	$column->HeaderText = "Status";
	$column->AddItem("In Process");
	$column->AddItem("On Hold");
	$column->AddItem("Disputed");
	$column->AddItem("Cancelled");	
	$column->AddItem("Resolved");	
	$column->AddItem("Shipped");
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "comments";
	$column->HeaderText = "Comments";
	$column->Width = "200px";
	$grid->MasterTable->AddColumn($column);

	$column = new GridEditDeleteColumn();
	$column->ShowDeleteButton = false;
	$column->Align = "center";
	$grid->MasterTable->AddColumn($column);
	
	//Set edit mode to "form"
	$grid->MasterTable->EditSettings->Mode = "form";
	
	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
</form>
