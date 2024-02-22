<?php
	include("../principal/conectar_pmn_web.php");	
	//include("pmn_funciones.php");					

	$ktsD = new KoolTabs("ktsD");
	$ktsD->scriptFolder = "KoolTabs";
	$ktsD->styleFolder = "KoolTabs\styles\inox";	
	$Hora=date('H:i:s');
	$FechaTurno=date('Y-m-d');

	//echo "Tab:   ".$TabOC."<br>"; 
	$TabE='true';$BlockPE='block';$BlockOC='none';$BlockMe='none';
	if($TabOC=='true')
	{
		$TabE='';$Tab0C='true';$TabM='';
		$BlockPE='none';$BlockOC='block';$BlockMe='none';
	}
	if($TabM=='true')
	{
		$TabE='';$Tab0C='';$TabM='true';
		$BlockPE='none';$BlockOC='none';$BlockMe='block';
	}
	$ktsD->addTab("root","Prod","Prod. Externo","javascript:showPage2(\"E\")",$TabE);//Make node selection	
	$ktsD->addTab("root","Oro","Oro Compra","javascript:showPage2(\"OC\")",$Tab0C);//Make node selection	
	//$ktsD->addTab("root","Metal","Metal dore Cancan","javascript:showPage2(\"M\")",$TabM);//Make node selection	
//echo $BlockC;
?>
<html>
<head>
<title>Acceso Principal PMN</title>
<script language="JavaScript">
function Salir()
{
var f=document.frmPrincipalConsulta;
f.action='pmn_principal.php';
f.submit();
}
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<table width="101%" border="0" bgcolor="#F7F2EB">
<tr>
  <td align="center"  style="border-top-color:#F7F2EB; border-top-style:double; border-top-width:thin; border-right-color:#F7F2EB; border-right-style:double; border-right-width:thin;">
<script type="text/javascript">
function showPage2(Pant)
{
	//var f=document.FrmPopupProceso;
   document.getElementById("E").style.display = "none";
   document.getElementById("OC").style.display = "none";
   document.getElementById("M").style.display = "none";

   document.getElementById(Pant).style.display = "block"; 
}				
</script>		    
<div class="container" style="width:530px;">
<div class="tabs">
	<?phpphp echo $ktsD->Render();?>			
</div>
</div></td>
</tr>
<tr>
  <td valign="top">
	<div class="container" style="vertical-align:top;">
		<div class="multipages">
			<div id="E" style="display:<?php echo $BlockPE;?>; ">
				<?php include('pmn_ing_prod_externos.php');?>				
			</div>
			<div id="OC" style="display:<?php echo $BlockOC;?>;">
				<?php include('pmn_ing_oro_compra.php');?>									
			</div>			
			<div id="M" style="display:<?php echo $BlockMe;?>;">
				<?php //include('pmn_ing_metal_dore.php');?>									
			</div>			
		</div>
	</div>  
&nbsp;</td>
</tr>
</table>
