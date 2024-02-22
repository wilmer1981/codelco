<?php
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	
	
	//Generate array
	$arr = array();
	for($i=0;$i<10;$i++)
	{
		$arr[] = array("ID"=>$i,"Text"=>"Text ".$i);
	}
	
	$ds = new ArrayDataSource($arr);
	
	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="default";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->Width = "655px";
	$grid->ShowStatus = false;
	$grid->PageSize = 5;
	
	
	$grid->MasterTable->Pager = new GridPrevNextPager();
	

	$column = new GridBoundColumn();
	$column->DataField = "ID";
	$column->HeaderText = "ID";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "Text";
	$column->HeaderText = "Text";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
</form>
