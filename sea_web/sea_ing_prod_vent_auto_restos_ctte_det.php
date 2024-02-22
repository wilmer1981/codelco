<?php 
include("../principal/conectar_sea_web.php");	
//Proceso=B&cmbproductos=-1&dia=1&mes=1&ano=2023

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = '';
}
if(isset($_REQUEST["cmbproductos"])) {
	$cmbproductos = $_REQUEST["cmbproductos"];
}else{
	$cmbproductos = '';
}
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano = "";
}
if(isset($_REQUEST["mes"])) {
	$mes = $_REQUEST["mes"];
}else{
	$mes = "";
}
if(isset($_REQUEST["dia"])) {
	$dia = $_REQUEST["dia"];
}else{
	$dia = "";
}

if(isset($_REQUEST["subproducto"])) {
	$subproducto = $_REQUEST["subproducto"];
}else{
	$subproducto = "";
}

?>
<html>
<head>
<title>Sistema Estadistico de Anodos</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">

function Proceso(opt)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "B":
			f.action = "sea_ing_prod_vent_auto_restos_ctte_det.php";
			f.submit();
			break;
		case "S":
			//window.opener.document.formulario.action="sea_ing_prod_vent_auto.php";
			//window.opener.document.formulario.submit();
			window.close();
			break;
		case "I":
			f.BtnBuscar.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnBuscar.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;
	}
}

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" background="../Principal/imagenes/fondo3.gif">
<form name="frmPopUp" action="" method="post">
<?php
	echo '<input name="subproducto" type="hidden" value="'.$subproducto.'">';
?>
<br><table width="500" align="center" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr>
    <td height="28" colspan="2" align="center"><strong>HORNADAS PRODUCIDAS </strong></td>
    </tr>
  <tr> 
    <td width="187" height="28" align="center"><font size="2">&nbsp; </font><font size="2">&nbsp; 
      Fecha Producción</font></td>
    <td width="296" align="left"><font size="2">
      <SELECT name="dia" size="1">
        <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (isset($dia))
				{
					if ($i == $dia)
						echo "<option SELECTed value= '".$i."'>".$i."</option>";																			
					else					
						echo "<option value='".$i."'>".$i."</option>";					
				}
				else
				{
					if ($i == date("j"))
						echo "<option SELECTed value= '".$i."'>".$i."</option>";																			
					else					
						echo "<option value='".$i."'>".$i."</option>";	
				}
											
			}		
		?>
      </SELECT>
      </font> <font size="2"> 
      <SELECT name="mes" size="1" id="SELECT7">
        <?php
		 	for ($i=1;$i<=12;$i++)
			{	
				if (isset($mes))
				{
					if ($i == $mes)
						echo "<option SELECTed value= '".$i."'>".$Meses[$i-1]."</option>";																			
					else					
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>";					
				}
				else
				{
					if ($i == date("n"))
						echo "<option SELECTed value= '".$i."'>".$Meses[$i-1]."</option>";																			
					else					
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>";	
				}
											
			}		  
		?>
      </SELECT>
      <SELECT name="ano" size="1">
        <?php
			for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
			{	
				if (isset($ano))
				{
					if ($i == $ano)
						echo "<option SELECTed value= '".$i."'>".$i."</option>";																			
					else					
						echo "<option value='".$i."'>".$i."</option>";					
				}
				else
				{
					if ($i == date("Y"))
						echo "<option SELECTed value= '".$i."'>".$i."</option>";																			
					else					
						echo "<option value='".$i."'>".$i."</option>";	
				}
											
			}		
		?>
      </SELECT>
      &nbsp; 
      <input name="BtnBuscar" type="button" id="btnbuscar" value="Buscar" onClick="Proceso('B')">
      </font></td>
  </tr>
</table>
<br>
<table width="500" align="center" border="1" cellpadding="0" cellspacing="0">
<tr class="ColorTabla01"> 
<td height="20" width="100" align="center">Grupo</td>
<td width="100" align="center">Hornada</td>		
<td width="100" align="center">Unidades</td>
<td width="100" align="center">Peso</td>
<td width="100" align="center">Lado/Cuba</td>
</tr>
<?php 	
	$fecha = $ano."-".$mes."-".$dia;
	$total_unidades = 0;
	$total_peso = 0;
	//Consulta Solo los grupos del dia.
	$consulta = "SELECT DISTINCT campo2,campo1 FROM sea_web.movimientos";
	$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 in('M','T')";
	$consulta = $consulta." AND fecha_movimiento = '".$fecha."' ORDER BY campo2";
	$rs = mysqli_query($link, $consulta);
	//echo $consulta;
	while ($row = mysqli_fetch_array($rs))
	{		
		//Totales por Grupo.
		$consulta = "SELECT hornada, SUM(unidades) AS unidades, SUM(peso) AS peso";
		$consulta = $consulta." FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 in('M','T')";
		$consulta = $consulta." AND fecha_movimiento = '".$fecha."' AND campo2 = '".$row["campo2"]."'";
		$consulta = $consulta." GROUP BY campo2,campo1";
		$rs2 = mysqli_query($link, $consulta);
		//echo $consulta."<br>";
		if ($row2 = mysqli_fetch_array($rs2))
		{
			echo '<tr>';
			echo '<td height="20" width="100" align="center">'.$row["campo2"].'</td>';
			echo '<td width="100" align="center">'.substr($row2["hornada"],6,6).'</td>';				
			echo '<td width="100" align="center">'.number_format($row2["unidades"],0,",",".").'</td>';
			echo '<td width="100" align="center">'.number_format($row2["peso"],0,",",".").'</td>';			
			echo '<td width="100" align="center">'.$row["campo1"].'</td>';
			echo '</tr>';
			
			$total_unidades = $total_unidades + $row2["unidades"];
			$total_peso = $total_peso + $row2["peso"];				
		}		
	}	
	$consulta = "SELECT DISTINCT campo2 FROM sea_web.movimientos";
	$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 != 'M' AND campo1 != 'T'";
	$consulta = $consulta." AND fecha_movimiento = '".$fecha."' ORDER BY campo2";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{		
		//Totales por Grupo.
		$consulta = "SELECT hornada, SUM(unidades) AS unidades, SUM(peso) AS peso";
		$consulta = $consulta." FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 != 'M' AND campo1 != 'T'";
		$consulta = $consulta." AND fecha_movimiento = '".$fecha."' AND campo2 = '".$row["campo2"]."'";
		$consulta = $consulta." GROUP BY campo2";
		$rs2 = mysqli_query($link, $consulta);
		if ($row2 = mysqli_fetch_array($rs2))
		{
			echo '<tr>';
			echo '<td height="20" width="125" align="center">'.$row["campo2"].'</td>';
			echo '<td width="125" align="center">'.substr($row2["hornada"],6,6).'</td>';				
			echo '<td width="125" align="center">'.number_format($row2["unidades"],0,",",".").'</td>';
			echo '<td width="125" align="center">'.number_format($row2["peso"],0,",",".").'</td>';		
			echo '<td width="100" align="center">&nbsp;</td>';					
			echo '</tr>';				
			$total_unidades = $total_unidades + $row2["unidades"];
			$total_peso = $total_peso + $row2["peso"];				
		}		
	}		
	include("../principal/cerrar_sea_web.php");
?>
	<tr align="center" bgcolor="#FFFFFF">
	<td height="20" colspan="2"><strong>TOTAL</strong></td>
	<td><?php echo number_format($total_unidades,0,",","."); ?></td>
	<td><?php echo number_format($total_peso,0,",","."); ?></td>		
	<td>&nbsp;</td>		
	</tr>
</table>
<br>
<br>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70" onClick="Proceso('I')">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S')"></td>
  </tr>
</table>

</form>
</body>
</html>
