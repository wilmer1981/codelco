<?php
$CmbDias = $_REQUEST["CmbDias"];
$CmbMes = $_REQUEST["CmbMes"];
$CmbAno = $_REQUEST["CmbAno"];
$CmbDiasT = $_REQUEST["CmbDiasT"];
$CmbMesT = $_REQUEST["CmbMesT"];
$CmbAnoT = $_REQUEST["CmbAnoT"];

?>
<html>
<head>
<script language="JavaScript">
function Salir()
{
	var Frm=document.FrmProceso;
	
	Frm.action='actualizar_candados.php?CodSistema=1&Nivel=1&CodPantalla=44';
	Frm.submit();
}
</script>
<title>PROCESO CANDADOS</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
<?php include("../principal/encabezado.php")?>
<table width="771" border="0" cellpadding="5" cellspacing="0"  left="5" class="TablaPrincipal">
   <tr> 
	<td>
<?php
	include ("../Principal/conectar_cal_web.php");
	
	echo "<table width='400' border='0' cellpadding='3' cellspacing='0' class='TablaDetalle'>";
    echo "<tr class='ColorTabla01'>";
	echo "<td>NRO.SA</td>";
	echo "<td>NRO.RECARGO</td>";
	echo "<td>NRO.ID_MUESTRA</td></tr>";
	$FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
	$FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
	$Consulta="select * from cal_web.solicitud_analisis where estado_actual='5' and fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		if (is_null($Fila["recargo"])&&($Fila["recargo"]==''))
		{
			$Consulta="select count(*) as total from leyes_por_solicitud ";
			$Consulta=$Consulta." where rut_funcionario='".$Fila["rut_funcionario"]."'";
			$Consulta=$Consulta." and fecha_hora ='".$Fila["fecha_hora"]."' and nro_solicitud=".$Fila["nro_solicitud"];
			$Consulta=$Consulta." and candado <> '1'";
		}
		else
		{
			$Consulta="select count(*) as total from leyes_por_solicitud ";
			$Consulta=$Consulta." where rut_funcionario='".$Fila["rut_funcionario"]."'";
			$Consulta=$Consulta." and fecha_hora ='".$Fila["fecha_hora"]."' and nro_solicitud=".$Fila["nro_solicitud"]." and recargo='".$Fila["recargo"]."'";
			$Consulta=$Consulta." and candado <> '1'";
		}
		$Respuesta2=mysqli_query($link, $Consulta);
		$Fila2=mysqli_fetch_array($Respuesta2);
		if ($Fila2["total"]==0)
		{
			echo "<tr>";
			echo "<td>".$Fila["nro_solicitud"]."</td>";
			echo "<td>".$Fila["recargo"]."</td>";
			echo "<td>".$Fila["id_muestra"]."</td>";
			echo "</tr>";
			$i++;
		}	
	}
	echo "</table><br>";
	echo "<table width='400' border='0' cellpadding='3' cellspacing='0' class='TablaInterior'>";
    echo "<tr>";
	echo "<td>Datos Veridicados entre ".$FechaInicio." y  ".$FechaTermino."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Registros Afectados:".$i."</td>";
	echo "</tr>";
	echo "</table>";
	echo "<br>";
	echo "<table width='400' border='0' cellpadding='3' cellspacing='0' class='TablaInterior'>";
    echo "<tr>";
	echo "<td align='center'><input type='button' name='TxtSalir' value ='Salir' style='width:60' onclick='Salir();'></td>";
	echo "</table>";
	
?>
	</td>	
  </tr>
  </table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>