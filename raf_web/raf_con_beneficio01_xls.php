<?
 header("Content-Type:application/vnd.ms-excel");
 header("Expires:0");
 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../principal/conectar_raf_web.php");

$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;
	
	$HornadaIni = $Ano.$Mes.'1000';
	$HornadaTer = $Ano.$Mes.'1999';

$Fecha = $Ano.'-'.$Mes;
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
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

<body background="../principal/imagenes/fondo3.gif">
<form name="FrmPrincipal" method="post" action="">
  <table width="300" align="center" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td align="center" colspan="17">B E N E F I C I O S &nbsp;&nbsp;E N&nbsp;&nbsp; R A F</td>
	</tr>	
  </table>
  <br>
  <table width="150" align="center" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td colspan="5">Fecha : <? echo ucwords(strtolower($Meses[$Mes - 1])).' '.$Ano?></td>
	</tr>	
  </table>
  <br>
  <table width="200" border="0" cellspacing="0" cellpadding="0" class="Detalle01">
    <tr> 
      <td colspan="17">Beneficio Refino # 1</td>
	</tr>	
  </table>
  <table width="1100" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td align="center">Fecha</td>
      <td align="center">N&deg;</td>
      <td align="center">&nbsp;</td>
      <td align="center">Blister</td>
      <td align="center">Blister</td>
      <td align="center">Blister</td>
      <td align="center">Blister</td>
      <td align="center">Blister</td>
      <td align="center">Potrer.</td>
      <td colspan="3" align="center">Anodos Rechazados</td>
      <td align="center">Restos</td>
      <td align="center">Gran/Desp</td>
      <td align="center">Catod.</td>
      <td align="center">Matrices</td>
      <td align="center">Cu Anod.</td>
      <td align="center">Cu Anod.</td>
      <td colspan="2" align="center">Blister Liquid</td>
      <td align="center">Carga</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Carga</td>
      <td align="center">Horn</td>
      <td align="center">&nbsp;</td>
      <td align="center">Codel.</td>
      <td align="center">Abra</td>
      <td align="center">HVL</td>
      <td align="center">Disput.</td>
      <td align="center">Florid.</td>
      <td align="center">Restos</td>
      <td align="center">Com</td>
      <td align="center">H.M</td>
      <td align="center">Total</td>
      <td align="center">Anodos</td>
      <td align="center">Nodulos</td>
      <td align="center">D.Parcial</td>
      <td align="center">Moldes</td>
      <td align="center">Rebalses</td>
      <td align="center">Circ.</td>
      <td align="center">Reten</td>
      <td align="center">Bascul</td>
      <td align="center">Diaria</td>
    </tr>
	<?

		$TotalCarga = 0;
		$TotalBlis  = 0;
		$TotalRechazo  = 0;
		$TotalRest 	= 0;
		$TotalCatElec  = 0;
		$TotalCatDesc  = 0;
		$TotalMoldes    = 0;
		$TotalRebal	= 0;
		$TotalAnodCirc = 0;
		$TotalReten   = 0;
		$TotalBasc	  = 0;

		$Consulta = "SELECT distinct hornada FROM raf_web.det_carga WHERE left(fecha,7) = '$Fecha'";
		$Consulta.= " AND hornada BETWEEN $HornadaIni AND $HornadaTer";
		$rs = mysql_query($Consulta);
		while($Fila = mysql_fetch_array($rs))
		{			
		    $Consulta = "SELECT MIN(fecha) as fecha FROM raf_web.det_carga";
		    $Consulta.= " WHERE hornada = $Fila["hornada"]";	
		    $respuesta = mysql_query($Consulta);
			$fila = mysql_fetch_array($respuesta);
			$Fecha = substr($fila["fecha"],0,10);
			$Dia = substr($fila["fecha"],8,2);
			$Ano = substr($fila["fecha"],0,4);
			$Mes = substr($fila["fecha"],5,2);					  						
			$Fecha_Post = date("Y-m-d",mktime(7,59,59,$Mes,($Dia + 1),$Ano));
			//$fecha = substr($fila["fecha"],5,5);
			$fecha1 = substr($fila["fecha"],0,10); 
			$fecha = $Dia."-".$Mes."-".$Ano;
	
		
			$hornada = substr($Fila["hornada"],6,4);
			$CargaDiaria = 0;
			echo'<tr>';
			  echo'<td align="center">'.$fecha.'</td>';
			  echo'<td align="center">'.$hornada.'</td>';
			  echo'<td align="right">1&nbsp;</td>';
			  echo'<td align="right">&nbsp;</td>';
			  echo'<td align="right">&nbsp;</td>';
			  echo'<td align="right">&nbsp;</td>';
			  echo'<td align="right">&nbsp;</td>';
			  echo'<td align="right">&nbsp;</td>';
			  /*echo'<td align="right">&nbsp;</td>';*/

			   //Blister Potrerillos
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 16 and cod_subproducto = 24";	
			  $resp = mysql_query($Consulta);
			  $fila1 = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila1["peso"].'&nbsp;</td>';
			  $TotalBlis = $TotalBlis + $fila1["peso"];
              $CargaDiaria = $CargaDiaria + $fila1["peso"];
			   
			  //Anodos	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 17 and cod_subproducto IN ('1','2','3','4')";	
			  $resp = mysql_query($Consulta);
			  $fila1 = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila1["peso"].'&nbsp;</td>';
			  $TotalAnod = $TotalAnod + $fila1["peso"];
              $CargaDiaria = $CargaDiaria + $fila1["peso"];

			  //H Madres	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 17 and cod_subproducto = 8";	
			  $resp = mysql_query($Consulta);
			  $fila2 = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila2["peso"].'&nbsp;</td>';
			  $TotalHM = $TotalHM + $fila2["peso"];
              $CargaDiaria = $CargaDiaria + $fila2["peso"];

			  $TotalRech = $fila1["peso"] + $fila2["peso"];
			  echo'<td align="right">'.$TotalRech.'&nbsp;</td>';
			  $TotalRechazo = $TotalRechazo + $TotalRech;

			  //Restos	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 19";	
			  $resp = mysql_query($Consulta);
			  $fila = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila["peso"].'&nbsp;</td>';
			  $TotalRest = $TotalRest + $fila["peso"];
              $CargaDiaria = $CargaDiaria + $fila["peso"];

		 	  //Despunte y laminas	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 48 AND cod_subproducto IN ('1','3','10')";	
			  $resp = mysql_query($Consulta);
			  $fila = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila["peso"].'&nbsp;</td>';
			  $TotalCatElec = $TotalCatElec + $fila["peso"];
              $CargaDiaria = $CargaDiaria + $fila["peso"];

		 	  //Cat Desc Parcial	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 18 AND cod_subproducto IN ('2','4','5','8')";	
			  $resp = mysql_query($Consulta);
			  $fila = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila["peso"].'&nbsp;</td>';
			  $TotalCatDesc = $TotalCatDesc + $fila["peso"];
              $CargaDiaria = $CargaDiaria + $fila["peso"];

			  //Moldes	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 42 AND cod_subproducto IN ('31','43','73','75','76','77')";	
			  $resp = mysql_query($Consulta);
			  $fila = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila["peso"].'&nbsp;</td>';
			  $TotalMoldes = $TotalMoldes + $fila["peso"];
              $CargaDiaria = $CargaDiaria + $fila["peso"];

			  //Rebalses	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 42 AND cod_subproducto = 69";	
			  $resp = mysql_query($Consulta);
			  $fila = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila["peso"].'&nbsp;</td>';
			  $TotalRebal = $TotalRebal + $fila["peso"];
              $CargaDiaria = $CargaDiaria + $fila["peso"];

			  //Anodos Circulantes	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 42 AND cod_subproducto = 74";	
			  $resp = mysql_query($Consulta);
			  $fila = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila["peso"].'&nbsp;</td>';
			  $TotalAnodCirc = $TotalAnodCirc + $fila["peso"];
              $CargaDiaria = $CargaDiaria + $fila["peso"];

			  //Blister Reten	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 16 AND cod_subproducto = 42";	
			  $resp = mysql_query($Consulta);
			  $fila = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila["peso"].'&nbsp;</td>';
			  $TotalReten = $TotalReten + $fila["peso"];
              $CargaDiaria = $CargaDiaria + $fila["peso"];

			  //Blister Basc	
			  $Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga";
			  $Consulta.= " WHERE hornada = $Fila["hornada"] AND cod_producto = 16 AND cod_subproducto IN ('40','41')";	
			  $resp = mysql_query($Consulta);
			  $fila = mysql_fetch_array($resp);
			  echo'<td align="right">'.$fila["peso"].'&nbsp;</td>';
			  $TotalBasc = $TotalBasc + $fila["peso"];
              $CargaDiaria = $CargaDiaria + $fila["peso"];
			  
			  //$CargaDiaria = $TotalRechazo + $TotalRest + $TotalCatElec + $TotalCatDesc + $TotalRebal + $TotalAnodCirc + $TotalReten + $TotalBasc;
			  $TotalCarga = $TotalCarga + $CargaDiaria;	
			  echo'<td align="right" class="Detalle02">'.$CargaDiaria.'&nbsp;</td>';
			echo'</tr>';
		}
    ?>
    <tr class="ColorTabla02"> 
      <td align="left" colspan="2"><b>TOTALES</b></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><? echo $TotalBlis;?>&nbsp;</td>
      <td align="right"><? echo $TotalAnod;?>&nbsp;</td>
      <td align="right"><? echo $TotalHM;?>&nbsp;</td>
      <td align="right"><? echo $TotalRechazo;?>&nbsp;</td>
      <td align="right"><? echo $TotalRest;?>&nbsp;</td>
      <td align="right"><? echo $TotalCatElec;?>&nbsp;</td>
      <td align="right"><? echo $TotalCatDesc;?>&nbsp;</td>
      <td align="right"><? echo $TotalMoldes;?>&nbsp;</td>
      <td align="right"><? echo $TotalRebal;?>&nbsp;</td>
      <td align="right"><? echo $TotalAnodCirc;?>&nbsp;</td>
      <td align="right"><? echo $TotalReten;?>&nbsp;</td>
      <td align="right"><? echo $TotalBasc;?>&nbsp;</td>
      <td align="right" class="Detalle02"><? echo $TotalCarga;?>&nbsp;</td>
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
