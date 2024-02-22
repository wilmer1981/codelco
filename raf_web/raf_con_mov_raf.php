<?
	include("../principal/conectar_pac_web.php");

	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia; 
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes; 
?>
<html>
<head>
<title>Movimientos En Raf</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Detalle(dir)
{
	window.open(dir, "","top=0,left=50,width=730,height=320,scrollbars=yes,resizable = no");
}

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
      <td align="center">Movimientos En Raf (Por Producto)</td>
    </tr>
  </table> 	
  <br>
  <table width="127" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">
    <tr>
      <td width="123">Fecha : <? echo $Dia.'-'.$Mes.'-'.$Ano; ?></td>
    </tr>
  </table> 	
  <br>
  <table width="750" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">
    <tr class="ColorTabla01"> 
      <td width="20%" rowspan="2">Productos</td>
      <td align="center" colspan="2">Carga. Progr.</td>
      <td align="center" colspan="2">Carga 1</td>
      <td align="center" colspan="2">Carga 2</td>
      <td align="center" colspan="2">Carga 3</td>
      <td align="center" colspan="2">Carga 4</td>
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
    </tr>
    <? 

		$Fecha_Ant = date("Y-m-d",mktime(7,59,59,$Mes,($Dia - 1),$Ano));
		$Fecha_Post = date("Y-m-d",mktime(7,59,59,$Mes,($Dia + 1),$Ano));
		$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
		$Consulta = "SELECT distinct cod_producto, cod_subproducto FROM raf_web.movimientos";
	    $Consulta.= " WHERE left(fecha_carga,10) = '$Fecha'";
		$Consulta.= " ORDER BY cod_producto,cod_subproducto";
		$rs = mysql_query($Consulta);
		while($row = mysql_fetch_array($rs))
		{
		    $StockUnid = 0;
		    $StockPeso = 0;
		    echo'<tr>';
	          $Consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $res = mysql_query($Consulta);
			  $Fila = mysql_fetch_array($res); 			

			  $Valores = "raf_con_detalle.php?Fecha=".$Fecha."&Producto=".$row["cod_producto"]."&SubProducto=".$row[cod_subproducto];
		      echo"<td><a href=JavaScript:Detalle('$Valores');>".$Fila["abreviatura"]."</a>&nbsp;</td>";				

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.movimientos";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND left(fecha_carga,10) = '$Fecha'";	
			  $result = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($result); 			

		      echo'<td align="right">'.$Fil[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil[pes].'&nbsp;</td>';
			  $AcumUnid = $AcumUnid + $Fil[unid];	
			  $AcumPeso = $AcumPeso + $Fil[pes];	
			  $StockUnid = $StockUnid + $Fil[unid];			
			  $StockPeso = $StockPeso + $Fil[pes];		

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 1";
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";	
			  $result1 = mysql_query($Consulta);
			  //echo $Consulta;
			  $Fil1 = mysql_fetch_array($result1); 
		      echo'<td align="right">'.$Fil1[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil1[pes].'&nbsp;</td>';
			  $AcumUnid_1 = $AcumUnid_1 + $Fil1[unid];	
			  $AcumPeso_1 = $AcumPeso_1 + $Fil1[pes];	

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 2";
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";	
			  $result2 = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($result2); 
		      echo'<td align="right">'.$Fil2[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil2[pes].'&nbsp;</td>';
			  $AcumUnid_2 = $AcumUnid_2 + $Fil2[unid];	
			  $AcumPeso_2 = $AcumPeso_2 + $Fil2[pes];	

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 3";
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";	
			  $result3 = mysql_query($Consulta);
			  $Fil3 = mysql_fetch_array($result3); 
		      echo'<td align="right">'.$Fil3[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil3[pes].'&nbsp;</td>';
			  $AcumUnid_3 = $AcumUnid_3 + $Fil3[unid];	
			  $AcumPeso_3 = $AcumPeso_3 + $Fil3[pes];	

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto] and nro_carga = 4";
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";	
			  $result4 = mysql_query($Consulta);
			  $Fil4 = mysql_fetch_array($result4); 
		      echo'<td align="right">'.$Fil4[unid].'&nbsp;</td>';
		      echo'<td align="right">'.$Fil4[pes].'&nbsp;</td>';
			  $AcumUnid_4 = $AcumUnid_4 + $Fil4[unid];	
			  $AcumPeso_4 = $AcumPeso_4 + $Fil4[pes];	

	          $Consulta = "SELECT sum(unidades) as unid,sum(peso) as pes FROM raf_web.det_carga";
			  $Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
			  $Consulta.= " AND left(fecha,10) = '$Fecha'";	
			  $result5 = mysql_query($Consulta);
			  $Fil5 = mysql_fetch_array($result5); 

			  $StockUni = $StockUnid - $Fil5[unid];	
			  $StockPes = $StockPeso - $Fil5[pes];	
			  $AcumUnid_5 = $AcumUnid_5 + $StockUni;	
			  $AcumPeso_5 = $AcumPeso_5 + $StockPes;	

		      echo'<td align="right">'.$StockUni.'&nbsp;</td>';
		      echo'<td align="right">'.$StockPes.'&nbsp;</td>';

		    echo'</tr>';
		
		
		}
	?>
    <tr class="Detalle02"> 
      <td>Totales</td>
      <td align="right"><? echo $AcumUnid?>&nbsp;</td>
      <td align="right"><? echo $AcumPeso?>&nbsp;</td>
      <td align="right"><? echo $AcumUnid_1?>&nbsp;</td>
      <td align="right"><? echo $AcumPeso_1?>&nbsp;</td>
      <td align="right"><? echo $AcumUnid_2?>&nbsp;</td>
      <td align="right"><? echo $AcumPeso_2?>&nbsp;</td>
      <td align="right"><? echo $AcumUnid_3?>&nbsp;</td>
      <td align="right"><? echo $AcumPeso_3?>&nbsp;</td>
      <td align="right"><? echo $AcumUnid_4?>&nbsp;</td>
      <td align="right"><? echo $AcumPeso_4?>&nbsp;</td>
      <td align="right"><? echo $AcumUnid_5?>&nbsp;</td>
      <td align="right"><? echo $AcumPeso_5?>&nbsp;</td>
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
