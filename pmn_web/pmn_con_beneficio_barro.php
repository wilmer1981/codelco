<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f= document.frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.history.back();
			break;
	}
}
function Excel(FechaI,FechaT,T)
{
	var f=document.frmPrincipal;
	f.action="pmn_xls_beneficio_barro.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body class="TituloCabeceraOz" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">
<?php
 $FechaIni = $AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
 $FechaFin = $AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
?>	
  <table width="749" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="477" align="center" valign="middle"><strong class="titulo_azul">BENEFICIO BARRO ANODICO 
        DESCOBRIZADO</strong></td>
      <td width="76" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="178" align="center" valign="middle"><div align="left">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
        </div></td>
    </tr>
  </table>
<strong> <br>
<br>
</strong> 
  <table width="850" border="1" cellspacing="0" cellpadding="3" class="TituloCabeceraAzul">
    <tr align="center" valign="middle" class="TituloCabeceraAzul"> 
      <td width="35" rowspan="2">FECHA</td>
      <!--<td width="39" rowspan="2">TURNO</td>-->
      <td width="76" height="21">STOCK</td>
      <td width="65" rowspan="2">N&ordm; LIXIV.</td>
      <td width="84" rowspan="2">PRODUCCION</td>
      <td colspan="2">BENEFICIO</td>
      <!--<td width="67">HORA</td>-->
      <!--<td width="69" rowspan="2">AJUSTE</td>-->
      <td width="77">STOCK</td>
      <td width="103" rowspan="2">JEFE DE <br>
        TURNO</td>
      <td width="98" rowspan="2">OP. PTA LIX.</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center" valign="middle">INICIAL</td>
      <!--<td align="center" valign="middle">KG</td>-->
      <td width="82" align="center" valign="middle">HORNADA N&deg;</td>
      <td width="78"> <div align="center">PESO H<sub>2</sub>O</div></td>
      <!--<td width="67"><div align="center">PROCESO</div></td>-->
      <td width="77"><div align="center">FINAL</div></td>
    </tr>
    <?php 
	//LLena arreglo con fecha-turno.
	$vector = array(); //1:fecha, 0:cod_turno, 2:nom_turno.

	$consulta = "SELECT fecha, ceiling(turno) as TurnoOrd, nombre_subclase, CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave";
	$consulta.= " FROM pmn_web.detalle_deselenizacion as t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.turno = t2.cod_subclase AND cod_clase ='1'";
	$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' AND tipo = 'L' ";
	$consulta.= " GROUP BY fecha,turno";
	$consulta.= " ORDER BY TurnoOrd,fecha";		
	$rs10 = mysqli_query($link, $consulta);
	while ($row10 = mysqli_fetch_array($rs10))
	{	
		//$Clave=intval(str_replace('-','',$row10["fecha"])).$row10[TurnoOrd];
		$vector[$row10[clave]][0] = $row10[TurnoOrd];
		$vector[$row10[clave]][1] = $row10["fecha"];
		$vector[$row10[clave]][2] = $row10["nombre_subclase"];
	}
	
	$consulta = "SELECT fecha, ceiling(turno) as TurnoOrd, nombre_subclase, CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave";
	$consulta.= " FROM pmn_web.lixiviacion_barro_anodico AS t1";	
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.turno = t2.cod_subclase AND cod_clase ='1'";
	$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' and '".$FechaFin."'";
	$consulta.= " GROUP BY fecha,turno";
	$consulta.= " ORDER BY TurnoOrd,t1.fecha";
	//echo $consulta."<br>";
	$rs11 = mysqli_query($link, $consulta);
	while ($row11 = mysqli_fetch_array($rs11))
	{	
		//echo $row11[TurnoOrd]."  ".$row11["fecha"]."<br >";
		//$Clave=intval(str_replace('-','',$row11["fecha"])).$row11[TurnoOrd];
		$Clave=$row11[TurnoOrd];
		$vector[$row11[clave]][0] = $row11[TurnoOrd];
		$vector[$row11[clave]][1] = $row11["fecha"];
		$vector[$row11[clave]][2] = $row11["nombre_subclase"];
	}
	
	$consulta = "SELECT fecha, ceiling(cod_turno) as turnoOrd, nombre_subclase, CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave";
	$consulta.= " FROM pmn_web.ajuste_stock AS t1";	
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.cod_turno = t2.cod_subclase AND cod_clase = '1'";
	$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " AND t1.cod_producto = '25' AND t1.cod_subproducto = '1'";
	$consulta.= " GROUP BY fecha,cod_turno";
	$consulta.= " ORDER BY turnoOrd,t1.fecha";		
	$rs11 = mysqli_query($link, $consulta);
	while ($row11 = mysqli_fetch_array($rs11))
	{	
		//$Clave=intval(str_replace('-','',$row11["fecha"])).$row11[TurnoOrd];
		$Clave=$row11[TurnoOrd];
		$vector[$row11[clave]][0] = $row11[turnoOrd];
		$vector[$row11[clave]][1] = $row11["fecha"];
		$vector[$row11[clave]][2] = $row11["nombre_subclase"];
	}	
	
	ksort($vector);

	/*while (list($c,$v) = each($vector))
	{
		echo $v[0].'-'.$v[1].'    '.$v[2]."<br>";
	}*/
	
	//---.
	
	reset($vector);$StockInicial = 0;$Vuelta=1;
	while(list($c,$v) = each($vector))
	{
		//echo "<br><br><br>";
		
		
		//Consulta para rescatar la fecha minima de la tabla
		$Consulta ="select min(fecha) as fechita from pmn_web.lixiviacion_barro_anodico ";
		$Resp1=mysqli_query($link, $Consulta);
		$Fil1=mysqli_fetch_array($Resp1);
		$Consulta ="select  subdate('".$v[1]."',interval 1 day)as dia_anterior ";
		$Resp2=mysqli_query($link, $Consulta);
		$Fil2=mysqli_fetch_array($Resp2);
		
		/*$Consulta= "select IFNULL(sum(bad),0) as suma_total_anterior from pmn_web.lixiviacion_barro_anodico  ";
		$Consulta.=" where fecha between '".$Fil1[fechita]."' and '".$Fil2[dia_anterior]."' "; 
		//echo "mas: ".$Consulta."<br>";
		$Respuesta1=mysqli_query($link, $Consulta);
		$Fila1=mysqli_fetch_array($Respuesta1); 		
		$StockInicial = $Fila1[suma_total_anterior];				
		
		$Consulta= "select IFNULL(sum(bad),0) as suma_total_anterior_dese from pmn_web.detalle_deselenizacion  ";
		$Consulta.=" where fecha between '".$Fil1[fechita]."' and '".$Fil2[dia_anterior]."' and tipo = 'L' "; 
		//echo "menos: ".$Consulta."<br>";
		$Respu=mysqli_query($link, $Consulta);
		$Fi=mysqli_fetch_array($Respu); 
		$StockInicial = $StockInicial - $Fi[suma_total_anterior_dese];*/				
		
		//-- Ajuste Anterior.
		/*$consulta = "SELECT IFNULL(SUM(CASE WHEN tipo='+' THEN peso ELSE (-1 * peso) END),0) AS valor";
		$consulta.= " FROM pmn_web.ajuste_stock AS t1";
		$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
		$consulta.= " ON t1.cod_turno = t2.cod_subclase and t2.cod_clase = '1'";
		$consulta.= " WHERE t1.fecha BETWEEN '".$Fil1[fechita]."' and '".$Fil2[dia_anterior]."' AND t1.cod_producto = '25' AND t1.cod_subproducto = '1'" ;*/		
		
		if($Vuelta==1)
		{
			$Consultap="select sf_p from pmn_web.stock_pmn where ano='".substr($Fil2[dia_anterior],0,4)."' and mes='".substr($Fil2[dia_anterior],5,2)."' AND cod_producto = '25' AND cod_subproducto = '1'";
			$rs5 = mysqli_query($link, $Consultap);
			$row5 = mysqli_fetch_array($rs5);
			$StockInicial = $row5[sf_p];
		}
		switch ($v[0])
		{
			//Turno A
			case "1":
				//Consulta para la lixiviacion
				/*$Consulta= "select IFNULL(sum(bad),0) as suma_dia_turno_C from pmn_web.lixiviacion_barro_anodico  ";
				$Consulta.=" where fecha = '".$v[1]."' and turno = '3' "; 
				//echo "mas: ".$Consulta."<br>";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2); 
				$StockInicial = $StockInicial + $Fila2[suma_dia_turno_C];
				
				//Consulta para la deselenizacion
				$Consulta= "select IFNULL(sum(bad),0) as suma_dia_turno_C from pmn_web.detalle_deselenizacion  ";
				$Consulta.=" where fecha = '".$v[1]."' and turno = '3'  and tipo = 'L' "; 
				//echo "menos: ".$Consulta."<br>";
				$Respuesta5=mysqli_query($link, $Consulta);
				$Fila5=mysqli_fetch_array($Respuesta5); 
				$StockInicial = $StockInicial - $Fila5[suma_dia_turno_C];*/
				
				/*$consulta = "SELECT IFNULL(SUM(CASE WHEN tipo='+' THEN peso ELSE (-1 * peso) END),0) AS valor";
				$consulta.= " FROM pmn_web.ajuste_stock AS t1";
				$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
				$consulta.= " ON t1.cod_turno = t2.cod_subclase and t2.cod_clase = '1'";
				$consulta.= " WHERE t1.fecha = '".$v[1]."' and cod_turno = '3' AND t1.cod_producto = '25' AND t1.cod_subproducto = '1'" ;*/		
				$Consulta="select sf_p from pmn_web.stock_pmn where ano='".substr($v[1],0,4)."' and mes='".substr($v[1],5,2)."' AND t1.cod_producto = '25' AND t1.cod_subproducto = '1'";
				//echo "ajuste: ".$consulta."<br>";
				$rs6 = mysqli_query($link, $consulta);
				$row6 = mysqli_fetch_array($rs6);
				$StockInicial = $StockInicial + $row6[sf_p];
				break;
			//turno B
			case "2":
				//Consulta para la lixiviacion
				/*$Consulta= "select IFNULL(sum(bad),0) as suma_dia_turno_A from pmn_web.lixiviacion_barro_anodico  ";
				$Consulta.=" where fecha = '".$v[1]."' and turno in ('1', '3')"; 
				//echo "mas: ".$Consulta."<br>";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2); 
				$StockInicial = $StockInicial + $Fila2[suma_dia_turno_A];

				//Consulta para la deselenizacion
				$Consulta= "select IFNULL(sum(bad),0) as suma_dia_turno_A from pmn_web.detalle_deselenizacion  ";
				$Consulta.=" where fecha = '".$v[1]."' and turno in ('1', '3') and tipo = 'L' "; 
				//echo "menos: ".$Consulta."<br>";
				$Respuesta4=mysqli_query($link, $Consulta);
				$Fila4=mysqli_fetch_array($Respuesta4); 
				$StockInicial = $StockInicial - $Fila4[suma_dia_turno_A];*/

				/*$consulta = "SELECT IFNULL(SUM(CASE WHEN tipo='+' THEN peso ELSE (-1 * peso) END),0) AS valor";
				$consulta.= " FROM pmn_web.ajuste_stock AS t1";
				$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
				$consulta.= " ON t1.cod_turno = t2.cod_subclase and t2.cod_clase = '1'";
				$consulta.= " WHERE t1.fecha = '".$v[1]."' and cod_turno in ('1','3') AND t1.cod_producto = '25' AND t1.cod_subproducto = '1'" ;*/		
				$Consulta="select sf_p from pmn_web.stock_pmn where ano='".substr($v[1],0,4)."' and mes='".substr($v[1],5,2)."' AND t1.cod_producto = '25' AND t1.cod_subproducto = '1'";
				//echo "ajuste: ".$consulta."<br>";
				$rs6 = mysqli_query($link, $consulta);
				$row6 = mysqli_fetch_array($rs6);
				$StockInicial = $StockInicial + $row6[sf_p];			
				break;
			//turno C
			case "3":				
				break;
		}		

		// Cuenta los registros de beneficios.
		$Consulta = "SELECT * ";		
		$Consulta.= " FROM pmn_web.detalle_deselenizacion WHERE turno = '".$v[0]."' AND fecha = '".$v[1]."' AND tipo = 'L'";		
		$Consulta.= " GROUP BY num_horno,num_funda,hornada_total,hornada_parcial";
		//echo $Consulta."<br>"; 
		$rs1 = mysqli_query($link, $Consulta);
		$TotalFila = mysql_num_rows($rs1);
		$Cont = $TotalFila;	
	
		if ($TotalFila != "0")
		{
			$Consulta ="select CONCAT(num_horno,'-',num_funda,'-',hornada_total,'-',hornada_parcial) AS hornada,SUM(bad) AS bad";		
			$Consulta.= " from pmn_web.detalle_deselenizacion where turno = '".$v[0]."' and fecha = '".$v[1]."'";
			$Consulta.= " and tipo = 'L'";		
			$Consulta.= " GROUP BY num_horno,num_funda,hornada_total,hornada_parcial";
			//echo $Consulta."<br>";
			$rs2 = mysqli_query($link, $Consulta);						
			while ($row2 = mysqli_fetch_array($rs2))
			{			
				//---. BENNEFICIO.
	
				echo "<tr>";											
				if ($Cont == $TotalFila)
				{
					echo "<td align='center' rowspan='".$TotalFila."'>".substr($v[1],8,2)."/".substr($v[1],5,2)."/".substr($v[1],0,4)."&nbsp;</td>\n";
					/*echo "<td rowspan='".$TotalFila."'>".$v[2]."&nbsp;</td>";*/							
				
					//--. STOCK INICIAL.					
					echo "<td rowspan='".$TotalFila."' align='right'>".number_format($StockInicial,2,",","")."&nbsp;</td>";
					//--. PRODUCCION.		
					$Consulta = "select num_lixiviacion, IFNULL(sum(bad),0) as suma_bad from pmn_web.lixiviacion_barro_anodico where fecha = '".$v[1]."' and turno = '".$v[0]."' GROUP BY num_lixiviacion"; 
					//echo "mas: ".$Consulta."<br>";		
					$Respuesta6=mysqli_query($link, $Consulta);
					$Fila6=mysqli_fetch_array($Respuesta6);
					echo "<td rowspan='".$TotalFila."' align='center'>".$Fila6["num_lixiviacion"]."&nbsp;</td>";					
					echo "<td rowspan='".$TotalFila."' align='right'>".number_format($Fila6["suma_bad"],2,",","")."&nbsp;</td>";
				}
					
				echo "<td align='right'>".$row2["hornada"]."&nbsp;</td>";		
				echo "<td align='right'>".number_format($row2["bad"],3,",","")."&nbsp;</td>";
				$Valor3=$Valor3+$row2["bad"];
				
				if ($Cont == $TotalFila)
				{	
					$Cont++;			
					//---. HORA PROCESO.
					$Consulta="select hora_filtracion,operador_analisis,jefe_turno_analisis from pmn_web.lixiviacion_barro_anodico where fecha = '".$v[1]."' and turno = '".$v[0]."' ";
					$Respuesta8=mysqli_query($link, $Consulta);
					$Fila8=mysqli_fetch_array($Respuesta8); 
					/*echo "<td rowspan='".$TotalFila."' align='center'>".$Fila8["hora_filtracion"]."&nbsp;</td>";*/
					//---. AJUSTE.
					/*$consulta = "SELECT tipo,peso, CASE WHEN tipo='+' THEN peso ELSE (-1 * peso) END AS valor";
					$consulta.= " FROM pmn_web.ajuste_stock AS t1";
					$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
					$consulta.= " ON t1.cod_turno = t2.cod_subclase and t2.cod_clase = '1'";
					
					$consulta.= " WHERE t1.fecha = '".$v[0]."' AND t1.cod_turno = '".$v[1]."' AND t1.cod_producto = '25' AND t1.cod_subproducto = '1'" ;*/
					/*$consulta="select ajuste_posi_p,ajuste_nega_p from pmn_web.stock_pmn where ano='".substr($v[1],0,4)."' and mes='".substr($v[1],5,2)."' AND cod_producto = '25' AND cod_subproducto = '1'";
					$rs = mysqli_query($link, $consulta);
					$row = mysqli_fetch_array($rs);
					echo "<td rowspan='".$TotalFila."' align='right'>".number_format($row[ajuste_posi_p]-$row[ajuste_nega_p],3,",","")."&nbsp;</td>";*/		
					//--.
					$Consulta ="select SUM(bad) AS bad";		
					$Consulta.= " from pmn_web.detalle_deselenizacion where turno = '".$v[0]."' and fecha = '".$v[1]."'";
					$Consulta.= " and tipo = 'L'";		
					
					$rs8 = mysqli_query($link, $Consulta);
					$row8 = mysqli_fetch_array($rs8);
					//Suma de stock final
					$StockFinal=($StockInicial + $Fila6["suma_bad"]) - $row8["bad"] + $row["valor"];
					//$StockFinal=($StockInicial) - $row8["bad"] + $row["valor"];
									
					echo "<td rowspan='".$TotalFila."' align='right'>".number_format($StockFinal,2,",","")."&nbsp;</td>";		
					$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Fila8["jefe_turno_analisis"]."'";
					$Respuesta9 = mysqli_query($link, $Consulta);
					if ($Fila9 = mysqli_fetch_array($Respuesta9))
					{
						echo "<td align='left' rowspan='".$TotalFila."'>".strtoupper(substr($Fila9["nombres"],0,1)).". ".ucwords(strtolower($Fila9["apellido_paterno"]))."</td>\n";
					}
					else
					{
						echo "<td align='left' rowspan='".$TotalFila."'>&nbsp;</td>\n";
					}
					$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Fila8["operador_analisis"]."'";
					//echo $Consulta."<br>";
					$Respuesta10 = mysqli_query($link, $Consulta);
					if ($Fila10 = mysqli_fetch_array($Respuesta10))
					{
						echo "<td align='left' rowspan='".$TotalFila."'>".strtoupper(substr($Fila10["nombres"],0,1)).". ".ucwords(strtolower($Fila10["apellido_paterno"]))."</td>\n";
					}
					else
					{
						echo "<td align='left' rowspan='".$TotalFila."'>&nbsp;</td>\n";
					}
				}
				echo "</tr>";
			}		
			$Valor2=$Valor2+$Fila6["suma_bad"];
		}
		else
		{
			echo "<tr>";											
			echo "<td align='center' rowspan='".$TotalFila."'>".substr($v[1],8,2)."/".substr($v[1],5,2)."/".substr($v[1],0,4)."&nbsp;</td>\n";
			/*echo "<td rowspan='".$TotalFila."'>".$v[2]."&nbsp;</td>";		*/
			
			//--. STOCK INICIAL.
			echo "<td rowspan='".$TotalFila."' align='right'>".number_format($StockInicial,2,",","")."&nbsp;</td>";
			//--. PRODUCCION.		
			$Consulta = "select num_lixiviacion, IFNULL(sum(bad),0) as suma_bad from pmn_web.lixiviacion_barro_anodico where fecha = '".$v[1]."' and turno = '".$v[0]."' GROUP BY num_lixiviacion"; 
			//echo $Consulta."<br>";		
			$Respuesta6=mysqli_query($link, $Consulta);
			$Fila6=mysqli_fetch_array($Respuesta6);
			echo "<td rowspan='".$TotalFila."' align='center'>".$Fila6["num_lixiviacion"]."&nbsp;</td>";
			echo "<td rowspan='".$TotalFila."' align='right'>".number_format($Fila6["suma_bad"],2,",","")."&nbsp;</td>";		
						
			//---. BENNEFICIO.			
			echo "<td>&nbsp;</td>";		
			echo "<td>&nbsp;</td>";			
			
			//---. HORA PROCESO.
			$Consulta="select hora_filtracion,operador_analisis,jefe_turno_analisis from pmn_web.lixiviacion_barro_anodico where fecha = '".$v[1]."' and turno = '".$v[0]."' ";
			$Respuesta8=mysqli_query($link, $Consulta);
			$Fila8=mysqli_fetch_array($Respuesta8); 
			/*echo "<td rowspan='".$TotalFila."' align='center'>".$Fila8["hora_filtracion"]."&nbsp;</td>";*/
			//---. AJUSTE.
			/*$consulta = "SELECT tipo,peso, CASE WHEN tipo='+' THEN peso ELSE (-1 * peso) END AS valor";
			$consulta.= " FROM pmn_web.ajuste_stock AS t1";
			$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
			$consulta.= " ON t1.cod_turno = t2.cod_subclase and t2.cod_clase = '1'";
			$consulta.= " WHERE t1.fecha = '".$v[0]."' AND t1.cod_turno = '".$v[1]."' AND t1.cod_producto = '25' AND t1.cod_subproducto = '1'" ;*/
			
			/*$consulta="select ajuste_posi_p,ajuste_nega_p from pmn_web.stock_pmn where ano='".substr($v[1],0,4)."' and mes='".substr($v[1],5,2)."' AND cod_producto = '25' AND cod_subproducto = '1'";
			//echo $consulta."<br>";
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			echo "<td rowspan='".$TotalFila."' align='right'>".$row[tipo].number_format($row["peso"],3,",","")."&nbsp;</td>";*/		
			//--.
			//Suma de stock final
			$Consulta ="select SUM(bad) AS bad";		
			$Consulta.= " from pmn_web.detalle_deselenizacion where turno = '".$v[0]."' and fecha = '".$v[1]."'";
			$Consulta.= " and tipo = 'L'";		
			
			$rs8 = mysqli_query($link, $Consulta);
			$row8 = mysqli_fetch_array($rs8);			
			$StockFinal=($StockInicial + $Fila6["suma_bad"]) - $row8["bad"] + $row["valor"];
			//$StockFinal=($StockInicial) - $row8["bad"] + $row["valor"];
							
			echo "<td rowspan='".$TotalFila."' align='right'>".number_format($StockFinal,2,",","")."&nbsp;</td>";		
			$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Fila8["jefe_turno_analisis"]."'";
			$Respuesta9 = mysqli_query($link, $Consulta);
			if ($Fila9 = mysqli_fetch_array($Respuesta9))
			{
				echo "<td align='left' rowspan='".$TotalFila."'>".strtoupper(substr($Fila9["nombres"],0,1)).". ".ucwords(strtolower($Fila9["apellido_paterno"]))."</td>\n";
			}
			else
			{
				echo "<td align='left' rowspan='".$TotalFila."'>&nbsp;</td>\n";
			}
			$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Fila8["operador_analisis"]."'";
			$Respuesta10 = mysqli_query($link, $Consulta);
			
			if ($Fila10 = mysqli_fetch_array($Respuesta10))
			{
				echo "<td align='left' rowspan='".$TotalFila."'>".strtoupper(substr($Fila10["nombres"],0,1)).". ".ucwords(strtolower($Fila10["apellido_paterno"]))."</td>\n";
			}
			else
			{
				echo "<td align='left' rowspan='".$TotalFila."'>&nbsp;</td>\n";
			}
			echo "</tr>";			
			$Valor2=$Valor2+$Fila6["suma_bad"];
			//$Valor3=$Valor3+$row8["bad"];
		}
		$StockInicial=$StockFinal;
		$Vuelta++;
	}
?>
  <tr>
  <td class="titulo_cafe_bold">Totales</td>
  <td class="titulo_cafe_bold" align="right">&nbsp;<?php //echo $Valor1;?></td>
  <td class="titulo_cafe_bold" align="right">&nbsp;</td>
  <td class="titulo_cafe_bold" align="right"><?php echo $Valor2;?></td>
  <td class="titulo_cafe_bold" align="right">&nbsp;</td>
  <td class="titulo_cafe_bold" align="right"><?php echo $Valor3;?></td>
  <td class="titulo_cafe_bold" align="right">&nbsp;</td>
  <td class="titulo_cafe_bold" align="right" colspan="2">&nbsp;</td>
  </tr>	
  </table>
</form>
</body>
</html>