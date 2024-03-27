<?
	include("../principal/conectar_pac_web.php");
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;

	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
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
      <td colspan="4" align="center"><strong>Consulta Cargas En Beneficio</strong></td>
    </tr>
  </table>
  <br>
  <br> 	
  <table width="200" border="1" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td><strong>Fecha : </strong> <? echo $Dia.'-'.$Mes.'-'.$Ano;?> </td>
    </tr>
  </table>
  <br>	
  <table width="500" border="1" cellspacing="0" cellpadding="0" align="center">
   <tr class="ColorTabla01"> 
      <td align="center">Hornada</td>
      <td align="center">Peso Programado</td>
      <td align="center">Peso Cargado</td>
      <td align="center">Porcentaje</td>
    </tr>
	<?
		$Fecha = $Ano.'-'.$Mes.'-'.$Dia;
		$Consulta = "SELECT distinct hornada FROM raf_web.det_carga WHERE left(fecha,10) = '$Fecha'";
		$rs = mysqli_query($link, $Consulta);
		while($Fila = mysql_fetch_array($rs))
		{
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
				  echo'<td align="center">'.substr($Fila["hornada"],6,4).'&nbsp;</td>';
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
