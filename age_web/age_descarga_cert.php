<?php
	include("../principal/conectar_principal.php");
	$CookieRut   = $_COOKIE["CookieRut"];
	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Tipo        = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
	$Elim        = isset($_REQUEST["Elim"])?$_REQUEST["Elim"]:"";
	$ArchivoElim = isset($_REQUEST["ArchivoElim"])?$_REQUEST["ArchivoElim"]:"";
	$Lote        = isset($_REQUEST["Lote"])?$_REQUEST["Lote"]:"";
	$ArrArchivo  = isset($_REQUEST["ArrArchivo"])?$_REQUEST["ArrArchivo"]:"";
	

	$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =16";
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$Nivel=$Fila["nivel"];
	if ($Elim=="S")
	{
		$Dir = 'certificados';
		$ArchivoElim = $Dir."/".$ArchivoElim;
		if (file_exists($ArchivoElim))
			unlink($ArchivoElim);
	}
	
?>
<html>
<head>

<title>Certificados</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
.text1 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #CCCCCC}
.text2 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #999999}
.titre1 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #FFFFFF}

body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
<script language="javascript">
function Salir()
{
	//window.opener.document.frmPrincipal.action='age_adm_cierre_lote_masivo.php?Buscar=S';
	window.opener.document.frmPrincipal.submit();
	window.close();
}
function DelFile(arch,Lote)
{
	var f=document.frmDescarga;
	var msg=confirm("¿Desea Eliminar este Archivo?");
	if (msg==true)
	{
		f.action="age_descarga_cert.php?Elim=S&ArchivoElim="+arch+"&Lote="+Lote;
		f.submit();
	}
	else
	{
		return;
	}
}
</script>
</head>

<body>
<form name="frmDescarga" action="" method="post">
<input type="hidden" name="Proceso" value="<?php echo $Proceso; ?>">
<input type="hidden" name="Tipo" value="<?php echo $Tipo; ?>">
<table width="550" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
	<tr align="center"> 
		<td colspan="5" valign="top" nowrap class="Detalle03"><strong>Archivos Existentes</strong></td>
	</tr>
	<tr align="center" class="ColorTabla01">
	  <td width="6%" valign="top">Elim</td>
      <td width="51%" valign="top">Archivo</td>
      <td width="18%" valign="top">Fecha</td>
      <td width="14%" valign="top">Tama&ntilde;o(Kb)</td>
      <td width="11%" valign="top">Descargar</td>
  </tr>
<?php
$ArrArchivos = array();
$Dir = 'certificados';
$Directorio=opendir('certificados');
$i=0;
$ContCDV=0;
$ContENM=0;
while ($Archivo = readdir($Directorio)) 
{
	if($Archivo != '..' && $Archivo !='.' && $Archivo !='' && substr($Archivo,0,6)==$Lote)
	{ 		
		$FechaHora = date("d-m-Y H:i:s", filemtime($Dir."/".$Archivo));
		if (strtoupper(substr($Archivo,-7))=="CDV.PDF")
			$ContCDV++;
		if (strtoupper(substr($Archivo,-7))=="ENM.PDF")
			$ContENM++;
		$Peso = filesize($Dir."/".$Archivo);
		$ArrArchivo[$i][0] = $Archivo;
		$ArrArchivo[$i][1] = $FechaHora;
		$ArrArchivo[$i][2] = $Peso;
	}
	$i++;
}
closedir($Directorio);
//if (count($ArrArchivo)>0)
if(is_countable($ArrArchivo) && count($ArrArchivo)>0)
{
	reset($ArrArchivo);
	krsort($ArrArchivo);
	foreach($ArrArchivo as $k=>$v)
	{
		echo "<tr>\n";
		if($Nivel=='1'||$Nivel=='5')
			echo "<td align='center'><a href=\"JavaScript:DelFile('".$v[0]."','".$Lote."')\"><img src=\"../principal/imagenes/ico_borrado.gif\" border='0'></a></td>\n";
		else
			echo "<td align='center'><img src=\"../principal/imagenes/img_no.gif\" border='0'></td>\n";
		echo "<td><img src=\"../principal/imagenes/img_listado.gif\" border='0' align='absmiddle'>&nbsp;".$v[0]."</td>\n";
		echo "<td align='center'>".$v[1]."</td>\n";
		echo "<td align='right'>".number_format($v[2]/1000,3,",",".")."</td>\n";
		echo "<td align='center'><a href=\"".$Dir."/".$v[0]."\" target='_blank'><img src=\"../principal/imagenes/ico_abajo.gif\" border='0'></a></td>\n";
		echo "</tr>\n";
	}
}
if ($ContCDV==0)
{
	$Actualizar="UPDATE age_web.lotes set certificado='' where lote ='".$Lote."'";
	mysqli_query($link, $Actualizar);
}
if ($ContENM==0)
{
	$Actualizar="UPDATE age_web.lotes set certificado_enm='' where lote ='".$Lote."'";
	mysqli_query($link, $Actualizar);
}	
clearstatcache();
?>
</table><br>
<table width="550" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr>
    <td align="center" class="Detalle02">
      <input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="JavaScript:Salir()"></td>
  </tr>
</table>
</form>
<br>
</body>
</html>
