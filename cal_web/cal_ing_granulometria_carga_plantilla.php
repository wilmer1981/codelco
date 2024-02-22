<?php 
	include("../principal/conectar_principal.php"); 
?>
<html>
<head>
<title>Carga Plantilla</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-image: url(../Principal/imagenes/fondo3.gif);
}
-->
</style>
<script language="javascript">
function Proceso(o)
{
	var f = document.frmCargaPlantilla;
	switch (o)
	{
		case "S1":
			f.action = "cal_ing_granulometria.php";
			f.submit();
			break;
		case "S2":
			window.close();
			break;
		case "C":
			var Valores = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="IdPlantilla" && f.elements[i].checked)
					var Valores = f.elements[i].value;									
			}
			if (Valores == "")
			{
				alert("No hay ninguna Plantilla Seleccionada");
				return;
			}
			else
			{
				f.action = "cal_ing_granulometria01.php?Proceso=CP&Corr=" + Valores;
				f.submit();
			}
			break;
		case "B":
			f.action = "cal_ing_granulometria_carga_plantilla.php";
			f.submit();
			break;
		case "E":
			var Valores = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="IdPlantilla" && f.elements[i].checked)
					var Valores = f.elements[i].value;									
			}
			if (Valores == "")
			{
				alert("No hay ninguna Plantilla Seleccionada");
				return;
			}
			else
			{
				f.action = "cal_ing_granulometria01.php?Proceso=EP&Corr=" + Valores;
				f.submit();
			}
			break;
	}
}
</script>
</head>

<body>
<form name="frmCargaPlantilla" action="" method="post">
<input type="hidden" name="SA" value="<?php echo $SA; ?>">
<input type="hidden" name="Recargo" value="<?php echo $Recargo; ?>">
<input type="hidden" name="Estado" value="<?php echo $Estado; ?>">
<input type="hidden" name="PesoMuestra" value="<?php echo $PesoMuestra; ?>">
<input type="hidden" name="Principal" value="<?php echo $Principal; ?>">
<table width="500" border="1" cellspacing="0" cellpadding="3">
  <tr>
    <th colspan="5" scope="row">CARGA PLANTILLA DE MALLAS </th>
    </tr>
  <tr>
    <th colspan="5" scope="row">&nbsp;</th>
    </tr>
  <tr>
    <th scope="row">Producto</th>
    <th colspan="4" align="left" scope="row"><select name="Producto" id="select3" onChange="Proceso('B');">
      <option value="S">Todos</option>
      <?php
	$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Fila["cod_producto"] == $Producto)
			echo "<option selected value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
	}
?>
    </select></th>
    </tr>
  <tr>
    <th scope="row">SubProducto</th>
    <th colspan="4" align="left" scope="row"><select name="SubProducto" id="select4">
      <option value="S">Todos</option>
      <?php
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='".$Producto."' order by descripcion";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Fila["cod_subproducto"] == $SubProducto)
			echo "<option selected value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
	}
?>
    </select></th>
    </tr>
  <tr>
    <th colspan="5" scope="row"><input name="BtnBuscar" type="button" id="BtnBuscar" value="Buscar" style="width:70px;" onClick="Proceso('B');">      
      <input name="BtnEliminar" type="button" id="BtnCargar4" value="Eliminar" style="width:70px;" onClick="Proceso('E');">
<?php
	if ($Principal == "S")
	{
		echo "<input name='BtnSalir2' type='button' value='Salir' style='width:70px;' onClick=\"Proceso('S2');\">\n";	  	
	}
	else
	{
		echo "<input name='BtnCargar' type='button' value='Cargar' style='width:70px;' onClick=\"Proceso('C');\">\n";
		echo "<input name='BtnSalir' type='button' value='Salir' style='width:70px;' onClick=\"Proceso('S1');\">\n";
	}
?>     
  </tr>
  <tr>
    <th colspan="5" scope="row">&nbsp;</th>
  </tr>
  <tr class="ColorTabla01">
    <th width="73" scope="row">Num.</th>
    <th width="173" scope="row">Descripcion</th>
    <th width="228" colspan="3" scope="row">Mallas</th>
    </tr>
<?php	
	$ArrUnidad = array();
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1007' order by cod_subclase";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$ArrUnidad[$Fila["cod_subclase"]][0] = $Fila["cod_subclase"];
		$ArrUnidad[$Fila["cod_subclase"]][1] = $Fila["nombre_subclase"];
	}
	$Consulta = "select * from cal_web.plantilla_granulometria ";
	if ($Producto != "S")
	{
		$Consulta.= " where cod_producto = '".$Producto."'";
		if ($SubProducto != "S")
		{	
			$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		}
	}
	$Consulta.= " order by corr, descripcion";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{	
		$Corr = $Fila["corr"];
		$Descripcion = $Fila["descripcion"];
		$Datos = explode("~~",$Fila["malla"]);
		$Malla = "";
		while (list($v,$k)=each($Datos))
		{
			$Datos2 = explode("///",$k);
			$Signo = str_replace("MAS","+",$Datos2[0]);
			$Signo = str_replace("MENOS","-",$Signo);
			$Desc = $Datos2[1];
			$CodUnidad = $Datos2[2];
			$Malla = $Malla."".$Signo."".$Desc." ".$ArrUnidad[$CodUnidad][1]."; ";
		}
		$Malla = substr($Malla,0,strlen($Malla)-2);
		echo "<tr>\n";
		echo "<th scope='row'>".$Corr."<input type='radio' name='IdPlantilla' value='".$Corr."'></th>\n";
		echo "<th scope='row'>".$Descripcion."</th>\n";		
		echo "<th colspan='3' scope='row'>".$Malla."</th>\n";
		echo "</tr>\n";
	}
 ?>
</table>
</form>
</body>
</html>
