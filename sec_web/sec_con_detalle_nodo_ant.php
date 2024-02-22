<?php
	include("../principal/conectar_principal.php");
	$Consulta = "SELECT * from proyecto_modernizacion.nodos where cod_nodo = '".$Nodo."'";
	$Resp2 = mysqli_query($link, $Consulta);
	$Descripcion = "&nbsp;";
	if ($Fila2 = mysqli_fetch_array($Resp2))
	{
		$Descripcion = $Fila2["descripcion"];
	}
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../Principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../Principal/imagenes/fondo3.gif">
<strong>DETALLE DEL NODO: <?php echo $Nodo." - ".$Descripcion ?></strong><br>
<br>
<table width="650" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr align="center" class="ColorTabla01"> 
    <td rowspan="2">+/-</td>
    <td rowspan="2">FLUJO</td>
    <td rowspan="2">DESCRIPCION</td>
    <td rowspan="2">PESO</td>
    <td colspan="3" align="center">LEYES</td>
    <td colspan="3" align="center">FINO</td>
  </tr>
  <tr class="ColorTabla01"> 
    <td height="25" align="center">Cu</td>
    <td align="center">Ag</td>
    <td align="center">Au</td>
    <td align="center">Cu</td>
    <td align="center">Ag</td>
    <td align="center">Au</td>
  </tr> 
  <?php
  	$PesoTotal = 0;
	$FinoCu = 0;
	$FinoAg = 0;
	$FinoAu = 0; 
  	//EXISTENCIAS DEL MES PASADO
	if ($Mes == 1)
		$AnoAnterior = $Ano - 1;
	else
		$AnoAnterior = $Ano;
	
	$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso, ";
	$Consulta.= " IFNULL(SUM(fino_cu),0) AS fino_cu, ";
	$Consulta.= " IFNULL(SUM(fino_ag),0) AS fino_ag, ";
	$Consulta.= " IFNULL(SUM(fino_au),0) AS fino_au";
	$Consulta.= " FROM sec_web.existencia_nodo";
	$Consulta.= " WHERE nodo = '".$Nodo."'";
	$Consulta.= " AND ano = '".$AnoAnterior."' ";
	$Consulta.= " AND mes = MONTH(SUBDATE('2004-".$Mes."-01', INTERVAL 1 MONTH))";
	$RespAux = mysqli_query($link, $Consulta);
	$Fila2 = mysqli_fetch_array($RespAux);
	if ($Fila2["peso"] > 0)
	{
		$PesoTotal = $PesoTotal + $Fila2["peso"];
		$FinoCu = $FinoCu + $Fila2["fino_cu"];
		$FinoAg = $FinoAg + $Fila2["fino_ag"];
		$FinoAu = $FinoAu + $Fila2["fino_au"];			
		$Cont = $Cont + 1;
		echo "<tr>";
		echo "<td align='center'>+</td>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td>EXISTENCIAS INICIAL</td>";
		echo "<td align='right'>".number_format($Fila2["peso"],0,",",".")."</td>";
		echo "<td align='right'>".number_format((($Fila2["fino_cu"]/$Fila2["peso"])*100),2,",",".")."</td>";
		echo "<td align='right'>".number_format((($Fila2["fino_ag"]/$Fila2["peso"])*1000),2,",",".")."</td>";
		echo "<td align='right'>".number_format((($Fila2["fino_au"]/$Fila2["peso"])*1000),2,",",".")."</td>";
		echo "<td align='right'>".number_format($Fila2["fino_cu"],0,",",".")."</td>";
		echo "<td align='right'>".number_format($Fila2["fino_ag"],0,",",".")."</td>";
		echo "<td align='right'>".number_format($Fila2["fino_au"],0,",",".")."</td>";			
		echo "</tr>";
	}
	//FIN EXISTENCIAS DEL MES ANTERIOR
	$Consulta = "SELECT cod_flujo FROM proyecto_modernizacion.flujos";
	$Consulta.= " WHERE sistema = 'SEC' and nodo = '".$Nodo."' ORDER BY nodo";
	$Respuesta = mysqli_query($link, $Consulta);   	        
	while ($Fila = mysqli_fetch_array($Respuesta))
	{		
		$Consulta = "SELECT t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au, t2.tipo ";
		$Consulta.= " from sec_web.flujos_mes t1 inner join proyecto_modernizacion.flujos t2 ";
		$Consulta.= " on t1.flujo = t2.cod_flujo ";
		$Consulta.= " where t1.ano = '".$Ano."'";
		$Consulta.= " and t1.mes = '".$Mes."'";
		$Consulta.= " and t1.flujo = '".$Fila["cod_flujo"]."'";
		$Consulta.= " and t2.nodo = '".$Nodo."'";
		$Consulta.= " and t2.sistema = 'SEC'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{
			echo "<tr>";
			if ($Fila2["tipo"] == "E")
			{
				$Signo = "+";
				$PesoTotal = $PesoTotal + $Fila2["peso"];
				$FinoCu = $FinoCu + $Fila2["fino_cu"];
				$FinoAg = $FinoAg + $Fila2["fino_ag"];
				$FinoAu = $FinoAu + $Fila2["fino_au"];
			}
			else
			{
				$Signo = "-";
				$PesoTotal = $PesoTotal - $Fila2["peso"];
				$FinoCu = $FinoCu - $Fila2["fino_cu"];
				$FinoAg = $FinoAg - $Fila2["fino_ag"];
				$FinoAu = $FinoAu - $Fila2["fino_au"];
			}
			echo "<td align='center'>".$Signo."</td>";
			echo "<td align='center'>".$Fila2["flujo"]."</td>";
			echo "<td>".$Fila2["descripcion"]."</td>";
			echo "<td align='right'>".number_format($Fila2["peso"],0,",",".")."</td>";
			if ($Fila2["fino_cu"] > 0 && $Fila2["peso"] > 0)
				echo "<td align='right'>".number_format((($Fila2["fino_cu"]/$Fila2["peso"])*100),2,",",".")."</td>";
			else	echo "<td align='right'>0</td>";
			if ($Fila2["fino_ag"] > 0 && $Fila2["peso"] > 0)
				echo "<td align='right'>".number_format((($Fila2["fino_ag"]/$Fila2["peso"])*1000),2,",",".")."</td>";
			else	echo "<td align='right'>0</td>";
			if ($Fila2["fino_au"] > 0 && $Fila2["peso"] > 0)
				echo "<td align='right'>".number_format((($Fila2["fino_au"]/$Fila2["peso"])*1000),2,",",".")."</td>";
			else	echo "<td align='right'>0</td>";
			echo "<td align='right'>".number_format($Fila2["fino_cu"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila2["fino_ag"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila2["fino_au"],0,",",".")."</td>";			
			echo "</tr>";
		}
	}
?>
 <tr>
    <td colspan="3"><strong>TOTAL NODO</strong></td>
	<td align="right"><?php echo number_format($PesoTotal,0,",","."); ?></td>
    <td align="right"><?php 
		if ($FinoCu > 0 && $PesoTotal > 0)
			echo number_format((($FinoCu/$PesoTotal)*100),2,",","."); 
		else echo "0";
	?></td>
    <td align="right"><?php 
		if ($FinoAg > 0 && $PesoTotal > 0)
			echo number_format((($FinoAg/$PesoTotal)*1000),2,",","."); 
		else echo "0";
			?></td>
    <td align="right"><?php 
		if ($FinoAu > 0 && $PesoTotal > 0)
			echo number_format((($FinoAu/$PesoTotal)*1000),2,",","."); 
		else echo "0";
	?></td>
    <td align="right"><?php echo number_format($FinoCu,0,",","."); ?></td>
    <td align="right"><?php echo number_format($FinoAg,0,",","."); ?></td>
    <td align="right"><?php echo number_format($FinoAu,0,",","."); ?></td>
  </tr>
</table>
</body>
</html>
