<?
	include("../principal/conectar_pac_web.php");
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;

	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;
	$Fechita = date("Y-m-d");
	$Fecha2 = date("Y-m-d", mktime(0,0,0,intval(substr($Fechita, 5, 2)) ,intval(substr($Fechita, 8, 2)) - 10 ,intval(substr($Fechita, 0, 4))));
	$Ano1=substr($Fechita,0,4);
	$Mes1=substr($Fechita,5,2);
	$Ano2=substr($Fecha2,0,4);
	$Mes2=substr($Fecha2,5,2);
	$AnoI=$Ano2."".$Mes2;
	$AnoF=$Ano1."".$Mes1;

	
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
      <td align="center">Detalle Hornada En Beneficio</td>
    </tr>
  </table> 	
  <br>
		   <table width="100" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">
			<tr>
			 <td class="Detalle01">	
			 <?
			 echo '<strong>Hornada : </strong>'.$Hornada;
			 ?>
		   </table>		   
		   	
  <table width="692" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">
    <tr class="ColorTabla01"> 
      <td width="14%" rowspan="2">Productos</td>
      <td width="3%" rowspan="2">Gr</td>
      <td align="center" colspan="2">Carga Prog.</td>
      <td align="center" colspan="2">Carga 1</td>
      <td align="center" colspan="2">Carga 2</td>
      <td align="center" colspan="2">Carga 3</td>
      <td align="center" colspan="2">Carga 4</td>
      <td align="center" colspan="2">Total Benef</td>
    </tr>
    <tr class="Detalle01"> 
      <td width="7%" align="center">Unid.</td>
      <td width="8%" align="center">Peso</td>
      <td width="6%" align="center">Unid.</td>
      <td width="6%" align="center">Peso</td>
      <td width="7%" align="center">Unid.</td>
      <td width="6%" align="center">Peso</td>
      <td width="7%" align="center">Unid.</td>
      <td width="6%" align="center">Peso</td>
      <td width="7%" align="center">Unid.</td>
      <td width="6%" align="center">Peso</td>
      <td width="7%" align="center">Unid.</td>
      <td width="10%" align="center">Peso</td>
    </tr>
    <? 
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
			$Consulta = "SELECT  distinct hornada as hornada, cod_producto as cod_producto, ";
			$Consulta.="cod_subproducto as cod_subproducto, grupo as grupo FROM raf_web.det_carga";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = $Hornada";
			else
				$Consulta.= " WHERE right(hornada,5) = $Hornada";
			$Consulta.= " and left(hornada,6) between '".$AnoI."' and '".$AnoF."'";
			$Consulta.= " order by cod_producto,cod_subproducto,grupo";
			$res = mysql_query($Consulta);
		    while($row = mysql_fetch_array($res))
			{
			    $Dia = substr($row["fecha"],8,2);
				$Ano = substr($row["fecha"],0,4);
				$Mes = substr($row["fecha"],5,2);
				$Fecha = $Ano.'-'.$Mes.'-'.$Dia;
				$Fecha_Ant = date("Y-m-d",mktime(7,59,59,$Mes,($Dia - 1),$Ano));
				$Fecha_Post = date("Y-m-d",mktime(7,59,59,$Mes,($Dia + 1),$Ano));

				echo'<tr>';
				  $Consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
				  $rs = mysql_query($Consulta);
				  $Fila = mysql_fetch_array($rs); 			
				  echo'<td>'.$Fila["abreviatura"].'&nbsp;</td>';

				  echo'<td>'.$row["grupo"].'&nbsp;</td>';
		
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
				  $Consulta.= " AND hornada = $row["hornada"]";
				  $Consulta.= " AND grupo = '$row["grupo"]'";
				  $result = mysql_query($Consulta);
				  $Fil = mysql_fetch_array($result); 
				  echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
				  echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
				  $AcumUnid = $AcumUnid + $Fil[unid];
				  $AcumPeso = $AcumPeso + $Fil[pes];

				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 1";
				  $Consulta.= " AND hornada = $row["hornada"]";
				  $Consulta.= " AND grupo = '$row["grupo"]'";
				  $result1 = mysql_query($Consulta);
				  $Fil1 = mysql_fetch_array($result1); 
				  echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
				  echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
				  $AcumUnid1 = $AcumUnid1 + $Fil1[unid];
				  $AcumPeso1 = $AcumPeso1 + $Fil1[pes];
	
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 2";
				  $Consulta.= " AND hornada = $row["hornada"]";
				  $Consulta.= " AND grupo = '$row["grupo"]'";
				  $result2 = mysql_query($Consulta);
				  $Fil2 = mysql_fetch_array($result2); 
				  echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
				  echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
				  $AcumUnid2 = $AcumUnid2 + $Fil2[unid];
				  $AcumPeso2 = $AcumPeso2 + $Fil2[pes];
	
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 3";
				  $Consulta.= " AND hornada = $row["hornada"]";
				  $Consulta.= " AND grupo = '$row["grupo"]'";
				  $result3 = mysql_query($Consulta);
				  $Fil3 = mysql_fetch_array($result3); 
				  echo'<td align="right">'.$Fil3[unid].'&nbsp;</td>';
				  echo'<td align="right">'.$Fil3[pes].'&nbsp;</td>';
				  $AcumUnid3 = $AcumUnid3 + $Fil3[unid];
				  $AcumPeso3 = $AcumPeso3 + $Fil3[pes];
	
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 4";
				  $Consulta.= " AND hornada = $row["hornada"]";
				  $Consulta.= " AND grupo = '$row["grupo"]'";
				  $result4 = mysql_query($Consulta);
				  $Fil4 = mysql_fetch_array($result4); 
				  echo'<td align="right">'.$Fil4[unid].'&nbsp;</td>';				  
				  echo'<td align="right">'.$Fil4[pes].'&nbsp;</td>';
				  $AcumUnid4 = $AcumUnid4 + $Fil4[unid];
				  $AcumPeso4 = $AcumPeso4 + $Fil4[pes];
	
				  $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
				  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
				  $Consulta.= " AND hornada = $row["hornada"]";
				  $Consulta.= " AND grupo = '$row["grupo"]'";
				  $result5 = mysql_query($Consulta);
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
		    <td colspan="2">Totales</td>
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
		   </tr>';

	?>
  </table>
  <br>
  <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">  
	<tr>
	  <td align="center">	
	   <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('P');">
	   <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="self.close()">
      </td>
	</tr>
  </table>		
</form>
</body>
</html>
