<?
 header("Content-Type:application/vnd.ms-excel");
 header("Expires:0");
 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_pac_web.php");
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;

	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;
	
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;
	$Fecha_Ant = date("Y-m-d",mktime(7,59,59,$Mes,($Dia - 1),$Ano));
	$Fecha_Post = date("Y-m-d",mktime(7,59,59,$Mes,($Dia + 1),$Ano));

?>
<html>
<head>
<title>Movimientos En Raf</title>
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
      <td align="center">Detalle Hornadas En Beneficio</td>
    </tr>
  </table> 	
  <br>
  <table width="200" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">
    <tr>
      <td>Fecha : <? echo $Dia.'-'.$Mes.'-'.$Ano;?></td>
    </tr>
  </table> 	
  <br>
    <? 
		$Consulta = "SELECT distinct hornada FROM raf_web.det_carga"; 
	    $Consulta.= " WHERE left(fecha,10) = '$Fecha'"; 		
		$Consulta.= " ORDER BY hornada";
		$resp = mysqli_query($link, $Consulta);
		while($fila = mysql_fetch_array($resp))
		{		  	
		   echo'<table width="100" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">';
			echo'<tr>';
			 echo'<td class="Detalle01">';	
			 echo '<strong>Hornada : </strong>'.substr($fila["hornada"],6,4);
		   echo'</table>';
		   	
		   echo'<table width="670" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">';
			echo'<tr class="ColorTabla01"> 
			  <td width="15%" rowspan="2">Productos</td>
			  <td align="center" colspan="2">Carga Prog.</td>
			  <td align="center" colspan="2">Carga 1</td>
			  <td align="center" colspan="2">Carga 2</td>
			  <td align="center" colspan="2">Carga 3</td>
			  <td align="center" colspan="2">Carga 4</td>
			  <td align="center" colspan="2">Total Benef</td>
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
			</tr>';			

			$AcumUnid = '';			
			$AcumPeso = '';			
			$AcumUnid1 = '';			
			$AcumPeso1 = '';			
			$AcumUnid2 = '';			
			$AcumPeso2 = '';			
			$AcumUnid3 = '';			
			$AcumPeso3 = '';			
			$AcumUnid4 = '';			
			$AcumPeso4 = '';			
			$AcumTotalUnid = '';			
			$AcumTotalPeso = '';			
			$Consulta = "SELECT distinct cod_producto,cod_subproducto FROM raf_web.det_carga WHERE hornada = $fila["hornada"]";
			$Consulta.= " ORDER BY cod_producto, cod_subproducto";
			$res = mysqli_query($link, $Consulta);
		    while($row = mysql_fetch_array($res))
			{
				echo'<tr>';
				  $Consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
				  $rs = mysqli_query($link, $Consulta);
				  $Fila = mysql_fetch_array($rs); 			
				  echo'<td>'.$Fila["abreviatura"].'&nbsp;</td>';
		
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
				  $Consulta.= " AND hornada = $fila["hornada"]";
				  $result = mysqli_query($link, $Consulta);
				  $Fil = mysql_fetch_array($result); 
				  echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
				  echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
				  $AcumUnid = $AcumUnid + $Fil[unid];
				  $AcumPeso = $AcumPeso + $Fil[pes];

				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 1";
				  $Consulta.= " AND hornada = $fila["hornada"]";
				  $result1 = mysqli_query($link, $Consulta);
				  $Fil1 = mysql_fetch_array($result1); 
				  echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
				  echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
				  $AcumUnid1 = $AcumUnid1 + $Fil1[unid];
				  $AcumPeso1 = $AcumPeso1 + $Fil1[pes];
	
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 2";
				  $Consulta.= " AND hornada = $fila["hornada"]";	
				  $result2 = mysqli_query($link, $Consulta);
				  $Fil2 = mysql_fetch_array($result2); 
				  echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
				  echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
				  $AcumUnid2 = $AcumUnid2 + $Fil2[unid];
				  $AcumPeso2 = $AcumPeso2 + $Fil2[pes];
	
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 3";
				  $Consulta.= " AND hornada = $fila["hornada"]";	
				  $result3 = mysqli_query($link, $Consulta);
				  $Fil3 = mysql_fetch_array($result3); 
				  echo'<td align="right">'.$Fil3[unid].'&nbsp;</td>';
				  echo'<td align="right">'.$Fil3[pes].'&nbsp;</td>';
				  $AcumUnid3 = $AcumUnid3 + $Fil3[unid];
				  $AcumPeso3 = $AcumPeso3 + $Fil3[pes];
	
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 4";
				  $Consulta.= " AND hornada = $fila["hornada"]";	
				  $result4 = mysqli_query($link, $Consulta);
				  $Fil4 = mysql_fetch_array($result4); 
				  echo'<td align="right">'.$Fil4[unid].'&nbsp;</td>';				  
				  echo'<td align="right">'.$Fil4[pes].'&nbsp;</td>';
				  $AcumUnid4 = $AcumUnid4 + $Fil4[unid];
				  $AcumPeso4 = $AcumPeso4 + $Fil4[pes];
	
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
				  $Consulta.= " AND hornada = $fila["hornada"]";	
				  $result5 = mysqli_query($link, $Consulta);
				  $Fil5 = mysql_fetch_array($result5); 
	
				  $TotalUnid = $Fil5[unid];	
				  $TotalPeso = $Fil5[pes];	
				  $AcumTotalUnid = $AcumTotalUnid + $Fil5[unid];	
				  $AcumTotalPeso = $AcumTotalPeso + $Fil5[pes];	
				  echo'<td align="right">'.$TotalUnid.'&nbsp;</td>';
				  echo'<td align="right">'.$TotalPeso.'&nbsp;</td>';
	
				echo'</tr>';
			}				
		    echo'
		    <tr class="Detalle02"> 
		    <td>Totales</td>
		    <td align="right">'.$AcumUnid.'&nbsp;</td>
		    <td align="right">'.$AcumPeso.'&nbsp;</td>
		    <td align="right">'.$AcumUnid1.'&nbsp;</td>
		    <td align="right">'.$AcumPeso1.'&nbsp;</td>
		    <td align="right">'.$AcumUnid2.'&nbsp;</td>
		    <td align="right">'.$AcumPeso2.'&nbsp;</td>
		    <td align="right">'.$AcumUnid3.'&nbsp;</td>
		    <td align="right">'.$AcumPeso3.'&nbsp;</td>
		    <td align="right">'.$AcumUnid4.'&nbsp;</td>
		    <td align="right">'.$AcumPeso4.'&nbsp;</td>
		    <td align="right">'.$AcumTotalUnid.'&nbsp;</td>
		    <td align="right">'.$AcumTotalPeso.'&nbsp;</td>
		   </tr>
	      </table><br>';

		}
	?>
  <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">  
	<tr>
	  <td align="center">	
	   <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('P');">
	   <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
      </td>
	</tr>
  </table>		
</form>
</body>
</html>
