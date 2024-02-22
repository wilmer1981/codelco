<? include("../principal/conectar_principal.php");?>
<html>
<head>
<title>Agrega Detalle</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript">
function Recarga()
{
	var f=document.frmPopUp;
	f.action="cia_inst_equipos_agrega_det.php";
	f.submit();
}
function Salir()
{
	var f=document.frmPopUp;
	window.opener.document.frmPrincipal.action="cia_inst_equipos.php?TxtCodEquipo="+f.CodEquipo.value;
	window.opener.document.frmPrincipal.submit();
	window.close();
}
function AgregaDetalle()
{
	var f=document.frmPopUp;
	f.action="cia_inst_equipos01.php?Proceso=AD";
	f.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmPopUp" action="" method="post">
<input type="hidden" name="CodEquipo" value="<? echo $CodEquipo; ?>">
<table width="380" height="180" border="0" align="center" cellpadding="5" cellspacing="5" class="TablaPrincipal">
  <tr>
    <td valign="top"><table width="350" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaInterior">
      <tr align="center">
        <td colspan="2"><input name="BtnAgregar" type="button" id="BtnAgregar2" value="Agregar" onClick="AgregaDetalle()" style="width:70px ">
          <input name="BtnCerrar}" type="button" id="BtnAgregar" value="Cerrar" onClick="Salir()" style="width:70px ">
            </td>
      </tr>
      <tr align="center" class="ColorTabla01">
        <td width="79">&nbsp;</td>
        <td width="306">ITEM</td>
      </tr>
      <tr>
        <td width="79">Item:</td>
        <td width="306"><select name="CmbClase" id="select2" onChange="Recarga()">
            <option value="S">SELECCIONAR</option>
            <?
	$Consulta = "select * from proyecto_modernizacion.clase where cod_clase between '18900' and '18999' order by lpad(cod_clase,4,'0')";
	$Resp = mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($CmbClase==$Fila["cod_clase"])
			echo "<option selected value='".$Fila["cod_clase"]."'>".$Fila["nombre_clase"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_clase"]."'>".$Fila["nombre_clase"]."</option>\n";
		
	}
?>
        </select></td>
      </tr>
      <tr>
        <td>Valor 1:</td>
        <td><select name="CmbSubClase" onChange="Recarga()">
            <option value="S">SELECCIONAR</option>
            <?
	$Consulta = "select distinct nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='".$CmbClase."' order by lpad(nombre_subclase,4,'0')";
	$Resp = mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($CmbSubClase==$Fila["nombre_subclase"])
			echo "<option selected value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		else
			echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		
	}
?>
        </select></td>
      </tr>
      <tr>
        <td>Valor 2 :</td>
        <td><select name="CmbModelo">
            <option value="S">SELECCIONAR</option>
            <?
	$Consulta = "select distinct cod_subclase, valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='".$CmbClase."' and nombre_subclase='".$CmbSubClase."' order by valor_subclase1 ";
	$Resp = mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($CmbModelo==$Fila["cod_subclase"])
			echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
		
	}
?>
        </select></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
