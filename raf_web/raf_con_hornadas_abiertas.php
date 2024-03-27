<?
	include("../principal/conectar_pac_web.php");
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;

	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;

$Fecha = $Ano.'-'.$Mes;
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Detalle(dir)
{
	window.open(dir, "","top=0,left=50,width=730,height=320,scrollbars=yes,resizable = no");
}
function Proceso(opc)
{
	var f = document.FrmPrincipal;
	
	switch(opc)
	{
		case "P":
			f.BtnImprimir.style.visibility = 'hidden';
			f.BtnSalir.style.visibility = 'hidden';
			window.print();
			f.BtnImprimir.style.visibility = '';
			f.BtnSalir.style.visibility = '';
			break;

		case "S":
			window.history.back();
			break;
	}
	
}	
</script>	
</head>

<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body class="TablaPrincipal">
<form name="FrmPrincipal" method="post" action="">
  <table width="400" border="1" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td colspan="4" align="center"><strong>Consulta Hornadas Del Mes</strong></td>
    </tr>
  </table>
  <br>
  <br> 	
  <table width="500" border="1" cellspacing="0" cellpadding="0" align="center">
    <tr class="ColorTabla01"> 
      <td width="71" height="15" align="center"> Hornada</td>
      <td width="94" align="center">Fecha Creacion</td>
      <td width="111" align="center">Peso Programado</td>
      <td width="100" align="center">Peso Cargado</td>
      <td width="112" align="center">Porcent. Cargado</td>
    </tr>
    <?
		$Consulta = "SELECT distinct hornada FROM raf_web.movimientos where left(fecha_carga,7) = '$Fecha'";
		$Consulta.= " ORDER BY hornada";
		$rs = mysqli_query($link, $Consulta);
		while($Fila = mysql_fetch_array($rs))
		{
			$Consulta = "SELECT MIN(fecha_carga) as fecha_carga FROM raf_web.movimientos WHERE hornada = ".$Fila["hornada"];
			$Rs = mysqli_query($link, $Consulta);
			if($row = mysql_fetch_array($Rs))
			{
				$Dia = substr($row[fecha_carga],8,2);
				$Ano = substr($row[fecha_carga],0,4);
				$Mes = substr($row[fecha_carga],5,2);					  			
			}

			$Consulta = "SELECT sum(peso) as peso_prog FROM raf_web.movimientos";
			$Consulta.= " WHERE hornada = ".$Fila["hornada"];
			$rs1 = mysqli_query($link, $Consulta);
			$Fil1 = mysql_fetch_array($rs1);

			$Consulta = "SELECT sum(peso) as peso_carga FROM raf_web.det_carga";
			$Consulta.= " WHERE hornada = ".$Fila["hornada"];
			$rs2 = mysqli_query($link, $Consulta);
			$Fil2 = mysql_fetch_array($rs2);

				$porcent = ($Fil2[peso_carga] * 100)/$Fil1[peso_prog];
				echo'<tr>'; 
				  $Valores = "raf_con_carga_beneficio.php?Hornada=".substr($Fila["hornada"],6,4);
				  echo"<td align='center'><a href=JavaScript:Detalle('$Valores');>".substr($Fila["hornada"],6,5)."</a>&nbsp;</td>";
				  echo'<td align="center">'.$Dia.'-'.$Mes.'-'.$Ano.'&nbsp;</td>';
				  echo'<td align="center">'.$Fil1[peso_prog].'&nbsp;</td>';
				  echo'<td align="center">'.$Fil2[peso_carga].'&nbsp;</td>';
				  echo'<td align="center">'.number_format($porcent,0,"","").' %</td>';
				echo'</tr>';
		}		
	?>
  </table>
  <br> 	
  <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">  
	<tr>
	  <td align="center">	
	   <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('P');">
	   <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
      </td>
	</tr>
  </table>	
</form>
</body>
</html>
