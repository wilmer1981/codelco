<?php
	require $KoolControlsFolder."/KoolTreeView/kooltreeview.php";
		
	$treeview = new KoolTreeView("treeview");
	$treeview->scriptFolder = $KoolControlsFolder."/KoolTreeView";
	$treeview->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
	$treeview->styleFolder="default";
	$treeview->showLines = true;
	
	
	$root = $treeview->getRootNode();
	$root->text = "Link Node";
	$root->expand=true;
	$root->image="xpNetwork.gif";
	$treeview->Add("root","links","Links",true,"square_blueS.gif","");

	$treeview->Add("links","google","<a href='http://www.google.com' target='_blank'>Google.Com</a>",true,"ball_glass_redS.gif","");
	$treeview->Add("links","php","<a href='http://www.php.net' target='_blank'>PHP.Net</a>",true,"ball_glass_redS.gif","");
	$treeview->Add("links","koolphp","<a href='http://www.koolphp.net' target='_blank'>KoolPHP HomePage</a>",true,"ball_glass_redS.gif","");
	
	
	$treeview->Add("root","javascript","Javascript",true,"square_greenS.gif","");
	$treeview->Add("javascript","sayhello","<a href=\"javascript:alert('Hello world!')\">Say Hello</a>",true,"triangle_redS.gif","");
	
		
	
?>

	
<div style="padding:10px;">
	<?php echo $treeview->Render();?>
</div>
