<?php 
	if(isset($_REQUEST["dia"])) {
		$dia = $_REQUEST["dia"];
	}else{
		$dia = date("d");
	}
	if(isset($_REQUEST["mes"])) {
		$mes = $_REQUEST["mes"];
	}else{
		$mes =  date("m");
	}
	if(isset($_REQUEST["ano"])) {
		$ano = $_REQUEST["ano"];
	}else{
		$ano =  date("Y");
	}
	if(isset($_REQUEST["mostrar"])) {
		$mostrar = $_REQUEST["mostrar"];
	}else{
		$mostrar = "";
	}
	if(isset($_REQUEST["subproducto"])) {
		$subproducto = $_REQUEST["subproducto"];
	}else{
		$subproducto = "";
	}
	if(isset($_REQUEST["fecha"])) {
		$fecha = $_REQUEST["fecha"];
	}else{
		$fecha = "";
	}

?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">
function Buscar(f)
{
	fecha = f.ano.value + '-' + f.mes.value + '-' + f.dia.value;
	f.action = "sea_ing_prod.php?mostrar=S&fecha=" + fecha;
	f.submit();
}
/***************/
function Salir()
{
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frm" action="" method="post">
<?php
	echo '<input name="subproducto" type="hidden" value="'.$subproducto.'">';
?>
<br><table width="500" align="center" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
    <td width="187" height="28" align="center"><font size="2">&nbsp; </font><font size="2">&nbsp; 
      Fecha Producción</font></td>
    <td width="296" align="left"><font size="2">
      <SELECT name="dia" size="1">
        <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia))			
					echo "<option SELECTed value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo "<option SELECTed value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
      </SELECT>
      </font> <font size="2"> 
      <SELECT name="mes" size="1" id="SELECT7">
        <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes))
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
      </SELECT>
      <SELECT name="ano" size="1">
        <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano))
					echo "<option SELECTed value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
      </SELECT>
      &nbsp; 
      <input name="btnbuscar" type="button" id="btnbuscar" value="Buscar" onClick="Buscar(this.form)">
      </font></td>
  </tr>
</table>
<?php
 	include("../principal/conectar_sea_web.php");
	
	$FechaInicio=$ano.'-'.$mes.'-'.$dia." 08:00:00";
	$FechaTermino =date("Y-m-d", mktime(0,0,0,$mes,($dia +1),$ano))." 07:59:59";
	$fecha2=date("Y-m-d", mktime(0,0,0,$mes,($dia +1),$ano));
	if ($mostrar == "S")
	{
		echo '<table width="500" align="center" border="1" cellpadding="0" cellspacing="0">';
		echo '<tr class="ColorTabla01">'; 
		echo '<td height="20" width="125" align="center">Grupo</td>';
		echo '<td width="125" align="center">Hornada</td>';		
		echo '<td width="125" align="center">Unidades</td>';
		echo '<td width="125" align="center">Peso</td>';	
		echo '<td width="100" align="center">Lado</td>';		
		echo '</tr>';

		//Consulta Solo los grupos del dia.
		$consulta = "SELECT DISTINCT campo2 FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 != 'M' AND campo1 != 'T'";
		$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino' ORDER BY campo2";
		//echo $consulta;
		$rs = mysqli_query($link, $consulta);

		$total_unidades = 0;
		$total_peso = 0;
		while ($row = mysqli_fetch_array($rs))
		{
			
			//Totales por Grupo.
			$consulta = "SELECT hornada, SUM(unidades) AS unidades, SUM(peso) AS peso";
			$consulta = $consulta." FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 != 'M' AND campo1 != 'T'";
			$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' AND campo2 = '".$row["campo2"]."' and hora between '$FechaInicio' and '$FechaTermino'";
			$consulta = $consulta." GROUP BY campo2";
			//echo $consulta."<br>";
			$rs2 = mysqli_query($link, $consulta);
			if ($row2 = mysqli_fetch_array($rs2))
			{
				echo '<tr>';
				echo '<td height="20" width="125" align="center">'.$row["campo2"].'</td>';
				echo '<td width="125" align="center">'.substr($row2["hornada"],6,6).'</td>';				
				echo '<td width="125" align="center">'.$row2["unidades"].'</td>';
				echo '<td width="125" align="center">'.$row2["peso"].'</td>';		
				echo '<td width="100" align="center">&nbsp;</td>';					
				echo '</tr>';
				
				$total_unidades = $total_unidades + $row2["unidades"];
				$total_peso = $total_peso + $row2["peso"];				
			}		
		}
		
		//Consulta Solo los grupos del dia.
		$consulta = "SELECT DISTINCT campo2,campo1 FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 in('M','T')";
		$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino' ORDER BY campo2";
		$rs = mysqli_query($link, $consulta);

		while ($row = mysqli_fetch_array($rs))
		{
			
			//Totales por Grupo.
			$consulta = "SELECT hornada, SUM(unidades) AS unidades, SUM(peso) AS peso";
			$consulta = $consulta." FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 in('M','T')";
			$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' AND campo2 = '".$row["campo2"]."' and hora between '$FechaInicio' and '$FechaTermino'";
			$consulta = $consulta." GROUP BY campo2,campo1";
		     /*if ($row["campo2"]=='26')
			 {
			    echo $consulta."<br>";
		     }*/
			$rs2 = mysqli_query($link, $consulta);
			if ($row2 = mysqli_fetch_array($rs2))
			{
				echo '<tr>';
				echo '<td height="20" width="100" align="center">'.$row["campo2"].'</td>';
				echo '<td width="100" align="center">'.substr($row2["hornada"],6,6).'</td>';				
				echo '<td width="100" align="center">'.$row2["unidades"].'</td>';
				echo '<td width="100" align="center">'.$row2["peso"].'</td>';			
				echo '<td width="100" align="center">'.$row["campo1"].'</td>';
				echo '</tr>';
				
				$total_unidades = $total_unidades + $row2["unidades"];
				$total_peso = $total_peso + $row2["peso"];			
			}		
		}		
		
		echo '<tr class="Detalle02">';
		echo '<td height="20" colspan="2">TOTAL</td>';
		//echo '<td colspan="2"></td>';
		echo '<td align="center">'.$total_unidades.'</td>';
		echo '<td align="center">'.$total_peso.'</td>';			
		echo '<td align="center">&nbsp;</td>';						
		echo '</tr>';
		echo '</table>';

	}
	
	include("../principal/cerrar_sea_web.php");
?>


<div style="position:absolute; left: 22px; top: 340px; width: 500px; height: 30px;" id="div4">
<table width="500" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center"><input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="Salir()"></td>
  </tr>
</table>
</div>

</form>
</body>
</html>
