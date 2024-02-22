<?php
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select customerNumber,customerName,phone,city from customers";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="default";
	$grid->DataSource = $ds;
	$grid->Width = "655px";

	$grid->RowAlternative = true;

	$grid->AjaxEnabled = true;
	$grid->AutoGenerateColumns = true;

	//Pager settings
	$grid->MasterTable->Pager = new GridCustomPager();
	$grid->MasterTable->Pager->ShowPageSize = false;		

	function PagerRender($info)
	{
		$html = "My custom pager, select to change page: ";
		$html.="<select style='width:40px;' onchange='handle_pagechange(this)'>";
		for($i=0;$i<$info["TotalPages"];$i++)
		{
			$html.="<option value='".($i+1)."' ".(($i==$info["PageIndex"])?"selected":"").">".($i+1)."</option>";
		}
		$html.="</select>";
		return $html;
	}
	$grid->MasterTable->Pager->Render = PagerRender;

	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<script type="text/javascript">
		function handle_pagechange(_obj_select)
		{
			var page_index = _obj_select.options[_obj_select.selectedIndex].value;
			grid_gopage(_obj_select,page_index-1);
		}
	</script>
	<?php echo $grid->Render();?>
</form>
