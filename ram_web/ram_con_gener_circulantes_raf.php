<?php
	$CodigoDeSistema=7;
	$CodigoDePantalla=24;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
?>
<html>
<head>
<title>GENERACION DE CIRCULANTES DE FUNDICION Y RAF RECEPCIONADOS EN RECEPCION Y MEZCLA</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,opt2)
{
	var f = document.frmPrincipal;
	var Valores='';
	switch (opt)
	{
		case "B"://BUSCAR
			f.action = "ram_con_gener_circulantes_raf.php?Recarga=S&TipoBusqueda=BM&Buscar=S";
			f.submit();		
			break;		
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "E"://EXCEL	
			f.action = "ram_con_gener_circulantes_raf_excel.php?Recarga=S&TipoBusqueda=BM&Buscar=S";
			f.submit();	
			break;		
		case "S"://SALIR
			frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=7&Nivel=1&CodPantalla=24";
			frmPrincipal.submit();
			break;			
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
-->
</style>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<table width="544"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02" align="center">
    <td colspan="4"><strong>GENERACION DE CIRCULANTES DE FUNDICION Y RAF RECEPCIONADOS EN RECEPCION Y MEZCLA </strong></td>
  </tr>
  <tr class="Colum01">
    <td width="88" class="Colum01">Mes:</td>
    <td width="664" class="Colum01"><?php
			echo "<select name='CmbMes' size='1' style='width:90px;'>";
			for($i=1;$i<13;$i++)
			{
				if ($i==$CmbMes&&$Recarga=='S')
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else if ($i==date("n")&&$Recarga!='S')	
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else	
					echo "<option value='".$i."'>".$meses[$i-1]."</option>";
			}
			echo "</select>";
			echo "<select name='CmbAno' size='1' style='width:70px;'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if ($i==$CmbAno&&$Recarga=='S')
					echo "<option selected value ='$i'>$i</option>";
				else if ($i==date('Y')&&$Recarga!='S')
					echo "<option selected value ='$i'>$i</option>";
				else		
					echo "<option value='".$i."'>".$i."</option>";
			}
			echo "</select>";
			?>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr align="center" class="Colum01">
	  <td height="30" colspan="4" class="Colum01">
		<input name="BtnOK" type="button" value="Buscar" style="width:80px " onClick="Proceso('B')">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I','<?php echo $Petalo?>')">
		<input name="BtnExcel" type="button" value="Excel" style="width:80px " onClick="Proceso('E','<?php echo $Petalo?>')">
		<input name="BtnSalir" type="button" value="Salir" style="width:80px " onClick="Proceso('S')">
	  </td>
	</tr>
  </table>
	<br>
	<table width='800'  border='1' align='center' cellpadding='1' cellspacing='0' class='TablaInterior'>
	<tr align="center" class="ColorTabla01">
	<td width="14" rowspan="2">DIA</td>
	<td colspan="10">Circulantes Fundicion (Ton.)</td>
	<td colspan="4">Circulantes Refino a Fuego (Ton.)</td>
	<td width="14" rowspan="2">TOTAL</td>
	</tr>
	<tr align="center" class="ColorTabla01">
	<td>Cascaron<br>M.Blanco</td>
	<td>Bajo<br>Cuchara</td>
	<td>Polvo<br>Convert.</td>
	<td>Polvo<br>Miljo CPS</td>
	<td>Carga<br>Fria</td>
	<td>Esc. Ret<br>CPS-Basc</td>
	<td>Mbco<br>Pozo</td>
	<td>Concent<br>Sec.-Rec.</td>
	<td>Polvo<br>Miljo H.E</td>
	<td>SubTotal</td>
	<td>Escoria<br>An�dica</td>
	<td>Chatarra<br>RAF</td>
	<td>Granza</td>
	<td>Sub-Total</td>
	</tr>
	<?php
	if($Buscar=='S')
	{
		$FinMes = date("t",mktime(0, 0, 0, $CmbMes, 1, $CmbAno));
		$Tot1=0;$Tot2=0;$Tot3=0;$Tot4=0;$Tot5=0;$Tot6=0;$Tot7=0;$Tot8=0;$Tot9=0;$Tot10=0;$Tot11=0;$Tot12=0;
		$SubTotDia1=0;$SubTotDia2=0;$TotDia=0;
		for($i=1;$i<=$FinMes;$i++)
		{
			$Fecha=$CmbAno."-".$CmbMes."-".$i;
			echo "<tr>";
			echo "<td>$i</td>";
			echo "<td align='right'>0,0</td>";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='20' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot2=$Tot2+($Fila["peso_humedo"]/1000);
				$SubTotDia1=$SubTotDia1+($Fila["peso_humedo"]/1000);	
			}	
			else
				echo "<td align='right'>0,0</td>";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='37' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot3=$Tot3+($Fila["peso_humedo"]/1000);
				$SubTotDia1=$SubTotDia1+($Fila["peso_humedo"]/1000);	
			}	
			else
				echo "<td align='right'>0,0</td>";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='35' and t1.num_conjunto='313' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot4=$Tot4+($Fila["peso_humedo"]/1000);	
				$SubTotDia1=$SubTotDia1+($Fila["peso_humedo"]/1000);
			}	
			else
				echo "<td align='right'>0,0</td>";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='6' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot5=$Tot5+($Fila["peso_humedo"]/1000);	
				$SubTotDia1=$SubTotDia1+($Fila["peso_humedo"]/1000);
			}	
			else
				echo "<td align='right'>0,0</td>";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='17' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot6=$Tot6+($Fila["peso_humedo"]/1000);	
				$SubTotDia1=$SubTotDia1+($Fila["peso_humedo"]/1000);
			}	
			else
				echo "<td align='right'>0,0</td>";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='18' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot7=$Tot7+($Fila["peso_humedo"]/1000);
				$SubTotDia1=$SubTotDia1+($Fila["peso_humedo"]/1000);	
			}	
			else
				echo "<td align='right'>0,0</td>";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='46' and t1.num_conjunto in('350','356') and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot8=$Tot8+($Fila["peso_humedo"]/1000);
				$SubTotDia1=$SubTotDia1+($Fila["peso_humedo"]/1000);	
			}	
			else
				echo "<td align='right'>0,0</td>";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='35' and t1.num_conjunto='321' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot9=$Tot9+($Fila["peso_humedo"]/1000);	
				$SubTotDia1=$SubTotDia1+($Fila["peso_humedo"]/1000);
			}	
			else
				echo "<td align='right'>0,0</td>";
			$SubTot1=$Tot1+$Tot2+$Tot3+$Tot4+$Tot5+$Tot6+$Tot7+$Tot8+$Tot9;
			echo "<td align='right'>".number_format($SubTotDia1,1,',','.')."</td>";				
			
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='19' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot10=$Tot10+($Fila["peso_humedo"]/1000);	
				$SubTotDia2=$SubTotDia2+($Fila["peso_humedo"]/1000);
			}	
			else
				echo "<td align='right'>0,0</td>";
			echo "<td align='right'>0,0</td>";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo from ram_web.movimiento_proveedor t1 ";
			$Consulta.="INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='26' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 and (t1.cod_existencia in(02,17)) and t1.fecha_movimiento ='".$Fecha."' ";
			$Consulta.="GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ";
			$Consulta.="ORDER BY t1.cod_conjunto, t1.num_conjunto	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysqli_fetch_array($Resp))
			{
				echo "<td align='right'>".number_format(($Fila["peso_humedo"]/1000),1,',','.')."</td>";
				$Tot12=$Tot12+($Fila["peso_humedo"]/1000);
				$SubTotDia2=$SubTotDia2+($Fila["peso_humedo"]/1000);
			}	
			else
				echo "<td align='right'>0,0</td>";$CuSucio=0;
			$Fecha1=$Fecha." 08:00:00";
			$Fecha2 =date("Y-m-d", mktime(1,0,0,$CmbMes,($i+1),$CmbAno))." 07:59:59";
			$Consulta="SELECT Sum(t1.peso_humedo) AS peso_humedo FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto) AND (t1.cod_conjunto = t2.cod_conjunto) ";
			$Consulta.="INNER JOIN ram_web.movimiento_conjunto t3 ON (t1.num_conjunto = t3.num_conjunto) AND (t1.conjunto_destino = t3.conjunto_destino) AND (t1.fecha_movimiento = t3.fecha_movimiento) AND case when t1.cod_conjunto='03'";
			$Consulta.="then (t3.cod_existencia = 5 OR t3.cod_existencia = 6 OR t3.cod_existencia = 16) else (t3.cod_existencia <> 5 AND t3.cod_existencia <> 6 AND t3.cod_existencia <> 16) end ";
			$Consulta.="WHERE cod_producto='42' and cod_subproducto='13' and t1.num_conjunto='942' and t1.cod_conjunto in(03) and t2.estado='a' and t1.peso_humedo > 0 ";
			$Consulta.="and (t1.cod_existencia in(05,12,15,16)) and t1.fecha_movimiento between '".$Fecha1."' and '".$Fecha2."' GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto ORDER BY t1.cod_conjunto, t1.num_conjunto ";				
			$Resp=mysqli_query($link, $Consulta);	
			//echo $Consulta."<br>";
			if($Fila=mysqli_fetch_array($Resp))
			{
				$CuSucio=$Fila["peso_humedo"]/1000;
			}
			$SubTot2=$Tot10+$Tot11+$Tot12;
			echo "<td align='right'>".number_format($SubTotDia2+$CuSucio,1,',','.')."</td>";
			$TotDia=$SubTotDia1+$SubTotDia2+$CuSucio;
			echo "<td align='right'>".number_format($TotDia,1,',','.')."</td>";
			echo "</tr>";
			$Tot=$Tot+$SubTotDia1+$SubTotDia2+$CuSucio;
			$SubTotDia1=0;$SubTotDia2=0;
			//$Tot1=0;$Tot2=0;$Tot3=0;$Tot4=0;$Tot5=0;$Tot6=0;$Tot7=0;$Tot8=0;$Tot9=0;$Tot10=0;$Tot11=0;$Tot12=0;
		}
		echo "<tr class='ColorTabla02'>";
		echo "<td>Total</td>";
		echo "<td align='right'>".number_format($Tot1,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot2,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot3,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot4,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot5,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot6,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot7,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot8,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot9,1,',','.')."</td>";
		echo "<td align='right'>".number_format($SubTot1,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot10,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot11,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot12,1,',','.')."</td>";
		echo "<td align='right'>".number_format($SubTot2,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot,1,',','.')."</td>";
		echo "</tr>";
		echo "<tr class='ColorTabla02'>";
		echo "<td>Gen/d</td>";
		echo "<td align='right'>".number_format($Tot1/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot2/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot3/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot4/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot5/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot6/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot7/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot8/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot9/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($SubTot1/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot10/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot11/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot12/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($SubTot2/$FinMes,1,',','.')."</td>";
		echo "<td align='right'>".number_format($Tot/$FinMes,1,',','.')."</td>";
		echo "</tr>";
	}
	?>
	</table>	
</form>
</body>
</html>
