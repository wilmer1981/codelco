<? include("../principal/conectar_sget_web.php");
if(isset($CmbMutuales))
{
	if($CmbMutuales=='-1')
	{
		$Opc='N';
	}
	else
	{
		$Opc='M';
		$Valores=$CmbMutuales;
	}
}
if ($Opc=='M')
{
	$Consulta="SELECT * from sget_mutuales_seg ";
	$Consulta.=" where cod_mutual='".$Valores."' ";
	
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["cod_mutual"];
		$TxtDescripcion=$Fila["descripcion"];
		$TxtAbreviatura=$Fila["abreviatura"];
		$CmbEstado=$Fila["estado"];
	}
}
else
{
	$Consulta="SELECT max(cod_mutual+1) as maximo from sget_mutuales_seg ";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["maximo"];
	}
}
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nueva Mutual</title>";
		else	
			echo "<title>Modifica Mutual</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sgp_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				f.action = "sget_mantenedor_mutuales01.php?Opcion="+Opcion+"&Descri="+f.TxtDescripcion.value;
				f.submit();
			}
		break;
		case "M":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				f.action = "sget_mantenedor_mutuales01.php?Opcion="+Opcion+"&Codigo="+f.TxtCodigo.value+"&Descri="+f.TxtDescripcion.value;
				f.submit();
			}
		break;
	}
}
function Salir()
{
	window.close();
}
function ValidaCampos(Res,Opcion)
{
	var f= document.FrmPopupProceso;
	if (f.TxtDescripcion.value=="")
	{
		alert("Debe Ingresar Descripcion");
		f.TxtDescripcion.focus();
		Res=false;
		return;
	}
	if (f.TxtAbreviatura.value=="")
	{
		alert("Debe Ingresar Abreviatura");
		f.TxtAbreviatura.focus();
		Res=false;
		return;
	}

	if(f.CmbEstado.value=='-1')
	{
		alert("Debe Seleccionar Estado");
		return;
	}
	return(Res);
}
</script>
</head>
<?
if ($Opc=='N')
	echo '<body onLoad="document.FrmPopupProceso.TxtDescripcion.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.TxtDescripcion.focus();">';
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<input type="hidden" name="Volver" value="<? echo $Volver;?>">
<input type="hidden" name="TxtCodigo" value="<? echo $TxtCodigo;?>">
  <table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="818" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="74%" align="left"><?	if($Opc=='N'){?><img src="archivos/sub_tit_mutual_n.png"><? }else{?><img src="archivos/sub_tit_mutual_m.png"><?	}?></td>
    <td align="right">
	<a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>
	<a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a>
	</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="3"align="center" class="TituloTablaVerde"></td>
  </tr>
  <tr>
    <td width="1%" align="center" class="TituloTablaVerde"></td>
    <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td width="111" class="formulario2">Descripci&oacute;n</td>
        <td width="382" class="formulariosimple" ><input name="TxtDescripcion" maxlength= "50" type="text" id="TxtDescripcion" style="width:350" value="<? echo $TxtDescripcion; ?>" >
        <span class="InputRojo">(*)</span></td>
      </tr>
      <tr>
        <td width="111" class="formulario2">Abreviatura</td>
        <td class="formulariosimple" ><input name="TxtAbreviatura" type="text"  style="width:50" value="<? echo $TxtAbreviatura; ?>" maxlength="10" > <span class="InputRojo">(*)</span></td>
      </tr>
      <tr>
        <td class="formulario2">Estado</td>
        <td class="formulariosimple" ><SELECT name="CmbEstado" >
            <option value="-1" class="NoSelec">Seleccionar</option>
            <?
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEstado==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
        </SELECT> <span class="InputRojo">(*)</span></td>
      </tr>
      <tr>
        <td colspan="2" class="formulario2"> <span class="InputRojo">(*) Datos Obligatorios</span></td>
        </tr>
    </table></td>
    <td width="0%" align="center" class="TituloTablaVerde"></td>
  </tr>
  <tr>
    <td colspan="3"align="center" class="TituloTablaVerde"></td>
  </tr>
</table>
	  </td>

  <td width="16" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="16" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>			
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==true)
		echo "alert('Este Registro ya Existe');";
	echo "</script>";
?>