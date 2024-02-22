<?php include("../principal/conectar_pmn_web.php")?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f = document.frmDetalleProductos;
	var T = f.Turno.value;
	var Valores = "";
	switch (opt)//opcion y el turno
	{
		case "GP": // GRABA POR PRODUCTOS EXTERNOS			
			for (i=1;i<f.Check.length;i++)
			{
				if (f.Check[i].checked == true)
				{
					Valores = Valores + f.Check[i].value + "-";
				}
			}
			if (Valores == "")
			{
				alert("No ha ningún registro seleccionado");
				return;
			}
			else
			{
				f.Marcados.value = Valores;
			}
			f.action = "pmn_ing_deselenizacion01.php?Proceso=GP&Turno="+T;
			f.submit();
			break;
		case "S":
			window.close();
			break;
		case "R":
	
			f.action = "pmn_detalle_productos.php?Turno="+T;
			f.submit();
			break;
	}
}
-->
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmDetalleProductos" action="" method="post">
<input type="hidden" name="Prod" value="<?php echo $Prod; ?>">
<?php /*echo $Prod; ?>
<?php echo $SubProd;*/ ?>
<input type="hidden" name="SubProd" value="<?php echo $SubProd; ?>">
<input type="hidden" name="Marcados" value="">
<input type="hidden" name="Hornada" value="<?php echo $Hornada; ?>">
<input type="hidden" name="NumHorno" value="<?php echo $NumHorno; ?>">
<input type="hidden" name="NumFunda" value="<?php echo $NumFunda; ?>">
<input type="hidden" name="HornadaTotal" value="<?php echo $HornadaTotal; ?>">
<input type="hidden" name="HornadaParcial" value="<?php echo $HornadaParcial; ?>">
<input type="hidden" name="Dia" value="<?php echo $Dia; ?>">
<input type="hidden" name="Mes" value="<?php echo $Mes; ?>">
<input type="hidden" name="Ano" value="<?php echo $Ano; ?>">
<input type="hidden" name="KwhIni" value="<?php echo $KwhIni; ?>">
<input type="hidden" name="KwhFin" value="<?php echo $KwhFin; ?>">
<input type="hidden" name="SacosCarbon" value="<?php echo $SacosCarbon; ?>">
<input type="hidden" name="Operador01" value="<?php echo $Operador01; ?>">
<input type="hidden" name="Acidc" value="<?php echo $Acidc; ?>">
<input type="hidden" name="DiaSalida" value="<?php echo $DiaSalida; ?>">
<input type="hidden" name="MesSalida" value="<?php echo $MesSalida; ?>">
<input type="hidden" name="AnoSalida" value="<?php echo $AnoSalida; ?>">
<input type="hidden" name="Operador02" value="<?php echo $Operador02; ?>">
<input type="hidden" name="ProdCalcina" value="<?php echo $ProdCalcina; ?>">

<table width="650" border="0" cellspacing="0" cellpadding="3">
  <tr> 
    <td height="32" colspan="3" class="TituloCabeceraAzul"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Detalle 
      Productos Externos</strong></font><strong ></strong></td>
  </tr>
  <tr> 
    <td width="97" class="titulo_azul">Identificacion:</td>
    <td width="316"><strong> 
      <select name="IdProd" style="width:300" onChange="Proceso('R');">
	  <?php
	
		if ($Prod == '25' and $SubProd == '5')
		{
			$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.id_producto, t1.referencia FROM pmn_web.productos_externos AS t1";
			$Consulta.= " INNER JOIN pmn_web.detalle_productos_externos AS t2";
			$Consulta.= " ON t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
			$Consulta.= " AND t1.id_producto = t2.id_producto";
			$Consulta.= " WHERE t1.cod_producto = '".$Prod."' AND t1.cod_subproducto = '".$SubProd."'";								
			$Consulta.= " GROUP BY t1.cod_producto,t1.cod_subproducto,t1.id_producto";
			$Consulta.= " HAVING SUM(t2.stock_bad) > 0";
			$Consulta.= " ORDER BY t1.id_producto";
			//echo "hola".$Consulta;
		}
		else
		{	  	
		  	$Consulta = "select cod_producto, cod_subproducto, id_producto, referencia from pmn_web.productos_externos where ";
			$Consulta.= " cod_producto = '".$Prod."' ";
			$Consulta.= " and  cod_subproducto = '".$SubProd."' ";
			$Consulta.= " order by id_producto ";
			//echo "hola1".$Consulta."<br>";
		}		
		
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;				
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			if ($i == 1)
				$IdSeleccionado = $Row[id_producto];
			if ($Row[id_producto] == $IdProd)
			{
				echo "<option selected value='".$Row[id_producto]."'>".$Row[id_producto]." - ".ucwords(strtolower($Row[referencia]))."</option>\n";
				$IdSeleccionado = $Row[id_producto];
			}
			else
			{
				echo "<option value='".$Row[id_producto]."'>".$Row[id_producto]." - ".ucwords(strtolower($Row[referencia]))."</option>\n";
			}	
			$i++;			
		}
	  ?>
      </select>
      </strong></td>
    <td width="219"><input type="button" name="btnOK" value="OK" onClick="Proceso('R','<?php echo $Turno;  ?>');"></td>
  </tr>
</table>
<strong><br>
</strong> 
  <table width="654" border="0" cellspacing="0" cellpadding="3" class="TablaDetalle">
    <tr align="center" valign="middle" class="TituloCabeceraAzul"> 
      <td width="18">&nbsp;</td>
      <td width="120"><strong>Referencia</strong></td>
      <td width="102"><strong>Peso Bruto</strong></td>
      <td width="99"><strong>Peso Resta</strong></td>
      <td width="122"><strong>Peso Neto</strong></td>
      <td width="154"><strong>Stock Actual</strong></td>
    </tr>
    <?php  
	$Consulta = "select * from pmn_web.detalle_productos_externos ";
	$Consulta.= " where cod_producto = '".$Prod."' ";
	$Consulta.= " and cod_subproducto = '".$SubProd."' ";
	$Consulta.= " and id_producto = '".$IdSeleccionado."' ";
	$Consulta.= " order by referencia ";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='Check' value=''>\n";
	while ($Row = mysqli_fetch_array($Respuesta))
	{		
		echo "<tr align='center' valign='middle'> \n";
		echo "<td><input type='checkbox' name='Check' value='".$Row[referencia]."'></td>\n";
		echo "<td><input readonly size='15' maxlength='20' type='text' name='Referencia' value='".$Row[id_producto]."-".$Row[referencia]."'></td>\n";
		echo "<td><input readonly size='10' maxlength='20' type='text' name='PesoBruto' value='".$Row[peso_bruto]."' style='text-align: right;'></td>\n";
		echo "<td><input readonly size='10' maxlength='20' type='text' name='PesoResta' value='".$Row[peso_resta]."' style='text-align: right;'></td>\n";
		echo "<td><input readonly size='10' maxlength='20' type='text' name='PesoNeto' value='".($Row[peso_bruto] - $Row[peso_resta])."' style='text-align: right;'></td>\n";
		//STOCK DE LA PRODUCTOS EXTERNOS
		/*$Consulta = "select ifnull(sum(bad),0) as ocupado from pmn_web.detalle_deselenizacion ";
		$Consulta.= " where tipo = 'P' ";
		$Consulta.= " and cod_producto = '".$Prod."' ";
		$Consulta.= " and cod_subproducto = '".$SubProd."' ";
		$Consulta.= " and id_producto = '".$IdSeleccionado."' ";
		$Consulta.= " and referencia = '".$Row[referencia]."' ";
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Row2 = mysqli_fetch_array($Respuesta2);
		$Ocupado = $Row2[ocupado];
		$Inicial = $Row[peso_bruto] - $Row[peso_resta];
		$StockActual = $Inicial - $Ocupado;*/
		echo "<td><input name='StockActual' type='text' readonly value='".$Row[stock_bad]."' size='12' maxlength='12' style='text-align=right'></td>\n";
		echo "</tr>\n";
	}
?>
  </table>
  <br>
<table width="533" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td align="center" valign="middle"><input type="button" name="btnAceptar" value="Aceptar" style="width:70" onClick="Proceso('GP')">
      &nbsp; 
      <input type="button" name="btnCerrar" value="Cerrar" style="width:70" onClick="Proceso('S')"></td>
  </tr>
</table>
<?php 
	//Campo Oculto.
	echo '<input type="hidden" name="Turno" value="'.$Turno.'">';
?>
</form>
</body>
</html>
