<?php
	include("../principal/conectar_pmn_web.php");	
	//include("pmn_funciones.php");					

	$ktsElect = new KoolTabs("ktsElect");
	$ktsElect->scriptFolder = "KoolTabs";
	$ktsElect->styleFolder = "KoolTabs\styles\inox";	
	$Hora=date('H:i:s');
	$FechaTurno=date('Y-m-d');

	
	$TabElec1='true';$BlockElec1='block';$BlockElec2='none';
	if($TabElec2=='true')
	{
		$TabElec1='';$TabElec2='true';
		$BlockElec1='none';$BlockElec2='block';
	}
	$ktsElect->addTab("root","Elect1","Carga Electrolisis De Plata","javascript:showPageElect(\"Electrodo1\")",$TabElec1);//Make node selection	
	$ktsElect->addTab("root","Elect2","Descarga Electrolisis De Plata","javascript:showPageElect(\"Electrodo2\")",$TabElec2);//Make node selection	
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
function showPageElect(Pant2)
{
	//var f=document.FrmPopupProceso;
	//alert(Pant2)
   document.getElementById("Electrodo1").style.display = "none";
   document.getElementById("Electrodo2").style.display = "none";
   if(Pant2!='')
   		document.getElementById(Pant2).style.display = "block"; 
}				
</script>		    
<div class="container" style="width:545px;">
<div class="tabs">
	<?phpphp echo $ktsElect->Render();?>			
</div>
</div></td>
</tr>
<tr>
  <td valign="top">
	<div class="container" style="vertical-align:top;">
		<div class="multipages">
			<div id="Electrodo1" style="display:<?php echo $BlockElec1;?>; ">
				<?php include('pmn_carga_elec_plata.php');?>				
			</div>
			<div id="Electrodo2" style="display:<?php echo $BlockElec2;?>;">
				<?php include('pmn_descarga_elec_plata.php');?>									
			</div>			
		</div>
	</div>  
&nbsp;</td>
</tr>
</table>