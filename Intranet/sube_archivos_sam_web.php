<?
$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<html>
<head>
<link href="js/style.css" rel=stylesheet>
<title>Atachar Documento</title>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	switch(Opcion)
	{
		case "G":
			if(f.Archivo.value=='')
			{
				alert('Debe Seleccionar Documento')
				f.file.focus();
				return;
			}
			f.action='sube_archivos_sam_web01.php';
			f.submit();
			break;
		case "S":
			window.close();
			break;
	}
}
</script>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data" name="FrmPopupProceso">
  <table width="441" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaPrincipal">
    <tr>
      <td colspan="2" class="titulo_codelco_informa">Atachar Documentos (Archivos) </td>
    </tr>
    <tr>
      <td width="73" align="right" class="titulo_azul_codelco_informa">A&ntilde;o:</td>
      <td width="357" class="BordeBajo">
      <select name="CmbAno" class="BordeInf" id="Ano" onChange="Proceso('R')">
        <?
	for ($i=date("Y")-1;$i<=date("Y");$i++)
	{
		if (isset($CmbAno))
		{
			if ($i==$CmbAno)
				echo "<option selected value='".$i."'>".$i."</option>";
			else
				echo "<option value='".$i."'>".$i."</option>";
		}
		else
		{
			if ($i==date("Y"))
				echo "<option selected value='".$i."'>".$i."</option>";
			else
				echo "<option value='".$i."'>".$i."</option>";
		}
	}
?>
      </select></td>
    </tr>
    <tr>
      <td align="right" class="titulo_azul_codelco_informa">Mes:</td>
      <td class="BordeBajo">
	  <select name="CmbMes" class="BordeInf" id="Mes" onChange="Proceso('R')">
        <?
	for ($i=1;$i<=12;$i++)
	{
		if (isset($CmbMes))
		{
			if ($i==$CmbMes)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
		}
		else
		{
			if ($i==date("n"))
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
		}
	}
?>
      </select>
	  </td>
    </tr>
   <tr>
      <td align="right" class="titulo_azul_codelco_informa">Documento:</td>
      <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
      <td class="BordeBajo">
        <input name="Archivo" type="file" class="BordeInf" id="Archivo" size="50">
      </td>
    </tr>
    <tr align="center">
      <td colspan="2" class="BordeInf">
	  <input name="BtnAceptar" type="button" value="Aceptar" onClick="JavaScript:Proceso('G')" style="width:80px ">
	  <input name="BtnSalir" type="button" value="Salir" onClick="JavaScript:Proceso('S')" style="width:80px ">	  </td>
    </tr>
      <tr bgcolor="#efefef">
        <td colspan="2" valign="top" class="BordeBajo">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje!="")
		echo "alert('".$Mensaje."');";
	echo "</script>";
?>