<?php
	require $KoolControlsFolder."/KoolSlideMenu/koolslidemenu.php";
	$ksm = new KoolSlideMenu("ksm");
	$ksm->scriptFolder =  $KoolControlsFolder."/KoolSlideMenu";	
	$ksm->styleFolder = $KoolControlsFolder."KoolSlideMenu/styles/black";
	$ksm->addParent("root","corporate","Corporate",null,true);

	//About us
	$ksm->addParent("corporate","aboutus","About Us",null,true);
	$ksm->addChild("aboutus","news","News");
	$ksm->addChild("aboutus","team","Team");

	//Careers
	$ksm->addParent("corporate","careers","Careers");
	$ksm->addChild("careers","joboffers","Job Offers");
	$ksm->addChild("careers","environment","Environment");
	
	$ksm->addParent("root","services","Services");
	$ksm->addChild("services","products","Products");
	$ksm->addChild("services","solutions","Solutions");	
	$ksm->addChild("services","certifications","Certifications");	

	$ksm->addParent("root","work","Work");
	$ksm->addChild("work","clients","Clients");
	$ksm->addChild("work","tesimonials","Tesimonials");
	$ksm->addChild("work","faq","FAQ");	
	
	$ksm->width="200px";
	$ksm->singleExpand = true;	
	
?>
<form id="form1" method="post">
	<link rel="stylesheet" href="blackstyle.css" />
	<?php echo $ksm->Render();?>
</form>
