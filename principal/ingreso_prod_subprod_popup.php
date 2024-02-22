<?php
	include("../principal/conectar_principal.php");	
	if(isset($_GET["Valores"])){
		$Valores = $_GET["Valores"];
	}else{
		$Valores = "";
	}
?>
<html>
<head>
<title>Detalle SubProducto</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opc,Valores,Valor)
{	
	var f = document.FrmDetallePopUp;
	var linea='';
	
	switch (opc) 
	{
		case 'C':
			linea = "Proceso=MS&Valores=" + Valores + "&cod_subproducto=" + Valor;
			window.opener.document.FrmProceso.action = "ingreso_prod_subprod_proceso2.php?" + linea;
			window.opener.document.FrmProceso.submit();
			window.close();
			break;
		case 'S':
			window.close();
			break;		
	}	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmDetallePopUp" action="" method="post">
<input name="nodo" type="hidden" value="<?php echo $nodo ?>">
<input name="sistema" type="hidden" value="<?php echo $sistema ?>">
  <table width="504" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td width="495" colspan="2">SubProductos Asociados</td>
    </tr>
  </table>
  <br>
  <table width="504" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="20" height="20" align="center">&nbsp;</td>
      <td width="92" align="center">Cod_Subproducto</td>
      <td width="177" align="center">Descripcion</td>
	  <td width="82" align="center">Abreviatura</td>
	  <td width="120" align="center">Rut Proveedor</td>
    </tr>
<?php
	$Datos=explode('//',$Valores);
	$TxtCodigo=$Datos[0];
	$consulta = "SELECT * FROM proyecto_modernizacion.subproducto";
	$consulta.= " WHERE cod_producto='$TxtCodigo'";
	$consulta.= " ORDER BY cod_subproducto";
	$rs = mysqli_query($link, $consulta);
	while($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
      	echo '<td align="left"><input type="radio" name="radio" onClick="Proceso(\'C\',\''.$Valores.'\', \''.$row["cod_subproducto"].'\')"></td>';
      	echo '<td align="right">'.$row["cod_subproducto"].'</td>';
      	echo '<td align="left">&nbsp;'.$row["descripcion"].'</td>';
		echo '<td align="left">&nbsp;'.$row["abreviatura"].'</td>';
		echo '<td align="left">&nbsp;'.$row["rut_prov"].'</td>';
    	echo '</tr>';
	}
?>
  </table>
  <br>
  <table width="450" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr>
      <td align="center"><input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width=80" onClick="Proceso('S', '','')"></td>
    </tr>
  </table>
</form>
</body>
</html>
