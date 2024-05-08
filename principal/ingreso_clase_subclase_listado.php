<?php 	
	include("../principal/conectar_comet_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	
?>
<html>
<head>
<script language="JavaScript">
function Imprimir()
{
	window.print();
}

function Salir()
{
	window.close();
}
</script>
<title>Listado de Parametros</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngParam" method="post" action="">
	<table width="740" border="0" cellpadding="2" cellspacing="0" class="TablaPrincipal">
	<tr> 
		<td align="center">
		<?php echo "PARAMETROS PMN (Mes:".$meses[$CmbMes-1]."&nbsp;&nbsp;&nbsp;Ao:".$CmbAno.")"?>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="BtnImprimir" value="Imprimir" style="width:60" onClick="Imprimir();">
		<input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
		</td>
	</tr>
	</table><br>
    <?php
	echo "<table width='740' border='1' cellpadding='2' cellspacing='0' class='TablaPrincipal'>";
	echo "<tr class='ColorTabla01'>"; 
	echo "<td width='31' align='center'>Tipo</td>";
	echo "<td width='209' align='center'>Descripcion</td>";
	echo "<td width='116' align='center'>Plata</td>";
	echo "<td width='114' align='center'>Oro</td>";
	echo "<td width='55' align='center'>Fabric.Plata</td>";
	echo "<td width='55' align='center'>Fabric.Oro</td>";
	echo "<td width='55' align='center'>C.C.Plata(T)</td>";
	echo "<td width='55' align='center'>C.C.Oro(T)</td>";
	echo "<td width='55' align='center'>M.O.Plata(I)</td>";
	echo "<td width='55' align='center'>M.O.Oro(I)</td>";
	echo "</tr>";
	$Consulta="select * from comet.parametros inner join proyecto_modernizacion.sub_clase on cod_clase='10000' and ";
	$Consulta.="tipo_calculo=cod_subclase where mes='$CmbMes' and ano='$CmbAno' and tipo='' order by cod_parametro";
	$Resultado=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resultado))
	{
		echo "<tr>"; 
		echo "<td width='30' align='right'>".trim($Fila["tipo_calculo"])."</td>";
		echo "<td width='200' align='left'>".trim($Fila["nombre_subclase"])."</td>";
		echo "<td width='100' align='right'>".number_format($Fila["valor_plata"],4,',','.')."</td>";
		echo "<td width='100' align='right'>".number_format($Fila["valor_oro"],4,',','.')."</td>";
		echo "<td width='70' align='right'>".number_format($Fila["gastos_fabric_plata"],2,',','.')."</td>";
		echo "<td width='70' align='right'>".number_format($Fila["gastos_fabric_oro"],2,',','.')."</td>";
		echo "<td width='70' align='right'>0</td>";
		echo "<td width='70' align='right'>0</td>";
		echo "<td width='70' align='right'>0</td>";
		echo "<td width='70' align='right'>0</td>";
		echo "</tr>";
	}
	$Consulta="select * from comet.parametros inner join proyecto_modernizacion.sub_clase on cod_clase='10002' and ";
	$Consulta.="tipo_calculo=cod_subclase where mes='$CmbMes' and ano='$CmbAno' and tipo<>'' order by cod_parametro";
	$Resultado=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resultado))
	{
		echo "<tr>"; 
		echo "<td width='30' align='right'>".trim($Fila["tipo_calculo"])."</td>";
		echo "<td width='200' align='left'>".trim($Fila["nombre_subclase"])."</td>";
		echo "<td width='100' align='right'>".number_format($Fila["valor_plata"],4,',','.')."&nbsp;</td>";
		echo "<td width='100' align='right'>".number_format($Fila["valor_oro"],4,',','.')."&nbsp;</td>";
		echo "<td width='70' align='right'>".number_format($Fila["gastos_fabric_plata"],2,',','.')."</td>";
		echo "<td width='70' align='right'>".number_format($Fila["gastos_fabric_oro"],2,',','.')."</td>";
		echo "<td width='70' align='right'>".number_format($Fila["mano_obra_plata"],2,',','.')."</td>";
		echo "<td width='70' align='right'>".number_format($Fila["mano_obra_oro"],2,',','.')."</td>";
		echo "<td width='70' align='right'>".number_format($Fila["mano_obra_plata2"],2,',','.')."</td>";
		echo "<td width='70' align='right'>".number_format($Fila["mano_obra_oro2"],2,',','.')."</td>";
		echo "</tr>";
	}
	echo "</table>";
	?>
</form>
</body>
</html>