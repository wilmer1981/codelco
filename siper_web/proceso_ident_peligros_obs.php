<? include('conectar_ori.php');?>
<html >
<title>Descripci�n de los Peligros</title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form name="MantenedorCont" method="post">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td ><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td ><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
	<td align="center"><table width="100%" border="1" cellpadding="0"cellspacing="0">
	<tr>
	<td colspan="2" align="center" class="TituloCabecera">Descripci�n de los Peligros</td>
	</tr>
	<?	
	$Peligros=str_replace("\'","'",$Peligros);
	//$Consulta="SELECT * from sgrs_codcontactos where MVIGENTE ='1' and MOPCIONAL='1' and CCONTACTO NOT IN ".$Peligros." and NCONTACTO <> '' order by CCONTACTO";
	$Consulta="SELECT *,ceiling(CCONTACTO) as order_codigo from sgrs_codcontactos where MVIGENTE ='1' and MOPCIONAL='1' and NCONTACTO <> '' order by NCONTACTO";
	//echo $Consulta;
	$Resultado=mysql_query($Consulta);echo "<input type='hidden' name='CheckPel'>";
	while ($Fila=mysql_fetch_array($Resultado))
	{
		$CmbProbH=$Fila[QPROBHIST];
		$CmbConsH=$Fila[QCONSECHIST];
		echo "<tr>";
			if(strlen($Fila[CCONTACTO]." ".$Fila[NCONTACTO])>='65')
				$Dato=substr($Fila[NCONTACTO],0,65).'...';
			else
				$Dato=$Fila[NCONTACTO];	
			echo "<td align='left' width='55%'>".$Dato."</td>";
			echo "<td align='left' width='45%'>".$Fila[OBS]."&nbsp;</td>";
		echo "</tr>";	
	}
	?>
	</table></td>
    <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table>	
</form>
</body>
</html>
