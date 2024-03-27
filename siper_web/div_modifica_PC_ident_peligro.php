<? include('conectar_ori.php');
include('funciones/siper_funciones.php');
if($Cargar=='S')
{
	$CODAREA=ObtenerCodParent($Parent);
	$Actualizar="UPDATE sgrs_siperpeligros set QPROBHIST='".$P."',QCONSECHIST='".$C."' where CAREA='".$CODAREA."' and CPELIGRO='".$CodPeligro."'";
	//echo $Actualizar."<br>";
	mysql_query($Actualizar);
	
	echo "<script languaje=\"JavaScript\">";
		echo "window.opener.document.Mantenedor.action=\"procesos_organica.php?TipoPestana=1&Parent=".$Parent."\";";
		echo "window.opener.document.Mantenedor.submit();";
		echo "window.close();";
	echo "</script>";
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Definiciones de los Controles</title>
<head>
<script language="javascript">
function Grabar(Cod,parent)
{	
	var f =document.MantenedorCont;
	f.action = "div_modifica_PC_ident_peligro.php?Cargar=S&P="+f.CmbProbH.value+'&C='+f.CmbConsH.value+'&CodPeligro='+Cod+'&Parent='+parent;
	f.submit();
}
function Cerrar()
{
	window.close();	
}
</script>
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
	<td align="center">
	<table width="100%" border="0" cellpadding="0"cellspacing="0">
	<tr>
	<td colspan="4" align="right"><a href="JavaScript:Grabar('<? echo $CodPeligro;?>','<? echo $Parent;?>')"><img src="imagenes/btn_guardar.png" height="20" alt="Guardar PH - CH" width="20" border="0" align="absmiddle" /></a>
	  <a href="JavaScript:Cerrar()"><img src="imagenes/cerrar1.png" width="20" height="20" border="0" alt="Cerrar" align="absmiddle"></a> </td>
	</tr>
	<tr>
	<td colspan="4" class="TituloCabecera">Peligro&nbsp;&nbsp;<a href='documento/Guia para calculo de la Magnitud de Riesgo Inicial.pdf' target="_blank"><img src='imagenes/obs.png' alt="Guia para calculo de la Magnitud de Riesgo Inicial" border=0 width='17' height='17'></a></td>
	</tr>
	<tr>
	<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
	<?
		$CODAREA=ObtenerCodParent(&$Parent);
		$Consulta="SELECT t1.QPROBHIST,t1.QCONSECHIST,t2.NCONTACTO from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.CAREA='".$CODAREA."' and t1.CPELIGRO='".$CodPeligro."'";
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$P=$Fila[QPROBHIST];
			$C=$Fila[QCONSECHIST];
			$NOMBRE=$Fila[NCONTACTO];
			
		}
	?>
	<td colspan="4" class="formulario"><? echo $NOMBRE;?></td>
	</tr>
	<tr>
	<td colspan="4">&nbsp;</td>
	</tr>
			  		<td width="13%">Probabilidad</td>
					<td width="29%">
	                <SELECT name='CmbProbH'>
					<?
						switch($P)
						{
							case "1":
								echo "<option value='1' SELECTed>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "2":
								echo "<option value='1'>1</option>";
								echo "<option value='2' SELECTed>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "4":
								echo "<option value='1'>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4' SELECTed>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "8":
								echo "<option value='1'>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8' SELECTed>8</option>";
							break;
							default:
								echo "<option value='1' SELECTed>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							
						}
				  
				    ?>
				    </SELECT>
				   
					</td>
			  		<td width="13%">Consecuencia</td>
			  		<td width="45%">
			  		<SELECT name='CmbConsH'><?
			  		switch($C)
					{
							case "1":
								echo "<option value='1' SELECTed>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "2":
								echo "<option value='1'>1</option>";
								echo "<option value='2' SELECTed>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "4":
								echo "<option value='1'>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4' SELECTed>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "8":
								echo "<option value='1'>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8' SELECTed>8</option>";
							break;
							default:
								echo "<option value='1' SELECTed>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
						
					}
				    ?>
				    </SELECT>
					</td>
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
