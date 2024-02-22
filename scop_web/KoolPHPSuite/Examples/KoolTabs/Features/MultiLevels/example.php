<?php
	require $KoolControlsFolder."/KoolTabs/kooltabs.php";

	$kts = new KoolTabs("kts");
	$kts->styleFolder = "silver";
	$kts->addTab("root","home","Home",null,true);	
	$kts->addTab("root","products","Products");
	$kts->addTab("root","services","Services");
	$kts->addTab("root","company","Company");
	$kts->addTab("root","contactus","Contact us");
	
	$kts->addTab("home","intro","Introduction",null,true);	
	$kts->addTab("home","strategy","Strategy",null,true);	
	
	$kts->addTab("products","kooltreeview","KoolTreeView");	
	$kts->addTab("products","koolslidemenu","KoolSlideMenu");	
	
	$kts->addTab("services","oursource","Out-sourcing");	
	$kts->addTab("services","consultant","Consultant Services");	
	
	$kts->addTab("company","aboutus","About us");	
	$kts->addTab("company","keystaffs","Key staffs");
	
	$kts->addTab("contactus","headquater","Head Quater");	
	$kts->addTab("contactus","branches","Branches");
?>

<form id="form1" method="post">
	<div style="padding:10px;">
		<?php echo $kts->Render();?>
	</div>
</form>
