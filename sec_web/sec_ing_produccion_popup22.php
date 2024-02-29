<?php	include("../principal/conectar_sec_web.php"); ?>
<html>
<head>
<title>Datos de Producci&oacute;n</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Buscar1()
{	
	var f = document.frmPopUp;	
	
	f.action = "sec_ing_produccion_popup222.php?mostrar=S";
	f.submit();
}
/***************/
function Chequear(r)
{
	
	var f = document.frmPopUp;
	//window.opener.document.frm1.txtlote.value = r.value;

	window.opener.document.frm1.action = "sec_ing_produccion01.php?proceso=B4&parametros=" + r.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
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
function Modificar(Valores)
{
	var Frm=document.frmPopUp;

	//alert(Valores);
	if (Frm.TxtPeso.value!=''&&Frm.TxtPeso.value!=0)
	{
		
		if (confirm('Esta Seguro de Modificar el Peso de la Muestra'))
		{						
			Frm.action="sec_ing_produccion01.php?proceso=MODPESOMUESTRA&Valores="+Valores;
			Frm.submit();
		}	
	}
	else
	{
		alert("Debe ingresar Peso");
		Frm.TxtPeso.focus();
		return;
	}
}

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frmPopUp" action="" method="post">
<div style="position:absolute; left: 15px; top: 15px;" id="div0">
<table width="500" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
        <td align="center">Datos de Produccion</td>
  </tr>
</table>
</div>

<?php 
	
	//Campos Ocultos.
	echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">';
	echo '<input name="fecha" type="hidden" value="'.$fecha.'">';
	echo '<input name="Fecha2" type="hidden" value="'.$Fecha2.'">';

	echo '<div style="position:absolute; left: 15px; top: 50px; width:518px; height:200px; id="div2">';
	echo '<table width="500" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
	echo '<tr>';
	echo '<td width="250" align="center">Grupo</td>';
	echo '<td width="250" align="center">Lado</td>';
	echo '<td width="250" align="center">Peso</td>';	
	echo '<td width="250" align="center">Muestra</td>';	
	echo '</tr>';	 
	echo '</table>';
	echo '</div>';

	echo '<div style="position:absolute; left: 15px; top: 75px; width:518px; height:223px; OVERFLOW: auto;" id="div5">';
	echo '<table width="500" height="25" border="1" height="25" cellspacing="0" cellpadding="0">';

	if ($grupo != "99")
	{
	//$Fecha2 se reeplaza por hora de la tabla 
		$consulta = "SELECT cod_grupo,cod_lado,cod_muestra,fecha_produccion,hora, SUM(peso_produccion) AS peso FROM sec_web.produccion_catodo";
		$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora)  between '".$fecha."' and '".$Fecha2."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND cod_grupo = '".$grupo."'";
		$consulta.= " GROUP BY cod_grupo,cod_lado,cod_muestra";
	}
	else
	{
	
		$consulta = "SELECT cod_grupo,cod_lado,cod_muestra,fecha_produccion, hora, SUM(peso_produccion) AS peso FROM sec_web.produccion_desc_normal";
		$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora)  between '".$fecha."' and '".$Fecha2."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND cod_grupo = '".$grupo."'";
		$consulta.= " GROUP BY cod_grupo,cod_lado,cod_muestra";
	}
	
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
		if ($row[cod_muestra] == "S")
		{
			//echo '<td width="125"><input type="radio" name="radiobutton" value="'.$row["cod_grupo"].'/'.$row[fecha_produccion].'" onClick="Chequear(this)">'.$row["cod_grupo"].'</td>';
			echo '<td width="125">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="sec_ing_produccion_popup_cambio_fecha.php?cod_grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$fecha./*.$row[fecha_produccion].*/'&lado='.$row["cod_lado"].'&Fecha2='.$Fecha2.'">'.$row["cod_grupo"].'</a></td>';
		}
		else
		{
			echo '<td width="125">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="sec_ing_produccion_popup222.php?cod_grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$fecha./*.$row[fecha_produccion].*/'&lado='.$row["cod_lado"].'&Fecha2='.$Fecha2.'">'.$row["cod_grupo"].'</a></td>';
			//echo '<td width="125">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="sec_ing_produccion_popup222.php?cod_grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$row[fecha_produccion].'&lado='.$row["cod_lado"].'&Fecha2_mov='.$row[hora].'">'.$row["cod_grupo"].'</a></td>';
		}	
	//echo "entro22222";
		echo '<td width="125" height="25" align="center">'.$row["cod_lado"].'&nbsp;</td>';
		if ($row[cod_muestra] == "S")
		{
			echo '<td width="125" align="center">'.$row["peso"];
			//$Valores=$row["cod_grupo"]."|".$cmbproducto."|".$cmbsubproducto."|".$fecha."|".$Fecha2;
			$Valores=$row["cod_grupo"]."|".$cmbproducto."|".$cmbsubproducto."|".substr($fecha,0,10)."|".substr($Fecha2,0,10);
			//echo $Valores."<br>";
		}
		else
			echo '<td width="125" align="center">'.$row["peso"].'</td>';
		echo '<td width="125" align="center">'.$row[cod_muestra].'</td>';
		echo '</tr>';
	}
	
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