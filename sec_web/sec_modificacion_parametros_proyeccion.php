<?php
	include("../principal/conectar_principal.php");

	$Buscar  = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$mostrar  = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$mes  = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$ano  = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
?>
<html>
<head>
<title>PAR�METROS PROYECCI�N</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "C":
			f.action = "sec_modificacion_parametros_proyeccion.php?Buscar=S&mostrar=S";
			f.submit();
			break;
		case "L":
		     f.action = "sec_modificacion_parametros_proyeccion.php?Buscar=T";
			 f.submit();
             break;
		case "A":
		      f.action = "sec_modificacion_parametros_proyeccion.php?Buscar=R";
			  f.submit();
			  break;
		case "I":
			f.BtnConsultar.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			f.BtnNuevo.style.visibility = "hidden";
			f.BtnListaAno.style.visibility = "hidden";
			f.BtnListaTodo.style.visibility = "hidden";
			f.BtnModificar.style.visibility = "hidden";
			window.print();
			f.BtnConsultar.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			f.BtnNuevo.style.visibility = "visible";
			f.BtnListaAno.style.visibility = "visible";
			f.BtnListaTodo.style.visibility = "visible";
			f.BtnModificar.style.visibility = "visible";
			break;
		case "N":
			window.open("sec_modificacion_parametros_proyeccion_proceso_nuevo.php?ano="+f.ano.value+"&mes="+f.mes.value,"","top=60,left=180,width=530,height=250,scrollbars=no,resizable =yes");		
			break;
		case "M":
			window.open("sec_modificacion_parametros_proyeccion_proceso.php?ano="+f.ano.value+"&mes="+f.mes.value,"","top=60,left=180,width=530,height=250,scrollbars=no,resizable =yes");
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=3";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<table width="600"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla01">
    <td colspan="2"><strong>PAR�METROS PROYECCI�N</strong></td>
  </tr>
  <tr>
    <td width="10" bgcolor="#FFFFFF">MES/A&Ntilde;O</td>
    <td width="401">
      
	  <select name="mes" size="1" id="select2">
        <?php
		for($i=1;$i<13;$i++)
		{
			if (($mostrar == "S") && ($i == $mes))
				echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
			else if (($i == date("n")) && ($mostrar != "S"))
					echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$Meses[$i-1]."</option>\n";			
		}		  
	   ?>
      </select>  
      
	  <select name="ano" size="1">
        <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($mostrar == "S") && ($i == $ano))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($mostrar != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
      </select> 
	  			
				<input name="BtnConsultar" type="button" value="Consultar" style="width:70px " onClick="Proceso('C')"> 
                <input name="BtnListaAno" type="button" id="BtnListaAno" style="width:70px " onClick="Proceso('L')" value="Listar A&ntilde;o">				
                <input name="BtnListaTodo" type="button" id="BtnListaTodo2" style="width:70px " onClick="Proceso('A')" value="Listar Todo">  
      </tr>
  <tr align="center">
    <td height="30" colspan="2">
      <input name="BtnNuevo" type="button" id="BtnNuevo" style="width:70px " onClick="Proceso('N')" value="Nuevo">      
      <input name="BtnModificar" type="button" id="BtnModificar" style="width:70px " onClick="Proceso('M')" value="Modificar">	  
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td></tr>
</table><br>
<table width="430" border="1" align="center" cellpadding="2" cellspacing="0" >
  <tr class="ColorTabla02">
    <td width="81" align="center">MES</td>
	<td width="81" align="center">A�O</td>
    <td width="107" align="center">STOCK MES ANTERIOR (TON.) </td>
	<td width="135" align="center">FACTOR RECH.</td>
	<td width="135" align="center">FACTOR RECH. PROG</td>
	<td width="135" align="center">DIA DE CIERRE</td>
</tr>
<?php
if($Buscar=='S')
{
	$Consulta="select * from sec_web.parametros_mensual_proyeccion ";
	$Consulta.="where ano='".$ano."' and mes='".$mes."'";
	$RespSec=mysqli_query($link, $Consulta);
	while($FilaSec=mysqli_fetch_array($RespSec))
	{
		$formateo=number_format($FilaSec["tonelaje"],0,"",".");
		$format_factor=number_format($FilaSec["factor_rechazo"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ,2,",",".");
		$format_factor_prog=number_format($FilaSec["factor_rechazo_prog"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ,4,",",".");
		$dia=$FilaSec["dia"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              ;
		echo "<tr>";
		echo "<td align='center'>".$Meses[$FilaSec["mes"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           -1]."</td>";
		echo "<td align='center'>".$FilaSec["ano"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ."</td>";
		echo "<td align='center'>".$formateo."</td>";
		echo "<td align='center'>".$format_factor."</td>";
		echo "<td align='center'>".$format_factor_prog."</td>";
		echo "<td align='center'>".$dia."&nbsp;</td>";
		echo "</tr>\n";			
	}
}

if($Buscar=='T')
{
	$Consulta="select * from sec_web.parametros_mensual_proyeccion ";
	$Consulta.="where ano='".$ano."'";
	$RespSec=mysqli_query($link, $Consulta);
	while($FilaSec=mysqli_fetch_array($RespSec))
	{
		$formateo=number_format($FilaSec["tonelaje"],0,"",".");
		$format_factor=number_format($FilaSec["factor_rechazo"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ,2,",",".");
		$format_factor_prog=number_format($FilaSec["factor_rechazo_prog"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ,4,",",".");
		$dia=$FilaSec["dia"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              ;
		echo "<tr>";
		echo "<td align='center'>".$Meses[$FilaSec["mes"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           -1]."</td>";
		echo "<td align='center'>".$FilaSec["ano"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ."</td>";
		echo "<td align='center'>".$formateo."</td>";
		echo "<td align='center'>".$format_factor."</td>";
		echo "<td align='center'>".$format_factor_prog."</td>";
		echo "<td align='center'>".$dia."&nbsp;</td>";
		echo "</tr>\n";			
	}
}

if($Buscar=='R')
{
	$Consulta="select * from sec_web.parametros_mensual_proyeccion ";
	$RespSec=mysqli_query($link, $Consulta);
	while($FilaSec=mysqli_fetch_array($RespSec))
	{
		$formateo=number_format($FilaSec["tonelaje"],0,"",".");
		$format_factor=number_format($FilaSec["factor_rechazo"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ,2,",",".");
		$format_factor_prog=number_format($FilaSec["factor_rechazo_prog"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ,4,",",".");
		$dia=$FilaSec["dia"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              ;
		echo "<tr>";
		echo "<td align='center'>".$Meses[$FilaSec["mes"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           -1]."</td>";
		echo "<td align='center'>".$FilaSec["ano"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ."</td>";
		echo "<td align='center'>".$formateo."</td>";
		echo "<td align='center'>".$format_factor."</td>";
		echo "<td align='center'>".$format_factor_prog."</td>";
		echo "<td align='center'>".$dia."&nbsp;</td>";
		echo "</tr>\n";			
	}
}
?>
</table>
</form>
</body>
</html>