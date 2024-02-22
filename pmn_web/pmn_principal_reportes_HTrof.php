<?php
	include("../principal/conectar_pmn_web.php");	
	//include("pmn_funciones.php");					

	$ktsHorno = new KoolTabs("ktsHorno");
	$ktsHorno->scriptFolder = "KoolTabs";
	$ktsHorno->styleFolder = "KoolTabs\styles\inox";	
	$Hora=date('H:i:s');
	$FechaTurno=date('Y-m-d');

	
	$TabHorno1='true';$BlockHorno1='block';$BlockHorno2='none';
	if($TabHorno2=='true')
	{
		$TabHorno1='';$TabHorno2='true';
		$BlockHorno1='none';$BlockHorno2='block';
	}
	$ktsHorno->addTab("root","Horno1","Ingreso Carga Normal A Horno Trof","javascript:showPageHorno(\"HornoI\")",$TabHorno1);//Make node selection	
	$ktsHorno->addTab("root","Horno2","Produccion Horno Trof","javascript:showPageHorno(\"HornoP\")",$TabHorno2);//Make node selection	
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
function showPageHorno(Pant2)
{
	//var f=document.FrmPopupProceso;
	//alert(Pant2)
   document.getElementById("HornoI").style.display = "none";
   document.getElementById("HornoP").style.display = "none";
   if(Pant2!='')
   		document.getElementById(Pant2).style.display = "block"; 
}				
</script>		    
<div class="container" style="width:545px;">
<div class="tabs">
	<?phpphp echo $ktsHorno->Render();?>			
</div>
</div></td>
</tr>
<tr>
  <td valign="top">
	<div class="container" style="vertical-align:top;">
		<div class="multipages">
			<div id="HornoI" style="display:<?php echo $BlockHorno1;?>; ">
				<?php include('pmn_ing_carga_horno_trof.php');?>				
			</div>
			<div id="HornoP" style="display:<?php echo $BlockHorno2;?>;">
				<?php include('pmn_ing_produccion_horno_trof.php');?>									
			</div>			
		</div>
	</div>  
&nbsp;</td>
</tr>
</table>