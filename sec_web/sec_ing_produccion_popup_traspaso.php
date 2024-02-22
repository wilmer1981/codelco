<?php	include("../principal/conectar_sec_web.php"); ?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Grabar()
{	
	var f = document.frmPopUp;	
	
	f.action = "sec_ing_produccion01.php?proceso=T";
	f.submit();
}
/***************/
function Chequear(r)
{
	window.opener.document.frm1.txtlote.value = r.value;
	window.opener.document.frm1.action = "sec_ing_produccion01.php?proceso=B2";
	window.opener.document.frm1.submit();	
	window.close();
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
        <td align="center">Traspaso de Paquetes</td>
  </tr>
</table>
</div>

 
  <?php 
	$fecha = $ano.'-'.$mes.'-'.$dia;
	
	echo '<div style="position:absolute; left: 15px; top: 50px; width:518px; height:200px; OVERFLOW: auto;" id="div2">';
	echo '<table width="500" height="25" border="1" cellspacing="0" cellpadding="0">';
	echo '<tr>';
	echo '<td width="125" align="center">Cod. Paqute</td>';
	echo '<td width="125" align="center">Num. Paquete</td>';
	echo '<td width="125" align="center">Peso</td>';
	echo '<td width="125" align="center">Fecha Creacion</td>';
	echo '</tr>';	 
	echo '</table>';
	echo '</div>';

	echo '<div style="position:absolute; left: 15px; top: 70px; width:518px; height:200px; OVERFLOW: auto;" id="div5">';
	echo '<table width="500" height="25" border="1" height="25" cellspacing="0" cellpadding="0">';

	$consulta = "SELECT * FROM sec_web.paquete_catodo_externo";
	$consulta.= " WHERE cod_estado = 'p'";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	$i = 0;
	while ($row = mysqli_fetch_array($rs))
	{
		
		echo '<tr>';
		echo '<td width="125"><input type="checkbox" name="checkbox['.$i.']">'.$row["cod_paquete"].'</td>';
		echo '<td width="125" align="center">'.$row["num_paquete"].'</td>';
		echo '<td width="125" align="center">'.$row[peso_paquete].'</td>';
		echo '<td width="125" align="center">'.$row[fecha_creacion_paquete].'</td>';

		echo '<input type="hidden" name="cod_paquete['.$i.']" value="'.$row["cod_paquete"].'">';
		echo '<input type="hidden" name="num_paquete['.$i.']" value="'.$row["num_paquete"].'">';
		echo '<input type="hidden" name="fecha_creacion['.$i.']" value="'.$row[fecha_creacion_paquete].'">';
		
		echo '</tr>';	
		$i++;					
	}
	
	echo '</table>';
	echo '</div>';
?>
  <br>

<div style="position:absolute; left: 15px; top: 310px;" id="div5">
<table width="501" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td width="491" align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="Grabar()">
          <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>