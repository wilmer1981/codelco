<?php	include("../principal/conectar_sec_web.php"); ?>

<?php ---------    NO SE OCUPA  ---------- ?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Buscar1()
{	
	var f = document.frmPopUp;	
	
	f.action = "sec_ing_produccion_popup1.php?mostrar=S";
	f.submit();
}
/***************/
function Chequear(r)
{
	//window.opener.document.frm1.txtlote.value = r.value;
	window.opener.document.frm1.action = "sec_ing_produccion01.php?proceso=B3&parametros=" + r.value;
	window.opener.document.frm1.submit();	
	window.close();
}
/***************/
function Atras()
{	
	window.history.back();
}
/***************/
function Salir()
{	
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frmPopUp" action="" method="post">
<div style="position:absolute; left: 15px; top: 15px;" id="div0">
<table width="500" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
      <td align="center">Datos de Recepcion Paquetes</td>
  </tr>
</table>
</div>

<?php 

	$fecha = $ano.'-'.$mes.'-'.$dia;
	
	echo '<div style="position:absolute; left: 15px; top: 50px; width:518px; height:200px; id="div2">';	
	echo '<table width="500" height="25" border="1" cellspacing="0" cellpadding="0">';
	echo '<tr>';
	echo '<td width="100" align="center">Cod. Paquete</td>';
	echo '<td width="100" align="center">N° Paquete</td>';
	echo '<td width="100" align="center">Unidades</td>';
	echo '<td width="100" align="center">Peso</td>';
	echo '<td width="100" align="center">Estado</td>';
	echo '</tr>';	
	echo '</table>';
	echo '</div>';	

	echo '<div style="position:absolute; left: 15px; top: 70px; width:518px; height:223px; OVERFLOW: auto;" id="div5">';
	echo '<table width="500" border="1" height="25" cellspacing="0" cellpadding="0">';

	$total_unidades = 0;
	$total_peso = 0;
	$consulta = "SELECT * FROM sec_web.paquete_catodo_externo";
	$consulta.= " WHERE lote_origen = '".$lote."'";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
		echo '<td width="100"  height="20"><input type="radio" name="radiobutton" value="'.$row[lote_origen].'/'.$row["cod_paquete"].'/'.$row["num_paquete"].'/'.$row[fecha_creacion_paquete].'" onClick="Chequear(this)">'.$row["cod_paquete"].'</a></td>';
		echo '<td width="100">'.$row["num_paquete"].'</td>';
		echo '<td width="100">'.$row["num_unidades"].'</td>';
		echo '<td width="100">'.$row[peso_paquete].'</td>';
		echo '<td width="100">'.$row[fecha_creacion_paquete].'</td>';		
		echo '</tr>';
		$total_unidades = $total_unidades + $row["num_unidades"];
		$total_peso = $total_peso + $row[peso_paquete];		
	}
	echo '<tr>';
	echo '<td width="100" height="20">Total</td>';
	echo '<td width="100">&nbsp;</td>';
	echo '<td width="100">'.$total_unidades.'</td>';
	echo '<td width="100">'.$total_peso.'</td>';	
	echo '<td width="100">&nbsp;</td>';	
	echo '</tr>';	
		
	echo '</table>';
	echo '</div>';	
?>

<div style="position:absolute; left: 15px; top: 310px;" id="div5">
<table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td align="center"><input name="btnatras" type="button" style="width:70" value="Atras" onClick="Atras()">
        <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>