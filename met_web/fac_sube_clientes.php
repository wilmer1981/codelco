<?
	if ($Elim=="S")
	{
		$Dir = 'archivos/clientes';
		$ArchivoElim = $Dir."/".$ArchivoElim;
		if (file_exists($ArchivoElim))
			unlink($ArchivoElim);
		header('location:fac_sube_clientes.php');	
	}
?>
<html>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<title>Subir Archivos Clientes</title>
<style type="text/css">
.text1 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #CCCCCC}
<head>


.text2 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #999999}
.titre1 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #FFFFFF}

body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
<script language="javascript">
function Salir()
{
	var f = document.frmDescarga;
	f.action="../principal/sistemas_usuario.php?CodSistema=11";
	f.submit();
}
function Generar()
{
	var f=document.frmDescarga;
	f.action="fac_sube_clientes01.php";
	f.submit();
}
function DelFile(arch)
{
	var f=document.frmDescarga;
	var msg=confirm("¿Desea Eliminar este Archivo?");
	if (msg==true)
	{
		f.action="fac_sube_clientes.php?Elim=S&ArchivoElim="+arch;
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
<input type="hidden" name="Proceso" value="<? echo $Proceso; ?>">
<input type="hidden" name="Tipo" value="<? echo $Tipo; ?>">
<table width="550" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
	<tr align="center"> 
		<td colspan="5" valign="top" nowrap class="Detalle03"><strong>Archivos Existentes</strong></td>
	</tr>
	<tr align="center" class="ColorTabla01">
	  <td width="6%" valign="top">Elim</td>
      <td width="51%" valign="top">Archivo</td>
      <td width="18%" valign="top">Fecha</td>
      <td width="14%" valign="top">Tama&ntilde;o(Kb)</td>
  </tr>
<?
$ArrArchivos = array();
$Dir = 'archivos/clientes';
$Directorio=opendir($Dir);
$i=0;
while ($Archivo = readdir($Directorio)) 
{
	if($Archivo != '..' && $Archivo !='.' && $Archivo !='')
	{ 		
		$FechaHora = date("d-m-Y H:i:s", filemtime($Dir."/".$Archivo));
		$Peso = filesize($Dir."/".$Archivo);
		$ArrArchivo[$i][0] = $Archivo;
		$ArrArchivo[$i][1] = $FechaHora;
		$ArrArchivo[$i][2] = $Peso;
	}
	$i++;
}
closedir($Directorio);
if (count($ArrArchivo)>0)
{
	reset($ArrArchivo);
	krsort($ArrArchivo);
	while (list($k,$v)=each($ArrArchivo))
	{
			echo "<tr>\n";
			echo "<td align='center'><a href=\"JavaScript:DelFile('".$v[0]."')\"><img src=\"../principal/imagenes/ico_borrado.gif\" border='0'></a></td>\n";
			echo "<td><img src=\"../principal/imagenes/img_listado.gif\" border='0' align='absmiddle'>&nbsp;".$v[0]."</td>\n";
			echo "<td align='center'>".$v[1]."</td>\n";
			echo "<td align='right'>".number_format($v[2]/1000,3,",",".")."</td>\n";
			echo "</tr>\n";
	}
}
clearstatcache();
?>
<tr align="center"> 
	<td colspan="5" valign="top" nowrap class="Detalle01">
	<input type="button" name="BtnSubirClientes" value="Generar Clientes" size="15px" onClick="Generar()"> 
	<input type="button" name="BtnSalir" value="Salir" size="15px"  onClick="Salir()">
	</td>
</tr>

</table>
</form>
<br>
</body>
</html>
<?
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje')";
	echo "</script>";
	header('location:fac_sube_clientes.php');
}
?>