<?php
	require $KoolControlsFolder."/KoolTreeView/kooltreeview.php";
		
	$treeview = new KoolTreeView("treeview");
	$treeview->scriptFolder = $KoolControlsFolder."/KoolTreeView";
	$treeview->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
	$treeview->styleFolder = "default";
	
	
	$root = $treeview->getRootNode();
	$root->text = "My Gallery";
	$root->expand=true;
	$root->image="woman2S.gif";
	$root->addData("image","");
	$root->addData("name","Welcome to my gallery !");

	$node=$treeview->Add("root","CGallery","Color Gallery",true,"bfly.gif","");
		$node->addData("image","");
		$node->addData("name","Welcome to color Gallery");	
	$node=$treeview->Add("CGallery","P1","Picture #1",false,"square_blueS.gif","");	
		$node->addData("image","P01.jpg");
		$node->addData("name","Lodory and new");
		$node->addData("auth","Jenny Fans");
		$node->addData("price","$1000");
	$node=$treeview->Add("CGallery","P2","Picture #2",false,"square_greenS.gif","");
		$node->addData("image","P02.jpg");
		$node->addData("name","Chammy look");
		$node->addData("auth","Jenny Fans");
		$node->addData("price","$4000");
	$node=$treeview->Add("CGallery","P3","Picture #3",false,"square_redS.gif","");
		$node->addData("image","P03.jpg");
		$node->addData("name","Think and do");
		$node->addData("auth","Tonny Parker");
		$node->addData("price","$1030");
	$node=$treeview->Add("CGallery","P4","Picture #4",false,"square_yellowS.gif","");
		$node->addData("image","P04.jpg");
		$node->addData("name","How can you do it");
		$node->addData("auth","Tonny Parker");
		$node->addData("price","$2500");
		
	$node=$treeview->Add("root","BWgallery"," Black & White",true,"help_page.gif","");
		$node->addData("image","");
		$node->addData("name","Welcome to Black & White Gallery");
	$node=$treeview->Add("BWgallery","a1","Picture #1",false,"help_page.gif","");
		$node->addData("image","P11.jpg");
		$node->addData("name","Coming world");
		$node->addData("auth","Jenny Fans");
		$node->addData("price","$2500");
	$node=$treeview->Add("BWgallery","a2","Picture #2",false,"help_page.gif","");	
		$node->addData("image","P12.jpg");
		$node->addData("name","Lucky feeling");
		$node->addData("auth","Cham Lenxy");
		$node->addData("price","$3000");
	$node=$treeview->Add("BWgallery","a3","Picture #3",false,"help_page.gif","");	
		$node->addData("image","P13.jpg");
		$node->addData("name","The day and night");
		$node->addData("auth","To Ngoc Van");
		$node->addData("price","$5000");

	$treeview->showLines = true;
		
?>

<style type="text/css" rel="stylesheet">
	 #img
	 {
		border : gray 1px solid ;		
		padding: 0;
		margin:5px;
		height : 120px;
		width : 160px;
	 }
	#name, #price, #auth
	 {
		padding: 3px;
		margin:5px;		
	 }
	  #columnleft
	 {
	  float:left;
	  width:200px;
	  height:180px;	 
		margin : 5px;
		padding : 10px;
	 }
	  #columnright
	 {
	  float:left;
	  width:200px;
	  height:180px;	  
	  margin : 5px;
	  padding : 10px;
	 }	
</style>

<div id="columnleft">
	<?php echo $treeview->Render();?>
</div>
<div id="columright">
	<fieldset style="width:320px; height: 145px; ">
		<legend >Details :</legend>
		<div style="float:left;">    <div id="img" align="center"></div></div>
		<div style="float:left;">  
			<div id="name" ></div>
			<div id="auth" ></div>
			<div id="price"></div>
		</div>
	</fieldset>			
</div>
<div style="clear:both;"></div>
<script type="text/javascript">
    function nodeSelect_handle(sender,arg)
    {	
		var treenode = treeview.getNode(arg.NodeId);
		var image = treenode.getData("image");	
		if( image !="")
		{
			var name = treenode.getData("name");	
			var auth = treenode.getData("auth");	
			var price = treenode.getData("price");
			document.getElementById('img').innerHTML = "<img src='Images/" + image +"' >";
			document.getElementById('name').innerHTML = "<i>Picture name : </i><br /><b>" + name + "</b>"  ;
			document.getElementById('auth').innerHTML = "<i>Author : </i><br /><b>" + auth + "</b>"  ;
			document.getElementById('price').innerHTML = "<i>Price : </i><br /><b>" + price + "</b>"  ;
		}
		else
		{	
			var name = treenode.getData("name");
			document.getElementById('img').innerHTML =  name ;
			document.getElementById('name').innerHTML = "" ;
			document.getElementById('auth').innerHTML = "" ;
			document.getElementById('price').innerHTML = "" ;
		}
    }
    treeview.registerEvent("OnSelect",nodeSelect_handle);
</script>

