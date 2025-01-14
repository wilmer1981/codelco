<?php

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
if(isset($_REQUEST["mostrar"])) {
	$mostrar = $_REQUEST["mostrar"];
}else{
	$mostrar = "";
}

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

?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">
function Buscar(f)
{
	fecha = f.ano.value + '-' + f.mes.value + '-' + f.dia.value;
	f.action = "sea_con_beneficios.php?mostrar=S&fecha="+fecha+"&subproducto="+f.subproducto.value;
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

<!--<div style="position:absolute; top: 15px; width: 500px; height: 31px; left: 20;" id="div1">-->
<br>
<table width="600" align="center" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
    <td width="187" height="28" align="center"><font size="2">&nbsp; </font><font size="2">&nbsp; 
      Fecha Beneficio</font></td>
    <td width="296" align="left"><font size="2">
      <select name="dia" size="1">
        <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia))			
					echo "<option selected value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo "<option selected value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
      </select>
      </font> <font size="2"> 
      <select name="mes" size="1" id="select7">
        <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
      </select>
      <select name="ano" size="1">
        <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
      </select>
      &nbsp; 
      <input name="btnbuscar" type="button" id="btnbuscar" value="Buscar" onClick="Buscar(this.form)">
      </font></td>
  </tr>
</table><br>
<!--</div>-->

<!--<div style="position:absolute; top: 55px; width: 500px; height: 23px; left: 20px;" id="div2">-->

<table width="600" align="center" border="1" cellpadding="2" cellspacing="0">
  <tr class="ColorTabla01"> 
    <td height="25" width="100" align="center">Hornada</td>
    <td width="100" align="center">Unidades</td>
    <td width="100" align="center">Peso</td>	
    <td width="100" align="center">Grupo</td>
    <td width="100" align="center">Lado/Cuba</td>
	<td width="100" align="center">As</td>
	<td width="100" align="center">Sb</td>
	<td width="100" align="center">Bi</td>
  </tr>
<!--</table>-->
<!--</div>-->

<?php
 	include("../principal/conectar_sea_web.php");
	$FechaInicio=$ano.'-'.$mes.'-'.$dia." 08:00:00";
	$FechaTermino =date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano))." 07:59:59";
	$Fecha2=date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano));
	//echo "fechas".$FechaInicio."term".$FechaTermino."--2--".$Fecha2;
	if ($mostrar == "S")
	{
		//echo '<div style="position:absolute; left: 18px; top: 78px; width: 620px; height: 260px; OVERFLOW: auto;" id="div3">';
		
		//Consulta Solo los grupos del dia.
		$consulta = "SELECT DISTINCT campo2 FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto = 17 AND cod_subproducto = '".$subproducto."' ";
		//$consulta = $consulta." AND fecha_movimiento = '".$fecha."'";
		$consulta = $consulta." AND ((fecha_movimiento between '".$fecha."' and '".$Fecha2."' AND fecha_benef = '0000-00-00' and hora between '".$FechaInicio."' and '".$FechaTermino."')";
		$consulta = $consulta." OR (fecha_benef = '".$fecha."'))";			
		$consulta = $consulta." ORDER BY campo2";
		$rs = mysqli_query($link, $consulta);
		//echo $consulta;
		while ($row = mysqli_fetch_array($rs))
		{
			//echo '<table width="700" align="center" border="1" cellpadding="0" cellspacing="0" class="TablaInterior">';

			//Consulta el detalle por grupo.
			$consulta = "SELECT hornada, unidades, campo1, campo2, peso";
			$consulta = $consulta." FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto = 17 AND cod_subproducto = '".$subproducto."' ";
			//$consulta = $consulta." AND fecha_movimiento = '".$fecha."'";
			$consulta = $consulta." AND ((fecha_movimiento between '".$fecha."' and '".$Fecha2."' AND fecha_benef = '0000-00-00' and hora between '".$FechaInicio."' and '".$FechaTermino."')";
			$consulta = $consulta." OR (fecha_benef = '".$fecha."'))";			
			$consulta = $consulta." AND campo2 = '".$row["campo2"]."'";
			$consulta = $consulta." ORDER BY campo1, hornada";			
			//echo $consulta."<br>";
			$ContReg=0;$ContRegAS=0;$ContRegSB=0;$ContRegBI=0;$TotAS=0;$TotSB=0;$TotBI=0;
			$rs1 = mysqli_query($link, $consulta);		

			while ($row1 = mysqli_fetch_array($rs1))
			{
				echo '<tr>';
				echo '<td height="20" width="40" align="center">'.substr($row1["hornada"],6,4).'</td>';
				echo '<td width="40" align="center">'.$row1["unidades"].'</td>';
				echo '<td width="40" align="center">'.$row1["peso"].'</td>';			
				echo '<td width="40" align="center">'.$row1["campo2"].'</td>';
				echo '<td width="40" align="center">'.$row1["campo1"].'</td>';
				$Encontro=false;
				$Consulta="select * from leyes_por_hornada where hornada = '".$row1["hornada"]."' and cod_leyes in ('08', '09', '27') and cod_producto = '17' and cod_subproducto = '".$subproducto."'";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Resp))
				{
					$Encontro=true;
					echo '<td width="40" align="center">&nbsp;'.number_format($Fila["valor"],2,',','.').'</td>';
					switch($Fila["cod_leyes"])
					{
						case "08":
							$TotAS=$TotAS+$Fila["valor"];
							$ContRegAS++;
							break;
						case "09":
							$TotSB=$TotSB+$Fila["valor"];
							$ContRegSB++;
							break;
						case "27":
							$TotBI=$TotBI+$Fila["valor"];
							$ContRegBI++;
							break;
					}
				}
				if($Encontro==false)
				{
					echo '<td width="50" align="center">&nbsp;</td>';
					echo '<td width="50" align="center">&nbsp;</td>';
					echo '<td width="50" align="center">&nbsp;</td>';				
				}
				echo '</tr>';		
				$ContReg++;
			}
			//echo '</table>';			
			
			//Totales por Grupo.
			$consulta = "SELECT SUM(unidades) AS unidades, SUM(peso) AS peso";
			$consulta = $consulta." FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto = 17 AND cod_subproducto = '".$subproducto."' ";
			//$consulta = $consulta." AND fecha_movimiento = '".$fecha."'";
			$consulta = $consulta." AND ((fecha_movimiento between '".$fecha."' and '".$Fecha2."' AND fecha_benef = '0000-00-00' and hora between '".$FechaInicio."' and '".$FechaTermino."')";
			$consulta = $consulta." OR (fecha_benef = '".$fecha."'))";				
			$consulta = $consulta." AND campo2 = '".$row["campo2"]."'";
			
			$rs2 = mysqli_query($link, $consulta);
			if ($row2 = mysqli_fetch_array($rs2))
			{
				//echo '<table width="600" align="center" border="0" cellpadding="0" cellspacing="0" class="TablaInterior">';
				echo '<tr class="Detalle02">';
				echo '<td height="20" width="100" align="center">TOT.GRUPO</td>';
				echo '<td width="100" align="center">'.$row2["unidades"].'</td>';
				echo '<td width="100" align="center">'.$row2["peso"].'</td>';			
				echo '<td width="100" align="center">'.$row["campo2"].'</td>';
				echo '<td width="100" align="center">PROMEDIO</td>';
				if ($ContRegAS==0)
				{
					$ContRegAS=1;
				}
				if ($ContRegSB==0)
				{
					$ContRegSB=1;
				}
				if ($ContRegBI==0)
				{
					$ContRegBI=1;
				}

				echo '<td width="100" align="center">'.number_format($TotAS/$ContRegAS,2,',','.').'</td>';
				echo '<td width="100" align="center">'.number_format($TotSB/$ContRegSB,2,',','.').'</td>';
				echo '<td width="100" align="center">'.number_format($TotBI/$ContRegBI,2,',','.').'</td>';
				echo '</tr>';
				//echo '</table><br><br>';
			}		
		}
		//echo '</div>';
	}
	include("../principal/cerrar_sea_web.php");
?>
</table><br>
<table width="600" border="1" cellpadding="3" cellspacing="0" align="center">
  <tr>
    <td align="center"><input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="Salir()"></td>
  </tr>
</table>
</form>
</body>
</html>
