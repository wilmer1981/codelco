<?php 	
	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_pac_web.php");
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";


	$Nombre     = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$Cod_Unidad = isset($_REQUEST["cod_unidad"])?$_REQUEST["cod_unidad"]:"";
	$Cod_sap    = isset($_REQUEST["TxtCodSap"])?$_REQUEST["TxtCodSap"]:"";	
	$Estado     = isset($_REQUEST["CheckEst"])?$_REQUEST["CheckEst"]:"";

	switch($Proceso)
	{
		case "N":
			break;
		case "M": 
			$Cod_Unidad=$Valores;
			for ($i=0;$i<=strlen($Cod_Unidad);$i++)

			$Consulta="select * from pac_web.pac_unidades_medida where cod_unidad='".$Cod_Unidad."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Cod_sap=$Fila["cod_sap"];
			$Nombre=$Fila["nombre"];
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
	
	if (Frm.TxtCodSap.value == "")
	{
		alert("Debe Ingresar el C&oacute;digo SAP")
		Frm.TxtCodSap.focus();
		return;
	}	
	if (Frm.TxtNombre.value == "")
	{
		alert("Debe Ingresar Nombre")
		Frm.TxtNombre.focus();
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
	Frm.action="pac_ingreso_unidades_medida_proceso01.php?Proceso="+Proceso;
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
		echo "<body onload='document.FrmProceso.TxtCodSap.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
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
            <td width="90" >
            	<input type="hidden" name="cod_unidad" id="cod_unidad" value="<?php echo $Cod_Unidad; ?>">C&oacute;digo SAP</td>
            <td width="276" > 
            	<input type='text' name='TxtCodSap'  value='<?php echo $Cod_sap;?>' style='width:80' maxlength='18'><span class=" InputRojo">(*)</span>
            </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input type="text" name="TxtNombre" id="TxtNombre" style="width:80" align='left' maxlength="4" value="<?php echo $Nombre; ?>"><span class=" InputRojo">(*)</span>
            </td>
          </tr>
          <tr> 
            <td>Estado</td>
            <td align='left'>
           <input type='checkbox' name='CheckEst' <?php echo $Estado; ?> value="0" >
       	   </td>
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
