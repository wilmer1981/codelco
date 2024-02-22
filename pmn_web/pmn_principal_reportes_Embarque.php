<?php
	include("../principal/conectar_pmn_web.php");	
	//include("pmn_funciones.php");					

	$ktsEmbarque = new KoolTabs("ktsEmbarque");
	$ktsEmbarque->scriptFolder = "KoolTabs";
	$ktsEmbarque->styleFolder = "KoolTabs\styles\inox";	
	$Hora=date('H:i:s');
	$FechaTurno=date('Y-m-d');

	//echo "Tab:   ".$TabOC."<br>"; 
	$TabEmba1='true';$BlockEmbar1='block';$BlockEmbar2='none';
	if($TabEmba2=='true')
	{
		$TabEmba1='';$TabEmba2='true';
		$BlockEmbar1='none';$BlockEmbar2='block';
	}
	$ktsEmbarque->addTab("root","Embar11","Embarque De Oro","javascript:showPageEmba(\"EmbarUno\")",$TabEmba1);//Make node selection	
	$ktsEmbarque->addTab("root","Embar22","Embarque Plata","javascript:showPageEmba(\"EmbarDos\")",$TabEmba2);//Make node selection	
//echo $BlockEmbar2;
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
function showPageEmba(Pant)
{
	//var f=document.FrmPopupProceso;
   document.getElementById("EmbarUno").style.display = "none";
   document.getElementById("EmbarDos").style.display = "none";

   document.getElementById(Pant).style.display = "block"; 
}				
</script>		    
<div class="container" style="width:530px;">
<div class="tabs">
	<?phpphp echo $ktsEmbarque->Render();?>			
</div>
</div></td>
</tr>
<tr>
  <td valign="top">
	<div class="container" style="vertical-align:top;">
		<div class="multipages">
			<div id="EmbarUno" style="display:<?php echo $BlockEmbar1;?>;">
				<?php include('pmn_embarque_barras_oro.php');?>				
			</div>
			<div id="EmbarDos" style="display:<?php echo $BlockEmbar2;?>;">
				<?php include('pmn_embarque_plata.php');?>									
			</div>			
		</div>
	</div>  
&nbsp;</td>
</tr>
</table>
