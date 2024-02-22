<?
	include("../principal/conectar_pac_web.php");
	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;

	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;

	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;
	$Fecha_Ant = date("Y-m-d",mktime(7,59,59,$Mes,($Dia - 1),$Ano));
	$Fecha_Post = date("Y-m-d",mktime(7,59,59,$Mes,($Dia + 1),$Ano));

?>

<html>
<head>
<title>Carga Nave De Hornos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Proceso(opc)
{
	var f = document.FrmPrincipal;
	
	switch(opc)
	{
		case "P":
			f.BtnImprimir.style.visibility = 'hidden';
			f.BtnSalir.style.visibility = 'hidden';
			window.print();
			f.BtnImprimir.style.visibility = '';
			f.BtnSalir.style.visibility = '';
			break;

		case "S":
			window.history.back();
			break;
	}
	
}	
</script>	

</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body class="TablaPrincipal">
<form name="FrmPrincipal" method="post" action="">
  <table width="350" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">
    <tr>
      <td align="center"><b>CONTROL CARGA NAVE DE HORNOS</b></td>
    </tr>
  </table> 	
  <br>
  <table width="140" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">
    <tr>
      <td><b>Fecha: </b><? echo $Dia.'-'.$Mes.'-'.$Ano; ?></td>
    </tr>
  </table> 	
  <br>
  <table width="1200" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">
    <tr class="ColorTabla01"> 
      <td>&nbsp;</td>
      <td align="center" colspan="10">T U R N O&nbsp;&nbsp;A</td>
      <td align="center" colspan="8">T U R N O&nbsp;&nbsp;B</td>
      <td align="center" colspan="8">T U R N O&nbsp;&nbsp;C</td>
    </tr>
	<tr class="Detalle02">
    <td width="6%" rowspan="2">Productos</td>
    <td align="center" colspan="2">Stock Final</td>
    <td align="center" colspan="2">Traspaso Patio</td>
    <td align="center" colspan="2">Horno Refino 1</td>
    <td align="center" colspan="2">Horno Refino 2</td>
    <td align="center" colspan="2">Stock Final</td>
    <td align="center" colspan="2">Traspaso Patio</td>
    <td align="center" colspan="2">Horno Refino 1</td>
    <td align="center" colspan="2">Horno Refino 2</td>
    <td align="center" colspan="2">Stock Final</td>
    <td align="center" colspan="2">Traspaso Patio</td>
    <td align="center" colspan="2">Horno Refino 1</td>
    <td align="center" colspan="2">Horno Refino 2</td>
    <td align="center" colspan="2">Stock Final</td>
    </tr>
    <tr class="Detalle01"> 
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
      <td align="center">Unid.</td>
      <td align="center">Peso</td>
    </tr>
<!--    BLISTER     -->
    <?  //BLISTER
		$Consulta = "SELECT distinct cod_producto, cod_subproducto FROM raf_web.movimientos";
		$Consulta.= " WHERE cod_producto in ('16','17','18')";
	    $Consulta.= " AND ((left(fecha_carga,10) = '$Fecha'  AND turno IN ('A','B'))";
	    $Consulta.= " OR (left(fecha_carga,10) = '$Fecha_Post'  AND turno = 'C'))";		
		$Consulta.= " ORDER BY cod_producto,cod_subproducto";
		$rs = mysql_query($Consulta);
		echo'<tr class="ColorTabla02">';
			echo'<td><b>BLISTER</b>';			
			echo'</td>';
			echo'<td colspan="26">&nbsp;';			
			echo'</td>';
		echo'</tr>';
		while($row = mysql_fetch_array($rs))
		{
				
			  $StockUnid = 0;
		      $StockPeso = 0;
			  // --------------TURNO A	
		    echo'<tr>';
	          $Consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $res = mysql_query($Consulta);
			  $Fila = mysql_fetch_array($res); 			
		      echo'<td>'.$Fila["abreviatura"].'&nbsp;</td>';

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND ((left(fecha_carga,10) < '$Fecha'  AND turno IN ('A','B'))";
			  $Consulta.= " OR (left(fecha_carga,10) <= '$Fecha'  AND turno = 'C'))";
			  $result = mysql_query($Consulta);
			  $fila = mysql_fetch_array($result); 

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND ((left(fecha,10) < '$Fecha'  AND turno IN ('A','B'))";
			  $Consulta.= " OR (left(fecha,10) <= '$Fecha'  AND turno = 'C'))";
			  $result = mysql_query($Consulta);
			  $fila2 = mysql_fetch_array($result); 
			  
			  $StockUnid = $fila[unid] - $fila2[unid];			
			  $StockPeso = $fila[pes] - $fila2[pes];		

		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha'";
			  $Consulta.= " AND turno = 'A'";
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			

		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid + $Fil[unid];  
			  $StockPeso = $StockPeso + $Fil[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 1 AND right(hornada,4) LIKE '1%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result1 = mysql_query($Consulta);
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil1[unid];  
			  $StockPeso = $StockPeso - $Fil1[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 1 AND right(hornada,4) LIKE '2%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil2[unid];  
			  $StockPeso = $StockPeso - $Fil2[pes];  

			  //Acum Turno A	
			  $AcumStockUnidA = $AcumStockUnidA + $StockUnid;  
			  $AcumStockPesoA = $AcumStockPesoA + $StockPeso;  
				
		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';

			  // -----------TURNO B	
	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND turno = 'B'";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha'";
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			

		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid + $Fil[unid];  
			  $StockPeso = $StockPeso + $Fil[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 2 AND right(hornada,4) LIKE '1%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result1 = mysql_query($Consulta);
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil1[unid];  
			  $StockPeso = $StockPeso - $Fil1[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 2 AND right(hornada,4) LIKE '2%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil2[unid];  
			  $StockPeso = $StockPeso - $Fil2[pes];  

			  //Acum Turno B	
			  $AcumStockUnidB = $AcumStockUnidB + $StockUnid;  
			  $AcumStockPesoB = $AcumStockPesoB + $StockPeso;  

		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';

			  // ------------ TURNO C	
	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND turno = 'C'";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha_Post'";
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			
		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid + $Fil[unid];  
			  $StockPeso = $StockPeso + $Fil[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 3 AND right(hornada,4) LIKE '1%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha_Post'";
			  $result1 = mysql_query($Consulta);
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil1[unid];  
			  $StockPeso = $StockPeso - $Fil1[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 3 AND right(hornada,4) LIKE '2%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha_Post'";
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil2[unid];  
			  $StockPeso = $StockPeso - $Fil2[pes];  

			  //Acum Turno C	
			  $AcumStockUnidC = $AcumStockUnidC + $StockUnid;  
			  $AcumStockPesoC = $AcumStockPesoC + $StockPeso;  

		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';
		    echo'</tr>';
		
		
		}
	?>
<!--    RESTOS     -->
    <?  //RESTOS 
		$Consulta = "SELECT distinct (grupo * 1) as grupo FROM raf_web.movimientos";
		$Consulta.= " WHERE cod_producto = 19";
	    $Consulta.= " AND ((left(fecha_carga,10) = '$Fecha'  AND turno IN ('A','B'))";
	    $Consulta.= " OR (left(fecha_carga,10) = '$Fecha_Post'  AND turno = 'C'))";		
		$Consulta.= " ORDER BY grupo";
		$rs = mysql_query($Consulta);

		echo'<tr class="ColorTabla02">';
			echo'<td><b>RESTOS</b>';			
			echo'</td>';
			echo'<td colspan="26">&nbsp;';			
			echo'</td>';
		echo'</tr>';
		while($row = mysql_fetch_array($rs))
		{
				
			  $StockUnid = 0;
		      $StockPeso = 0;
			  // ----------- TURNO A	
		    echo'<tr>';
		      echo'<td>Grupo N� '.$r["grupo"]o].'&nbsp;</td>';

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND ((left(fecha_carga,10) < '$Fecha'  AND turno IN ('A','B'))";
			  $Consulta.= " OR (left(fecha_carga,10) <= '$Fecha'  AND turno = 'C'))";
			  $result = mysql_query($Consulta);
			  $fila = mysql_fetch_array($result); 

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND ((left(fecha,10) < '$Fecha'  AND turno IN ('A','B'))";
			  $Consulta.= " OR (left(fecha,10) <= '$Fecha'  AND turno = 'C'))";
			  $result = mysql_query($Consulta);
			  $fila2 = mysql_fetch_array($result); 
			  
			  $StockUnid = $fila[unid] - $fila2[unid];			
			  $StockPeso = $fila[pes] - $fila2[pes];		

		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha'";
			  $Consulta.= " AND turno = 'A'";
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			

		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid + $Fil[unid];  
			  $StockPeso = $StockPeso + $Fil[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND nro_carga = 1 AND right(hornada,4) LIKE '1%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result1 = mysql_query($Consulta);
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil1[unid];  
			  $StockPeso = $StockPeso - $Fil1[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND nro_carga = 1 AND right(hornada,4) LIKE '2%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil2[unid];  
			  $StockPeso = $StockPeso - $Fil2[pes];  

			  //Acum Turno A	
			  $AcumStockUnidA = $AcumStockUnidA + $StockUnid;  
			  $AcumStockPesoA = $AcumStockPesoA + $StockPeso;  
				
		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';

			  // ---------  TURNO B	
	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND turno = 'B'";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha'";
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			

		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid + $Fil[unid];  
			  $StockPeso = $StockPeso + $Fil[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND nro_carga = 2 AND right(hornada,4) LIKE '1%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result1 = mysql_query($Consulta);
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil1[unid];  
			  $StockPeso = $StockPeso - $Fil1[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND nro_carga = 2 AND right(hornada,4) LIKE '2%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil2[unid];  
			  $StockPeso = $StockPeso - $Fil2[pes];  

			  //Acum Turno B	
			  $AcumStockUnidB = $AcumStockUnidB + $StockUnid;  
			  $AcumStockPesoB = $AcumStockPesoB + $StockPeso;  

		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';

			  // -------------- TURNO C	
	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND turno = 'C'";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha_Post'";
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			
		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid + $Fil[unid];  
			  $StockPeso = $StockPeso + $Fil[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND nro_carga = 3 AND right(hornada,4) LIKE '1%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha_Post'";
			  $result1 = mysql_query($Consulta);
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil1[unid];  
			  $StockPeso = $StockPeso - $Fil1[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE grupo = $row["grupo"]";
			  $Consulta.= " AND nro_carga = 3 AND right(hornada,4) LIKE '2%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha_Post'";			  
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil2[unid];  
			  $StockPeso = $StockPeso - $Fil2[pes];  

			  //Acum Turno C	
			  $AcumStockUnidC = $AcumStockUnidC + $StockUnid;  
			  $AcumStockPesoC = $AcumStockPesoC + $StockPeso;  

		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';
		    echo'</tr>';
		
		
		}
	?>
<!--    Circulantes     -->
    <?  //CIRCULANTES
		$Consulta = "SELECT distinct cod_producto, cod_subproducto FROM raf_web.movimientos";
		$Consulta.= " WHERE cod_producto = 42";
	    $Consulta.= " AND ((left(fecha_carga,10) = '$Fecha'  AND turno IN ('A','B'))";
	    $Consulta.= " OR (left(fecha_carga,10) = '$Fecha_Post'  AND turno = 'C'))";		
		$Consulta.= " ORDER BY cod_producto,cod_subproducto";
		$rs = mysql_query($Consulta);
		echo'<tr class="ColorTabla02">';
			echo'<td><b>CIRCULANTES</b>';			
			echo'</td>';
			echo'<td colspan="26">&nbsp;';			
			echo'</td>';
		echo'</tr>';
		while($row = mysql_fetch_array($rs))
		{
				
			  $StockUnid = 0;
		      $StockPeso = 0;
			  // ------------ TURNO A	
		    echo'<tr>';
	          $Consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $res = mysql_query($Consulta);
			  $Fila = mysql_fetch_array($res); 			
		      echo'<td>'.$Fila["abreviatura"].'&nbsp;</td>';

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND ((left(fecha_carga,10) < '$Fecha'  AND turno IN ('A','B'))";
			  $Consulta.= " OR (left(fecha_carga,10) <= '$Fecha'  AND turno = 'C'))";
			  $result = mysql_query($Consulta);
			  $fila = mysql_fetch_array($result); 

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND ((left(fecha,10) < '$Fecha'  AND turno IN ('A','B'))";
			  $Consulta.= " OR (left(fecha,10) <= '$Fecha'  AND turno = 'C'))";
			  $result = mysql_query($Consulta);
			  $fila2 = mysql_fetch_array($result); 
			  
			  $StockUnid = $fila[unid] - $fila2[unid];			
			  $StockPeso = $fila[pes] - $fila2[pes];		

		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha'";
			  $Consulta.= " AND turno = 'A'";
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			

		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid + $Fil[unid];  
			  $StockPeso = $StockPeso + $Fil[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 1 AND right(hornada,4) LIKE '1%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result1 = mysql_query($Consulta);
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil1[unid];  
			  $StockPeso = $StockPeso - $Fil1[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 1 AND right(hornada,4) LIKE '2%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil2[unid];  
			  $StockPeso = $StockPeso - $Fil2[pes];  

			  //Acum Turno A	
			  $AcumStockUnidA = $AcumStockUnidA + $StockUnid;  
			  $AcumStockPesoA = $AcumStockPesoA + $StockPeso;  
				
		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';

			  // ---------- TURNO B	
	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND turno = 'B'";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha'";
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			

		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid + $Fil[unid];  
			  $StockPeso = $StockPeso + $Fil[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 2 AND right(hornada,4) LIKE '1%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result1 = mysql_query($Consulta);
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil1[unid];  
			  $StockPeso = $StockPeso - $Fil1[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 2 AND right(hornada,4) LIKE '2%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil2[unid];  
			  $StockPeso = $StockPeso - $Fil2[pes];  

			  //Acum Turno B	
			  $AcumStockUnidB = $AcumStockUnidB + $StockUnid;  
			  $AcumStockPesoB = $AcumStockPesoB + $StockPeso;  

		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';

			  // ---------- TURNO C	
	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND turno = 'C'";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha_Post'";
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			
		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid + $Fil[unid];  
			  $StockPeso = $StockPeso + $Fil[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 3 AND right(hornada,4) LIKE '1%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha_Post'";
			  $result1 = mysql_query($Consulta);
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $StockUnid = $StockUnid - $Fil1[unid];  
			  $StockPeso = $StockPeso - $Fil1[pes];  

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND nro_carga = 3 AND right(hornada,4) LIKE '2%'";	
			  $Consulta.= " AND left(fecha,10) = '$Fecha_Post'";
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';

			  $StockUnid = $StockUnid - $Fil2[unid];  
			  $StockPeso = $StockPeso - $Fil2[pes];  

			  //Acum Turno C	
			  $AcumStockUnidC = $AcumStockUnidC + $StockUnid;  
			  $AcumStockPesoC = $AcumStockPesoC + $StockPeso;  

		      echo'<td align="right">'.$StockUnid.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPeso.'&nbsp;</td>';
		    echo'</tr>';
		
		
		}
	?>
	
    <tr class="Detalle02"> 
      <td>Totales</td>
      <td align="right" colspan="9">&nbsp;</td>
      <td align="right"><? echo $AcumStockPesoA;?>&nbsp;</td>
      <td align="right" colspan="7">&nbsp;</td>
      <td align="right"><? echo $AcumStockPesoB;?>&nbsp;</td>
      <td align="right" colspan="7">&nbsp;</td>
      <td align="right"><? echo $AcumStockPesoC;?>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p><table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td align="center"> <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('P');"> 
        <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"> 
      </td>
    </tr>
  </table>
  </form>
</body>
</html>
