<?php
	require $KoolControlsFolder."/KoolTreeView/kooltreeview.php";
		
	$treeview = new KoolTreeView("treeview");
	$treeview->scriptFolder = $KoolControlsFolder."/KoolTreeView";
	$treeview->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
	
	$root = $treeview->getRootNode();
	$root->text = "My Properties";
	$root->expand=true;
	$root->image="woman2S.gif";
	$treeview->Add("root","hardware","Hardware",false,"xpNetwork.gif","");
	$treeview->Add("hardware","laptop","HP dv2500 Laptop",false,"square_blueS.gif","");	
	$treeview->Add("hardware","desktop","Lenovo desktop",false,"square_greenS.gif","");
	$treeview->Add("hardware","lcd","Asus 19\" LCD",false,"square_redS.gif","");
	
	$treeview->Add("root","software","Software",true,"ie.gif","");
	$treeview->Add("software","os","Operating System",true,"bfly.gif","");
	$treeview->Add("os","linux","Ubuntu 8.10",false,"ball_redS.gif","");
	$treeview->Add("os","windows","Vista Home Edition",false,"ball_blueS.gif","");
	$treeview->Add("software","office","Office",false,"doc.gif","");
	$treeview->Add("office","msoffice","Microsoft Office 2007",false,"square_redS.gif","");
	$treeview->Add("office","ooffice","Open Office 2.4",false,"square_greenS.gif","");
	$treeview->Add("software","burning","Burn CD/DVD",false,"xpShared.gif","");
	$treeview->Add("burning","nero","Nero 8",false,"triangle_yellowS.gif","");
	$treeview->Add("burning","k3b","K3B <i>(on Ubuntu)</i>",false,"triangle_blueS.gif","");
	$treeview->Add("software","imageeditor","Image editors",false,"goblet_bronzeS.gif","");
	$treeview->Add("imageeditor","photoshop","Photoshop 10",false,"ball_glass_blueS.gif","");
	$treeview->Add("imageeditor","gimp","GIMP 2.3.4",false,"ball_glass_greenS.gif","");
	
	$treeview->Add("root","book","Books",false,"book.gif","");
	$treeview->Add("book","ajax","Ajax For Dummies",false,"BookY.gif","");
	$treeview->Add("book","csharp","Mastering C#",false,"BookY.gif","");
	$treeview->Add("book","flash","Flash 8 Bible",false,"BookY.gif","");
	$treeview->showLines = true;
	
	$style_select = "default";
	
	if(isset($_POST["style_select"]))
	{
		$style_select = $_POST["style_select"];
	}
	$treeview->styleFolder=$style_select;
		
?>

<form id="form1" method="post">

	Select style:
	<select id="style_select" name="style_select" onchange="submit();">
		<option value="default"		<?php if ($style_select=="default") echo "selected" ?> >Default</option>
		<option value="vista"		<?php if ($style_select=="vista") echo "selected" ?> >Vista</option>		
		<option value="hay"			<?php if ($style_select=="hay") echo "selected" ?> >Hay</option>		
		<option value="inox"		<?php if ($style_select=="inox") echo "selected" ?> >Inox</option>		
		<option value="office2007"	<?php if ($style_select=="office2007") echo "selected" ?> >Office2007</option>		
		<option value="outlook"		<?php if ($style_select=="outlook") echo "selected" ?> >Outlook</option>		
		<option value="silver"		<?php if ($style_select=="silver") echo "selected" ?> >Silver</option>		
		<option value="gray" 		<?php if ($style_select=="gray") echo "selected" ?> >Gray</option>
		<option value="graygreen" 	<?php if ($style_select=="graygreen") echo "selected" ?> >Graygreen</option>
		<option value="pink"		<?php if ($style_select=="pink") echo "selected" ?> >Pink</option>		
		<option value="green"		<?php if ($style_select=="green") echo "selected" ?> >Green</option>		
		<option value="darkgray"	<?php if ($style_select=="darkgray") echo "selected" ?> >Darkgray</option>
	</select>
	
	<div style="padding:10px;">
		<?php echo $treeview->Render();?>
	</div>
</form>
