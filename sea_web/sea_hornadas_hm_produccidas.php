<?php include("../principal/conectar_sea_web.php") ?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaSeleccion(f)
{
	for (i=1; i < f.radio.length; i++)
	{
		if (f.radio[i].checked == true)
			return f.radio[i].value;		
	}
}
/******************/
function Enviar(f)
{
	var valor = ValidaSeleccion(f);
	
	//window.opener.document.frmPrincipal.txtlote.disabled = false;
	//window.opener.document.frmPrincipal.txtlote.value = valor;	
	var	linea = f.fecha.value + '?'  + f.cmbgrupo.value + '?' + valor;  

	window.opener.document.frmProduccion.submit();
	window.opener.document.frmProduccion.action = "sea_ing_prod_restos_anodos_hm.php?modificar=S&fecha=" + f.fecha.value + "&cmbgrupo="  + f.cmbgrupo.value + "&hornada2=" + valor;
	window.opener.document.frmProduccion.submit();
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frm1" action="" method="post">

<div style="position:absolute; left: 25px; top: 30px;" id="div1">
<table width="450" border="1" cellspacing="0" cellpadding="0" class="TituloTabla">
  <tr>
      <td height="20" align="center">Hornadas Producidas</td>
  </tr>
</table>
</div>
<div style="position:absolute; left: 25px; top: 68px; width: 452px; height: 25px;" id="div2">
<table width="450" border="1" cellspacing="0" cellpadding="0" class="ColorTabla01">
  <tr>
      <td width="150" height="20" align="center">Hornada</td>
      <td width="150" align="center">Unidades</td>
      <td width="150" align="center">Peso</td>
  </tr>
</table>
</div>
<?php
	//Campo ocultos.
	echo '<input name="cmbgrupo" type="hidden" value="'.$cmbgrupo.'">';
	echo '<input name="fecha" type="hidden" value="'.$fecha.'">';
?>


<div style="position:absolute; left: 25px; top: 88px; width: 453px; height: 84px;" id="div3">
<table width="450" border="1" cellspacing="0" cellpadding="0" class="ColorTabla02">
<?php
	echo '<input name="radio" type="hidden">';
	
	$consulta = "SELECT DISTINCT t1.hornada,t2.unidades,t2.peso_unidades FROM sea_web.movimientos AS t1";
	$consulta = $consulta." INNER JOIN sea_web.hornadas AS t2";
	$consulta = $consulta." ON t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
	$consulta = $consulta." AND t1.hornada = t2.hornada_ventana";
	$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha."' AND campo1 NOT IN ('M','T')";
	$consulta = $consulta." AND campo2 = '".$cmbgrupo."'";
//echo "CC".$consulta;
	$rs = mysqli_query($link, $consulta);	
		
	while ($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';		
    	echo '<td width="150" height="20" align="left">';
		echo '<input name="radio" type="radio" value="'.$row[hornada].'" onClick="Enviar(this.form)">'.substr($row[hornada],6,6).'</td>';
	    echo '<td width="150" align="center">'.$row["unidades"].'</td>';
    	echo '<td width="150" align="center">'.$row[peso_unidades].'</td>';
	  	echo '</tr>';
	}
?>
</table>
</div>

<div style="position:absolute; left: 25px; top: 198px; width: 451px; height: 30px;" id="div4">
<table width="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td align="center">
		<input name="btnsalit" type="button" value="Salir" style="width=60" onClick="self.close()"></td>
  </tr>  
</table>
</div>

</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>