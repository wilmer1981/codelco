<?
	if ($Elim=="S")
	{
		$Dir = '../met_web/archivos/';
		$ArchivoElimi = $Dir."/".$ArchivoElim;
		if (unlink($Dir.$ArchivoElim))
		{
		echo "Archivo eliminado";
		}
		 else
		 {
		 	echo "El archivo no ha sido eliminado";
		 }
		//header('location:leerarchivos.php');	
	}
?>
<html>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<title>Subir Archivos Clientes</title>
<style type="text/css">
.text1 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #CCCCCC}
.text2 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #999999}
.titre1 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #FFFFFF}

body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
<head>
<script language="javascript">
function Salir()
{
	var f = document.frmDescarga;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=1';
	f.submit();
}
function Generar()
{
	var f=document.frmDescarga;
	var Nombre='';

	for(i=0;i<=f.rbarchivo.length;i++)
	{
		if(f.rbarchivo[i].checked==true)
		{
			Nombre=f.rbarchivo[i].value;
			break;
		}	
	}
	f.action="ingresobd.php?NombreArch="+Nombre+"&Valor="+f.select1.value;
	f.submit();
}

function DelFile(arch)
{
	var f=document.frmDescarga;
	var msg=confirm("¿Desea Eliminar este Archivo?");
	if (msg==true)
	{
		f.action="leerarchivos.php?Elim=S&ArchivoElim="+arch;
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
<table width="173" border="1" class="TablaDetalle">
    <tr>
      <td height="40">Tabla a la que sera ingresada </td>
      <td><select name="select1">
        <option value="enabal_base" selected>Fundicion</option>
        <option value="enabalpmn_base">PMN</option>
      </select></td>
    </tr>
  </table>
  <table width="579" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
	<tr align="center"> 
		<td colspan="6" valign="top" nowrap class="Detalle03"><strong>Archivos Existentes</strong></td>
	</tr>
	<tr align="center" class="ColorTabla01">
	  <td valign="top">Seleccionar</td>
	  <td width="15%" valign="top">Elim</td>
      <td width="47%" valign="top">Archivo</td>
      <td width="21%" valign="top">Fecha</td>
      <td width="17%" valign="top">Tama&ntilde;o(Kb)</td>
  </tr>
<?
$ArrArchivos = array();
$Dir = '../met_web/archivos/';
$Directorio=opendir($Dir);
$i=0;
while ($Archivo = readdir($Directorio)) 
{
	if($Archivo != '..' && $Archivo !='.' && $Archivo !='')
	{ 		
		$FechaHora = date("d-m-Y", filemtime($Dir."/".$Archivo));
		$Peso = filesize($Dir."/".$Archivo);
		$ArrArchivo[$i][0] = $Archivo;
		$ArrArchivo[$i][1] = $FechaHora;
		$ArrArchivo[$i][2] = $Peso;
		$ArrArchivo[$i][3] = $CheckBox;
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
	$i=0;
			echo "<tr>\n";
			echo "<td><input name='rbarchivo' type='radio' value='$v[0]'>".$v[3]."</td>";		
			echo "<td align='center'><a href=\"JavaScript:DelFile('".$v[0]."')\"><img src=\"../principal/imagenes/ico_borrado.gif\" border='0'></a></td>\n";
			echo "<td><img src=\"../principal/imagenes/img_listado.gif\" border='0' align='absmiddle'>&nbsp;".$v[0]."</td>\n";
			echo "<td align='center'>".$v[1]."</td>\n";
			echo "<td align='right'>".number_format($v[2]/1000,3,",",".")."</td>\n";
			echo "</tr>\n";
			$i=$i+1;
	}
}
clearstatcache();
?>
<tr align="center"> 
	<td colspan="6" valign="top" nowrap class="Detalle01">
	<input type="button" name="BtnSubirClientes" value="Ingresar Datos" size="15px" onClick="Generar()"> 
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
	//header('location:leerarchivos.php');
}
?>