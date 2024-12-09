<?php
	include("../principal/conectar_sec_web.php");
  $Rut = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:"";
?>
<html>
<head>
<title>Sub-Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script language="JavaScript">
function Salir()
{
	window.close();
	
}
</script>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body background='../principal/imagenes/fondo3.gif'>
<form name="form1" method="post" action="">
  <table width="600" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
  <?php
	$Consulta = "SELECT * FROM sec_web.cliente_venta WHERE rut = '$Rut'";
	$rs = mysqli_query($link, $Consulta);	 
	$row = mysqli_fetch_array($rs);
    echo'<tr>';
      echo'<td width="30%"><strong>RUT CLIENTE</strong></td>';
      echo'<td>&nbsp;'.$row["rut"].'</td>';
    echo'</tr>';
    echo'<tr>';
      echo'<td><strong>CLIENTE</strong></td>';
      echo'<td>&nbsp;'.$row["nombre_cliente"].'</td>';
    echo'</tr>';
    echo'<tr>';
      echo'<td align="center" colspan="2"><input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();"></td>';
    echo'</tr>';
  ?>	
  </table>
  <br> 	
  <table width="600" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr>
      <td align="center" colspan="7"><strong>SubClientes Asociados</strong></td>
    </tr>
    <tr class="ColorTabla01">
      <td width="97" align="center">Cod SubCliente</td>
      <td width="174" align="center">Direcci&oacute;n</td>
      <td width="70" align="center">Ciudad</td>
      <td width="67" align="center">Comuna</td>
      <td width="55" align="center">Regi&oacute;n</td>
      <td width="58" align="center">Fono</td>
      <td width="62" align="center">Celular</td>
    </tr>
	 <?php
	 	$Consulta = "SELECT * FROM sec_web.sub_cliente_vta WHERE rut_cliente = '$Rut'"; 
		$rs = mysqli_query($link, $Consulta);
		while($Fila = mysqli_fetch_array($rs))
		{		
			echo'<tr>';
			  echo'<td align="center">'.$Fila["cod_sub_cliente"].'&nbsp;</td>';
			  echo'<td>'.$Fila["direccion"].'&nbsp;</td>';
			  echo'<td align="center">'.$Fila["ciudad"].'&nbsp;</td>';
			  echo'<td>'.$Fila["comuna"].'&nbsp;</td>';
			  echo'<td align="center">'.$Fila["region"].'&nbsp;</td>';
			  echo'<td align="center">'.$Fila["fono"].'&nbsp;</td>';
			  echo'<td align="center">'.$Fila["celular"].'&nbsp;</td>';
			echo'</tr>';
		}	
	 ?>
  </table>
</form>
</body>
</html>
 