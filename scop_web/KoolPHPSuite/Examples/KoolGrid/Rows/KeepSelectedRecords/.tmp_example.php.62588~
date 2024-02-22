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

	$grid->AllowMultiSelecting = true;// Allow multi row selecting
	$grid->KeepSelectedRecords = true;//Keep selected records cross page.
	
	
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
				echo "You selected rows with <b>customerNumber = [ ";
				for($i=0;$i<sizeof($selected_keys);$i++)
				{
					echo $selected_keys[$i]["customerNumber"];
					if($i<sizeof($selected_keys)-1)
					{
						echo " ,";	
					}
				}
				echo " ]</b>";
			}
		?>
	</div>	
</form>
