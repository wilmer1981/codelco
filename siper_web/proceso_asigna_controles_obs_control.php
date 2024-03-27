<? include('conectar_ori.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Descripci�n de los Controles</title>
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
	<td align="center"><table width="100%" border="0" cellpadding="0"cellspacing="0">
	<tr>
	<td colspan="2" class="TituloCabecera">Descripci�n de los Controles</td>
	</tr>
	<?
	$Consulta="SELECT *,ceiling(CCONTROL) as codigo from sgrs_codcontroles where CCONTROL<>'' order by NCONTROL asc";
	//echo $Consulta."<br>";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$OBSCONTROL=$Fila[OBS];
		$NOMCONTROL=$Fila[NCONTROL];
	?>
		<tr>
		<td width="610" align="left"><? echo $NOMCONTROL;?></td>
		<td width="468" align="left">
		<? 
		//echo $OBSCONTROL;
		$Descripcion=nl2br($OBSCONTROL);
		$Detalle=explode('<br>',$Descripcion);
		while (list($Clave,$Valor)=each($Detalle))
		{
			echo $Valor."<br>";
		}
		?></td>
		</tr>
		<tr>
		<td align="left" colspan="2">&nbsp;</td>
		</tr>
	<?
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
