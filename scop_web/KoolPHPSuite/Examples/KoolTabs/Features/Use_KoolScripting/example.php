<?php
	require $KoolControlsFolder."/KoolTabs/kooltabs.php";
?>

<form id="form1" method="post">
	<?php echo KoolScripting::Start();?>
		<kooltabs id="kts" styleFolder="silver" scriptFolder="<?php echo $KoolControlsFolder."/KoolTabs"; ?>">
			<tab id="home" text="Home" selected="true"/>
			<tab id="products" text="Products" />
			<tab id="services" text="Services" />
			<tab id="company" text="Company" />
			<tab id="contactus" text="Contact us" />				
		</kooltabs>
	<?php echo KoolScripting::End();?>

</form>