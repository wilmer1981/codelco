<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt,FI,FT,T)//Opcion,año inicio,año termino,turno
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
		case "E":
			f.action="pmn_xls_traspaso_restos_anodos.php?FechaIni="+FI + "&FechaFin="+FT + "&Turno="+T;
			f.submit();
			break;
	}
}
</script>
</head>

<body class="TituloCabeceraOz" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">
  <table width="711" border="0" cellspacing="0" cellpadding="3">
    <?php
	$FechaIni = $AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
	$FechaFin = $AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
	?>
	<tr> 
      <td width="406" align="center" valign="middle"><strong class="titulo_azul">TRASPASO RESTOS DE 
        ANODOS</strong></td>
      <td width="84" align="center" valign="middle"><input name="BtnExcel" type="submit" style="width:70px" id="BtnExcel" value="Excel" onClick="Proceso('E','<?php echo $FechaIni; ?>','<?php echo $FechaFin  ?>','<?php echo $Turno; ?>');"></td>
      <td width="82" align="center" valign="middle"><input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir"></td>
      <td width="115" align="center" valign="middle"> <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
    </tr>
  </table>
<strong> <br>
<br>
</strong> 
  <table width="881" border="1" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
    <tr align="center" valign="middle" class="TituloCabeceraAzul"> 
      <td width="37">FECHA</td>
      <td width="39">TURNO</td>
      <td width="75">STOCK INICIAL</td>
      <td width="73">N&deg; ELECT.</td>
      <td width="57">M</td>
      <td width="70">CANTIDAD OREJAS</td>
      <td width="62">PESO RESTOS</td>
      <td width="74">HORNADA</td>
      <td width="74">BENEFICIO <br>
        R. M.DORE</td>
      <td width="72">STOCK FINAL</td>
      <td width="74">JEFE DE <br>
        TURNO</td>
      <td width="75">OP E AG</td>
    </tr>
    <?php 

	$vector = array(); //0:fecha, 1:cod_turno, 2:nom_turno, 3:num_electrolisis, 4:hornada	
	
	$consulta = "SELECT t1.fecha,t1.turno,t2.nombre_subclase, t1.num_electrolisis, ";
	$consulta.= " CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave";	
	$consulta.= " FROM pmn_web.descarga_electrolisis_plata AS t1";	
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.turno = t2.cod_subclase AND t2.cod_clase = '1'";	
	$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " order by t1.fecha,t1.turno,t1.num_electrolisis";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	$pos=1;
	$FechaAnt="";
	$TurnoAnt="";
	while ($row = mysqli_fetch_array($rs))
	{
		if ($FechaAnt==$row["fecha"] && $TurnoAnt==$row[turno])
			$pos++;
		else
			$pos=1;
		$Clave=$row[clave]."".$pos;
		//echo "elec".$row[num_electrolisis]."-".$row["fecha"];
		$vector[$Clave][0] = $row["fecha"];		
		$vector[$Clave][1] = $row[turno];		
		$vector[$Clave][2] = $row["nombre_subclase"];
		$vector[$Clave][3] = $row[num_electrolisis];
		$vector[$Clave][4] = "";
		
		$FechaAnt=$row["fecha"];
		$TurnoAnt=$row[turno];		
	}
	
	$consulta = "SELECT t1.fecha,t1.turno,t2.nombre_subclase, t1.hornada, ";
	$consulta.= " CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave";	
	$consulta.= " FROM pmn_web.carga_horno_trof AS t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.turno = t2.cod_subclase AND t2.cod_clase = '1'";	
	$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " AND t1.cod_producto = '19' AND t1.cod_subproducto = '17'";
	$consulta.= " GROUP BY t1.fecha,t1.turno";
	//$consulta.= " order by t1.fecha,t1.turno";	
	//echo $consulta."<br>";	
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		if ($FechaAnt==$row["fecha"] && $TurnoAnt==$row[turno])
			$pos++;
		else
			$pos=1;
		$Clave=$row[clave]."".$pos;
		$vector[$Clave][0] = $row["fecha"];
		$vector[$Clave][1] = $row[turno];		
		$vector[$Clave][2] = $row["nombre_subclase"];
		$vector[$Clave][4] = $row["hornada"];
		$FechaAnt=$row["fecha"];
		$TurnoAnt=$row[turno];
	}	
	ksort($vector);		
	$FechaAnt = "";
	$Cont=0;
	reset($vector);
	while (list($c, $v ) = each($vector))
	{
	//echo "ve".$v[0]."-".$v[3]."--".$v[4]; 
		echo "<tr>";
		echo "<td align='left'>".substr($v[0],8,2)."/".substr($v[0],5,2)."/".substr($v[0],0,4)."</td>\n";
		echo "<td align='center'>".$v[2]."</td>";
		$control=0;
		if ($FechaAnt==$v[0] && $TurnoAnt==$v[1])
		{
			$control = 1;
			$StockInicial = $StockFinal;
		}
		else
		{			
			$StockInicial = 0;
			$StockFinal = 0;
			//Consulta para rescatar la fecha minima de la tabla.
			$consulta = "SELECT MIN(fecha) AS fecha FROM pmn_web.descarga_electrolisis_plata";
			$rs3 = mysqli_query($link, $consulta);
			$row3 = mysqli_fetch_array($rs3);
			$FechaMin = $row3["fecha"];
			
			$consulta ="SELECT SUBDATE('".$v[0]."', INTERVAL 1 DAY) AS fecha";
			$rs4 = mysqli_query($link, $consulta);
			$row4 = mysqli_fetch_array($rs4);
			$FechaMax = $row4["fecha"];
					
			//Produccion.
			$consulta = "SELECT IFNULL(SUM(peso_resto),0) AS peso FROM pmn_web.descarga_electrolisis_plata";
			$consulta.= " WHERE fecha BETWEEN '".$FechaMin."' AND '".$FechaMax."'";
			//echo $consulta."<br>";		
			$rs5 = mysqli_query($link, $consulta);
			$row5 = mysqli_fetch_array($rs5);
			
			
				$StockInicial = $StockInicial + $row5["peso"];
				
			//echo $StockInicial;
			//Carga.
			$consulta = "SELECT IFNULL(SUM(cantidad),0) AS peso FROM pmn_web.carga_horno_trof";
			$consulta.= " WHERE fecha BETWEEN '".$FechaMin."' AND '".$FechaMax."'";		
			$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";
			//echo $consulta."<br>";
			$rs6 = mysqli_query($link, $consulta);
			$row6 = mysqli_fetch_array($rs6);
			$StockInicial = $StockInicial - $row6["peso"];
			
			//Ajuste.
			$consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM pmn_web.ajuste_stock";
			$consulta.= " WHERE fecha BETWEEN '".$FechaMin."' AND '".$FechaMax."'";
			$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";		
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			$StockInicial = $StockInicial - $row["peso"];
		}
		$FechaAnt=$v[0];
		$TurnoAnt=$v[1];
								
		switch ($v[1])
		{
			//Turno A.
			case '1':
					if ($control == 0) //para cuendo sean mas de 1 turno = mismo dia)
					//Produccion.
					{
					$consulta = "SELECT IFNULL(SUM(peso_resto),0) AS peso FROM pmn_web.descarga_electrolisis_plata";
					$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '3'";
					$rs7 = mysqli_query($link, $consulta);
					$row7 = mysqli_fetch_array($rs7);
					$StockInicial = $StockInicial + $row7["peso"];
					
					$consulta = "SELECT IFNULL(SUM(cantidad),0) AS peso FROM pmn_web.carga_horno_trof";
					$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '3'";		
					$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";
					$rs8 = mysqli_query($link, $consulta);
					$row8 = mysqli_fetch_array($rs8);
					$StockInicial = $StockInicial - $row8["peso"];
					break;
				}	
			//Turno B.					
			case '2':
					if ($control == 0)
					{		
					//Produccion.
					$consulta = "SELECT IFNULL(SUM(peso_resto),0) AS peso FROM pmn_web.descarga_electrolisis_plata";
					$consulta.= " WHERE fecha = '".$v[0]."' AND turno IN ('1','3')";
					
					$rs7 = mysqli_query($link, $consulta);
					$row7 = mysqli_fetch_array($rs7);
					$StockInicial = $StockInicial + $row7["peso"];
					
					$consulta = "SELECT IFNULL(SUM(cantidad),0) AS peso FROM pmn_web.carga_horno_trof";
					$consulta.= " WHERE fecha = '".$v[0]."' AND turno IN ('1','3')";		
					$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";
					
					$rs8 = mysqli_query($link, $consulta);
					$row8 = mysqli_fetch_array($rs8);
					$StockInicial = $StockInicial - $row8["peso"];			
					break;
					}
			//Turno C.					
			case '3':
					break;
		}
		//StockInicial.
		echo "<td align='right'>".number_format($StockInicial,4,",","")."</td>";			
		$StockFinal = $StockInicial;
		$consulta = "SELECT * FROM pmn_web.descarga_electrolisis_plata";
		$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '".$v[1]."' AND num_electrolisis='".$v[3]."'";
		//echo $consulta."<br>";
		$rs1 = mysqli_query($link, $consulta);
		//while ($row1=mysqli_fetch_array($rs1))
		if ($row1 = mysqli_fetch_array($rs1))
		{	
			echo "<td align='center'>".$row1[num_electrolisis]."</td>";
			echo "<td align='center'>".$row1["grupo"]."</td>";
			echo "<td align='center'>".$row1[cant_orejas]."</td>";		
			echo "<td align='right'>".number_format($row1[peso_resto],4,",","")."</td>";			
			$StockFinal = $StockFinal + $row1[peso_resto];	
			
		}
		else
		{	
			echo "<td>&nbsp;</td>";			
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";									
		}
			
		//Resto Metal Dore.
		$consulta = "SELECT hornada, IFNULL(SUM(cantidad),0) AS cant FROM pmn_web.carga_horno_trof";
		$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '".$v[1]."'";
		$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";
		$consulta.= " GROUP BY hornada";
		//echo $consulta."<br>";
		$rs2 = mysqli_query($link, $consulta);
		$row2 = mysqli_fetch_array($rs2);
		$StockFinal = $StockFinal - $row2["cant"];
		echo "<td align='center'>".$row2["hornada"]."&nbsp;</td>";		
		echo "<td align='right'>".number_format($row2["cant"],4,",","")."</td>";
				
		//StockFinal.
		echo "<td align='right'>".number_format($StockFinal,4,",","")."</td>";
				
		//Operador.
		$consulta = "SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut = '".$row1[jefe_turno]."'";		
		$rs9 = mysqli_query($link, $consulta);
		if ($row9 = mysqli_fetch_array($rs9))
			echo "<td>".strtoupper(substr($row9["nombres"],0,1)).". ".ucwords(strtolower($row9["apellido_paterno"]))."</td>";						
		else
			echo "<td>&nbsp;</td>";		
		
		$consulta = "SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut = '".$row1[operador]."'";		
		$rs10 = mysqli_query($link, $consulta);
		if ($row10 = mysqli_fetch_array($rs10))
			echo "<td>".strtoupper(substr($row10["nombres"],0,1)).". ".ucwords(strtolower($row10["apellido_paterno"]))."</td>";
		else
			echo "<td>&nbsp;</td>";		
			echo "</tr>";
	}		
?>
  </table>
</form>
</body>
</html>
