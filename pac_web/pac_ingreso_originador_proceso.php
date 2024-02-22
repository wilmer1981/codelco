<?php 	
	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_pac_web.php");

	switch($Proceso)
	{
		case "N":
			break;
		case "M": 
			$Cod_Ori=$Valores;
			/*echo $Cod_Ori;*/
			for ($i=0;$i<=strlen($Cod_Ori);$i++)

			$Consulta="select * from pac_web.pac_originador where cod_originador='".$Cod_Ori."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Rut=substr($Fila["rut"], 0,-2);
			$Dv=substr($Fila["rut"], -1);

			$Nombre=$Fila["nombre"];
			$Lugar=$Fila["lugar"];
			$DivSap=$Fila["div_sap"];
			$AlmSap=$Fila["almacen_sap"];
			
			$Estado="";
			if($Fila["activo"]==1)
				$Estado="checked";

			break;	
	}	

?>
<html>
<head>
<script language="JavaScript">



function Grabar(Proceso)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtRut.value == "")
	{
		alert("Debe Ingresar el rut")
		Frm.TxtRut.focus();
		return;
	}	
	if (Frm.TxtNombre.value == "")
	{
		alert("Debe Ingresar Nombre")
		Frm.TxtNombre.focus();
		return;
	}
	
	if (Frm.TxtLugar.value == "")
	{
		alert("Debe Ingresar Lugar")
		Frm.TxtLugar.focus();
		return;
	}

	if (Frm.TxtDivSap.value == "")
	{
		alert("Debe Ingresar División SAP")
		Frm.TxtDivSap.focus();
		return;
	}

	if (Frm.TxtAlmSap.value == "")
	{
		alert("Debe Ingresar Almacén SAP")
		Frm.TxtAlmSap.focus();
		return;
	}
	
	if (Frm.CheckEst.checked == true)
	{
		Frm.CheckEst.value=1;
	}
	else
	{
		Frm.CheckEst.value=0;
	}
	Frm.action="pac_ingreso_originador_proceso01.php?Proceso="+Proceso+"&TxtRut="+Frm.TxtRut.value+"&TxtDv="+Frm.TxtDv.value;
	Frm.submit();
	
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Proceso=='N')
	{
		echo "<body onload='document.FrmProceso.TxtRut.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		echo "<body onload='document.FrmProceso.TxtNombre.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td>
            	<input type="hidden" name="cod_originador" id="cod_originador" value="<?php echo $Cod_Ori; ?>">Rut</td>
            <td> 
            	<input type='text' name='TxtRut' id='TxtRut' value='<?php echo $Rut;?>' style='width:80' maxlength='8'>&nbsp;-&nbsp;<input type='text' name ='TxtDv' id ='TxtDv' style='width:20' maxlength='2' value='<?php echo $Dv;?>'>
           <span class=" InputRojo">(*)</span> </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input type="text" name="TxtNombre" id="TxtNombre" style="width:200" maxlength="40" value="<?php echo $Nombre; ?>"><span class=" InputRojo">(*)</span></td>
          </tr>
            <td>Lugar</td>
            <td><input type="text" name="TxtLugar" id="TxtLugar" style="width:200" maxlength="50" value="<?php echo $Lugar;?>"><span class=" InputRojo">(*)</span></td>
          </tr>
            <td>Divisi&oacute;n SAP</td>
            <td><input type="text" name="TxtDivSap" id="TxtDivSap" style="width:70" maxlength="4" value="<?php echo $DivSap;?>"><span class=" InputRojo">(*)</span></td>
          </tr>
            <td>Almac&eacute;n SAP </td>
            <td><input type="text" name="TxtAlmSap" id="TxtAlmSap" style="width:70" maxlength="6" value="<?php echo $AlmSap;?>"><span class=" InputRojo">(*)</span></td>
          </tr>
          <tr> 
            <td>Estado</td>
            <td align='left'>
           <input type='checkbox' name='CheckEst' <?php echo $Estado; ?> value="0" ></td>
          </tr>
        </table>
        <br>
        <table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
