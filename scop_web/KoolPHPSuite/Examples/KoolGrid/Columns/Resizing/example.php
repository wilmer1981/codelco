<?php
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
		
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select orderNumber,orderDate,status,comments from orders";
	$ds->UpdateCommand = "UPDATE orders set orderDate='@orderDate', status='@status' where orderNumber=@orderNumber";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="default";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "655px";
	$grid->AllowResizing = true;

	$column = new GridBoundColumn();
	$column->DataField = "orderNumber";
	$column->HeaderText = "Order Number";
	$column->ReadOnly = true;
	$column->Align = "center";
	$grid->MasterTable->AddColumn($column);

	$column = new GridDateTimeColumn();
	$column->DataField = "orderDate";
	$column->HeaderText = "Date";
	$column->FormatString = "M d, Y";
	$column->Align = "center";
	$grid->MasterTable->AddColumn($column);

	$column = new GridDropDownColumn();
	$column->DataField = "status";
	$column->HeaderText = "Status";
	$column->Align = "center";
	$column->AddItem("In Process");
	$column->AddItem("On Hold");
	$column->AddItem("Disputed");
	$column->AddItem("Resolved");	
	$column->AddItem("Shipped");
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "comments";
	$column->HeaderText = "Comments";
	$column->HeaderStyle->Align = "center";
	$column->Wrap = true;
	$grid->MasterTable->AddColumn($column);

	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>

	<div style="padding-top:10px;">
		<?php echo $grid->Render();?>
	</div>
</form>
