<html>
<head>
<script language="JavaScript">
function Proceso(TipoSA,CmbProductos,Producto)
{
	var Frm=document.FrmIngresoSubProducto;
	if (Frm.TxtOpcion.value=="")
	{
		alert("Debe Ingresar SubProducto");
		Frm.TxtOpcion.focus();
		return;
	}
	Frm.action = "cal_ingreso_subproducto01.php?TipoSA=" + TipoSA + "&CmbProductos=" + CmbProductos + "&Producto=" + Producto;
	Frm.submit();	

}
</script>
<title>Ingreso de Sub-Producto</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
</head>
<body background="../principal/imagenes/fondo3.gif" >
<form name="FrmIngresoSubProducto" method="post" action="">
  <table width="463" border="0" cellpadding="5" class="TablaPrincipal">
    <tr> 
      <td width="449"><br>
        <table width="442" border="0">
          <tr> 
            <td colspan="2"><strong>Tipo Producto:</strong>&nbsp; 
              <?php echo $Producto;?>
            </td>
          </tr>
          <tr> 
            <td width="206">&nbsp;</td>
            <td width="226">&nbsp;</td>
          </tr>
          <tr> 
            <td height="18"> <input type="radio" name="Opcion" value="radiobutton">
              Proceso </td>
            <td><input type="radio" name="Opcion" value="radiobutton" checked>
              Proveedor</td>
          </tr>
          <tr> 
            <td colspan="2" align="left">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2" align="left"><strong>Tipo SubProducto:</strong>&nbsp; <input type="text" name="TxtOpcion" maxlength="30" style="width:200"></td>
          </tr>
          <tr> 
            <td>&nbsp; </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td align="center" colspan="2"><input type="button" name="BtnOk" value="Ok" style="width:60" onClick="Proceso('<?php echo $TipoSA;?>','<?php echo $CmbProductos;?>','<?php echo $Producto;?>');"> 
              &nbsp; <input type="button" name="BtnSalir" style="width:60" value="Salir" onClick="javascript:window.close();"></td>
          </tr>
        </table> </td>
    </tr>
  </table>
</form>
</body>
</html>
