<?php
	include("../principal/conectar_principal.php");
	
	//CANT CARROS
	if(isset($_REQUEST["Tipo"])) {
		$Tipo = $_REQUEST["Tipo"];
	}else{
		$Tipo = '';
	}

	$Consulta = "SELECT * from sea_web.taras where tipo_tara = 'C' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$CantCarros = mysqli_num_rows($Respuesta);
	//CANT RACKS
	$Consulta = "SELECT * from sea_web.taras where tipo_tara = 'R' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$CantRacks = mysqli_num_rows($Respuesta);

	//PERIODO DE PESAJE DE RACKS Y CARROS
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '2012' and cod_subclase='1'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Periodo = $Fila["valor_subclase1"];
		$FechaComparacion = date("Y-m-d", mktime(0,0,0,date("m")-$Periodo,date("d"),date("Y")));
	}
?>
<html>
<head>
<title>Detalle Taras de Racks y Carros</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {
	background-image: url(../Principal/imagenes/fondo3.gif);
}
</style>
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmDetalle;
	switch (opt)
	{	
			case "S":
				window.close();
				break;
			case "I":
				f.Tipo.style.visibility = 'hidden';
				f.BtnImprimir.style.visibility = 'hidden';
				f.BtnSalir.style.visibility = 'hidden';			
				window.print();
				f.Tipo.style.visibility = '';
				f.BtnImprimir.style.visibility = '';
				f.BtnSalir.style.visibility = '';
				break;
			case "R":
				f.action = "sea_ing_prod_vent_auto_taras_det.php";
				f.submit();
				break;
				
				
			case "M":
				var TipoTara = f.Tipo.value;
				var NumeroM="";
				var PesoM="";
				for (i=0;i<f.elements.length;i++)
				{
					if (f.elements[i].name == "ChkNumero" && f.elements[i].checked)
					{					
						var NumeroM = f.elements[i].value;
						var PesoM   = f.elements[i+1].value;
					}
				}
				if (NumeroM == "")
				{
					alert("No hay ningun registro seleccionado para Modificar");
					return;
				}
				else
				{
					window.open("sea_ing_prod_vent_auto_mod_taras.php?TipoTara=" + TipoTara + "&Numero=" + NumeroM);
		
					//window.open("sea_ing_prod_vent_auto_mod_taras.php?TipoTara=" + TipoTara + "&Numero=" + NumeroM);
				}
				break;
		case "E":
				var TipoTara = f.Tipo.value;
				var NumeroM="";
				for (i=0;i<f.elements.length;i++)
				{
					if (f.elements[i].name == "ChkNumero" && f.elements[i].checked)
					{
						var NumeroM  = f.elements[i].value;
					}
				}
				if (NumeroM == "")
				{
					alert("No hay ningun registro seleccionado para Eliminar");
					return;
				}
				else
				{
					var msg = confirm("�Seguro que desea Eliminar este Registro?");
					if (msg==true)
					{
						f.action = "sea_ing_prod_vent_auto01.php?Proceso=E_Tara&TipoTara=" + TipoTara + "&Numero=" + NumeroM;
						f.submit();
					}
				else
				{
					return;
				}
			}
			break;

	}
}
</script>
</head>

<body>
<table width="400" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
<form name="frmDetalle" action="" method="post">
  <tr align="center">
    <td colspan="2"><strong>TARAS DE CARROS Y RACKS </strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="115">Periodo de Tara: </td>
    <td width="266"><?php echo $Periodo; ?> Mes(es) </td>
  </tr>
  <tr>
    <td>Total Carros: </td>
    <td><?php echo $CantCarros; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>Total Racks: </td>
    <td><?php echo $CantRacks; ?></td>
  </tr>
  <tr align="center">
    <td colspan="2">Todos los Carros y Racks que fueron Tarados antes del <?php echo substr($FechaComparacion,8,2)."-".substr($FechaComparacion,5,2)."-".substr($FechaComparacion,0,4); ?> deben
    ser RE-TARADOS</td>
  </tr>
  <tr align="center">
    <td colspan="2"><SELECT name="Tipo" id="SELECT" onChange="Proceso('R')">
<?php	
	switch ($Tipo)
	{
		case "T":
			echo "<option SELECTed value='T'>Ver: Todos</option>\n";
			echo "<option value='C'>Ver: Carros</option>\n";
			echo "<option value='R'>Ver: Racks</option>\n";
			break;
		case "C":
			echo "<option value='T'>Ver: Todos</option>\n";
			echo "<option SELECTed value='C'>Ver: Carros</option>\n";
			echo "<option value='R'>Ver: Racks</option>\n";
			break;
		case "R":
			echo "<option value='T'>Ver: Todos</option>\n";
			echo "<option value='C'>Ver: Carros</option>\n";
			echo "<option SELECTed value='R'>Ver: Racks</option>\n";
			break;
		default:
			echo "<option SELECTed value='T'>Ver: Todos</option>\n";
			echo "<option value='C'>Ver: Carros</option>\n";
			echo "<option value='R'>Ver: Racks</option>\n";
			break;
	}
?>	  
    </SELECT>
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" onClick="Proceso('I')" style="width:70px ">
	<?php if ($Tipo=="C" || $Tipo =="R")
	  { ?>
	  	<input name="BtnModifica" type="button" id="BtnModifica" value="Modificar" onClick="Proceso('M')" style="width:70px ">
	  	<input name="BtnElimina" type="button" id="BtnElimina" value="Eliminar" onClick="Proceso('E')" style="width:70px ">
	<?php } ?>
	  <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Proceso('S')" style="width:70px "></td>
  </tr>
</table>
<?php
//DETALLE CARROS
if ($Tipo == "C" || $Tipo == "T" || !isset($Tipo))
{
	
	echo "<br><table align='center' width='400' border='1' cellspacing='0' cellpadding='3' class='TablaDetalle'>\n";
	echo "<tr align='center' class='ColorTabla01'>\n";
	echo "<td colspan='5'><strong>CARROS</strong></td>\n";
	echo "</tr>\n";
	echo "<tr align='center' class='ColorTabla01'>\n";
	echo "<td width='20'>&nbsp;</td>\n";
	echo "<td width='80'><strong>Numero</strong></td>\n";
	echo "<td width='95'><strong> Peso </strong></td>\n";
	echo "<td width='111'><strong>Fecha Ult. Tara </strong></td>\n";
	echo "<td width='79'><strong>RE-TARAR</strong></td>\n";
	echo "</tr>\n";
	$Consulta = "SELECT * from sea_web.taras where tipo_tara = 'C' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$ContCarros = 0;
	$TotalPeso = 0;
	
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr align='center'>\n";
		if ($Tipo=="C")
		{
			
			echo "<td align='center'><input type='radio' name='ChkNumero' value='".$Fila["numero"]."'>";
		} 
		echo "<td name='Numero' type='text'>".$Fila["numero"]."</td>\n";
		echo "<td>".number_format($Fila["peso"],0,",",".")."</td>\n";
		echo "<td>".substr($Fila["fecha_pesaje"],8,2)."-".substr($Fila["fecha_pesaje"],5,2)."-".substr($Fila["fecha_pesaje"],0,4)."</td>\n";
		if ($Fila["fecha_pesaje"]<$FechaComparacion)		
			echo "<td><font color='RED'>SI</font></td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "</tr>\n";
		$ContCarros++;
		$TotalPeso = $TotalPeso + $Fila["peso"];
	}
	echo "<tr bgcolor='#FFFFFF' align='center'>\n";
	echo "<td><strong>Total Carros:</strong></td>\n";
	echo "<td>".$ContCarros."</td>\n";
	echo "<td><strong>Peso Carros:</strong></td>\n";
	echo "<td>".number_format($TotalPeso,0,",",".")."</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
}	
//DETALLE RACKS
if ($Tipo == "R" || $Tipo == "T" || !isset($Tipo))
{
	echo "<br><table align='center' width='400' border='1' cellspacing='0' cellpadding='3' class='TablaDetalle'>\n";
	echo "<tr align='center' class='ColorTabla01'>\n";
	echo "<td colspan='5'><strong>RACKS</strong></td>\n";
	echo "</tr>\n";
	echo "<tr align='center' class='ColorTabla01'>\n";
	echo "<td width='20'>&nbsp;</td>\n";
	echo "<td width='80'><strong>Numero</strong></td>\n";
	echo "<td width='95'><strong> Peso </strong></td>\n";
	echo "<td width='111'><strong>Fecha Ult. Tara </strong></td>\n";
	echo "<td width='79'><strong>RE-TARAR</strong></td>\n";
	echo "</tr>\n";
	$Consulta = "SELECT * from sea_web.taras where tipo_tara = 'R' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$ContCarros = 0;
	$TotalPeso = 0;
	$ContRacks = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr align='center'>\n";
		 if ($Tipo=="R")
		{
			$wtipo = $Tipo;
			echo "<td align='center'><input type='radio' name='ChkNumero' value='".$Fila["numero"]."'>";
		} 
		echo "<td>".$Fila["numero"]."</td>\n";
		echo "<td>".number_format($Fila["peso"],0,",",".")."</td>\n";
		echo "<td>".substr($Fila["fecha_pesaje"],8,2)."-".substr($Fila["fecha_pesaje"],5,2)."-".substr($Fila["fecha_pesaje"],0,4)."</td>\n";
		if ($Fila["fecha_pesaje"]<$FechaComparacion)		
			echo "<td><font color='RED'>SI</font></td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "</tr>\n";
		$ContRacks++;
		$TotalPeso = $TotalPeso + $Fila["peso"];
	}
	echo "<tr bgcolor='#FFFFFF' align='center'>\n";
	echo "<td><strong>Total Racks:</strong></td>\n";
	echo "<td>".$ContRacks."</td>\n";
	echo "<td><strong>Peso Racks:</strong></td>\n";
	echo "<td>".number_format($TotalPeso,0,",",".")."</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
}	
?> 
</form>
</body>
</html>
