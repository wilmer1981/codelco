<?php
	include("../principal/conectar_pmn_web.php");	
	//include("pmn_funciones.php");					

	$ktsAuLixi = new KoolTabs("ktsAuLixi");
	$ktsAuLixi->scriptFolder = "KoolTabs";
	$ktsAuLixi->styleFolder = "KoolTabs\styles\inox";	
	$Hora=date('H:i:s');
	$FechaTurno=date('Y-m-d');

	
	$TabLixiAu1='true';$BlockLixiAu1='block';$BlockLixiAu2='none';
	if($TabLixiAu2=='true')
	{
		$TabLixiAu1='';$TabLixiAu2='true';
		$BlockLixiAu1='none';$BlockLixiAu2='block';
	}
	$ktsAuLixi->addTab("root","CargaLixi","Carga Lixiviacion Barro Aurifero","javascript:showPageLixiAu(\"LixiAu1\")",$TabLixiAu1);//Make node selection	
	$ktsAuLixi->addTab("root","Descar","Descarga Lixiviacion Barro Aurifero","javascript:showPageLixiAu(\"LixiAu2\")",$TabLixiAu2);//Make node selection	
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
function showPageLixiAu(Pant2)
{
	//var f=document.FrmPopupProceso;
	//alert(Pant2)
   document.getElementById("LixiAu1").style.display = "none";
   document.getElementById("LixiAu2").style.display = "none";
   if(Pant2!='')
   		document.getElementById(Pant2).style.display = "block"; 
}				
</script>		    
<div class="container" style="width:545px;">
<div class="tabs">
	<?phpphp echo $ktsAuLixi->Render();?>			
</div>
</div></td>
</tr>
<tr>
  <td valign="top">
	<div class="container" style="vertical-align:top;">
		<div class="multipages">
			<div id="LixiAu1" style="display:<?php echo $BlockLixiAu1;?>; ">
				<?php include('pmn_carga_lixiviacion_barro_aurifero.php');?>				
			</div>
			<div id="LixiAu2" style="display:<?php echo $BlockLixiAu2;?>;">
				<?php include('pmn_descarga_lixiviacion_barro_aurifero.php');?>									
			</div>			
		</div>
	</div>  
&nbsp;</td>
</tr>
</table>