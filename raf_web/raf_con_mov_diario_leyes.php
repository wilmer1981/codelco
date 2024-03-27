<?
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
<title>Movimientos En Raf(Leyes)</title>
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
	
		$Consulta = "SELECT distinct   hornada  FROM raf_web.det_carga"; 
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
		   	
		   echo'<table width="680" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal" align="center">';
			echo'<tr class="ColorTabla01"> 
			  <td width="20%" rowspan="2">Productos</td>
			  <td align="center" colspan="2">Carga Prog.</td>
			  <td align="center" colspan="3">Leyes</td>
			  <td align="center" colspan="3">Finos</td>
			</tr>
			<tr class="Detalle01"> 
			  <td align="center">Unid.</td>
			  <td align="center">Peso</td>
			  <td align="center">As</td>
			  <td align="center">Sb</td>
			  <td align="center">Fe</td>
			  <td align="center">As</td>
			  <td align="center">Sb</td>
			  <td align="center">Fe</td>
			</tr>';			

			$AcumUnid = '';			
			$AcumPeso = '';			
			$AcumAs1 = '';			
			$AcumSb1 = '';			
			$AcumFe1 = '';			
			$AcumUnid4 = '';			
			$AcumPeso4 = '';			
			$TotalUni  = '';			
			$TotalPeso = '';
			$AcumFinoAs1 = 0;			
			$AcumFinoSb1 = 0;			
			$AcumFinoFe1 = 0;
			$LeyAs		 =0;
			$LeySb       =0;
			$LeyFe		 = 0;

			
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
				$AcumUnid = '';			
				$AcumPeso = '';
				$AcumFinoAs = 0;			
				$AcumFinoSb = 0;			
				$AcumFinoFe = 0;
				$Consulta = "SELECT unidades as unid, peso as pes, hornada_sea as hor FROM raf_web.movimientos";
				$Consulta.= " WHERE cod_producto = $row["cod_producto"] AND cod_subproducto = $row[cod_subproducto]";
				$Consulta.= " AND hornada = $fila["hornada"]  order by hornada_sea";
				$result = mysqli_query($link, $Consulta);
				while($Fil = mysql_fetch_array($result))
				{
					$FinoSb 	= 0;
					$FinoFe 	= 0;
					$FinoAs 	= 0;
				  	$Calculo1 	= 0;
				  	$Calculo2 	= 0;
				  	$Calculo3 	= 0;
					$AcumAs 	= 0;
					$AcumSb 	= 0;			
					$AcumFe 	= 0;
					$As 		= 0;
				  	$Sb 		= 0;
				  	$Fe 		= 0;
					$AcumUnid = $AcumUnid + $Fil[unid];
				  	$AcumPeso = $AcumPeso + $Fil[pes];
					$hornada  = $Fil[hor];
					if ($Fil[hor] == 0)
					{
						$Consulta = "select max(fecha),valor,cod_leyes from raf_web.leyes_fijas where cod_producto = '".$Fila["cod_producto"]."'";
						$Consulta.= " and cod_subproducto = '".$Fila[cod_subproducto]."' group by cod_producto,cod_subproducto"; 
						$resp2 = mysqli_query($link, $Consulta);
					}
					else
					{	
						$Consulta = "SELECT valor, cod_leyes FROM sea_web.leyes_por_hornada ";
				  		$Consulta.= " WHERE cod_producto = '".$Fila["cod_producto"]."'";
				  		$Consulta.= " AND cod_subproducto = '".$Fila[cod_subproducto]."'";
				  		$Consulta.= " AND hornada = '".$Fil[hor]."'";
				  		$Consulta.= " AND (cod_leyes = '08' or cod_leyes ='09' or cod_leyes = '31') ";
				  		$resp2 = mysqli_query($link, $Consulta);
					}	
					while($fila1 = mysql_fetch_array($resp2))
				  	{
						if($fila1["cod_leyes"] == '08')
						{
							$As = $fila1[valor];
							$Calculo1 	= $Fil[pes] * $As;
							$FinoAs   	= ($Calculo1 / 10000000);
							$AcumFinoAs = $AcumFinoAs + $FinoAs; 
						}	
						elseif($fila1["cod_leyes"] == '09')
						{
							$Sb = $fila1[valor];
							$Calculo2 	= $Fil[pes] * $Sb;
 				  			$FinoSb   	= ($Calculo2 / 10000000);
							$AcumFinoSb = AcumFinoSb + $FinoSb;
						}	
						elseif($fila1["cod_leyes"] == '31')
						{
							$Fe = $fila1[valor];	
							$Calculo3 	= $Fil[pes] * $Fe;
				  			$FinoFe   	= ($Calculo3 / 10000000);
							$AcumFinoFe = $AcumFinoFe + $FinoFe;
						}
							 
					}
					$LeyAs = ($AcumFinoAs / $AcumPeso) * 10000000;
					$LeySb = ($AcumFinoSb / $AcumPeso) * 10000000;
					$LeyFe = ($AcumFinoFe / $AcumPeso) * 10000000;
							//echo "AcumFinoas" .$AcumFinoAs."Peso".$AcumPeso."leyas".$LeyAs;
				}
				echo'<td align="right">'.$AcumUnid.'&nbsp;</td>';
				echo'<td align="right">'.$AcumPeso.'&nbsp;</td>';
				echo'<td align="right">'.number_format($LeyAs,2,'','').'&nbsp;</td>';
				echo'<td align="right">'.number_format($LeySb,2,'','').'&nbsp;</td>';
				echo'<td align="right">'.number_format($LeyFe,2,'','').'&nbsp;</td>';
				echo'<td align="right">'.number_format($AcumFinoAs,2,'','').'&nbsp;</td>'; 
				echo'<td align="right">'.number_format($AcumFinoSb,2,'','').'&nbsp;</td>'; 	
				echo'<td align="right">'.number_format($AcumFinoFe,2,'','').'&nbsp;</td>'; 	
				$TotalUni    = $TotalUni  + $AcumUnid;
				$TotalPeso   = $TotalPeso + $AcumPeso;
				$AcumAs1     = $AcumAs1 + $AcumFinoAs;
				$AcumSb1     = $AcumSb1 + $AcumFinoSb;
				$AcumFe1     = $AcumFe1 + $AcumFinoFe;
				echo'</tr>';
			}
				$AcumA = ($AcumAs1 / $TotalPeso) * 10000000;
				$AcumS = ($AcumSb1 / $TotalPeso) * 10000000; 
				$AcumF = ($AcumFe1 / $TotalPeso) * 10000000; 
				echo'
		    <tr class="Detalle02"> 
		    <td>Totales</td>
		    <td align="right">'.$TotalUni.'&nbsp;</td>
		    <td align="right">'.$TotalPeso.'&nbsp;</td>
		    <td align="right">'.number_format($AcumA,2,'','').'&nbsp;</td>
		    <td align="right">'.number_format($AcumS,2,'','').'&nbsp;</td>
		    <td align="right">'.number_format($AcumF,2,'','').'&nbsp;</td>
		    <td align="right">'.number_format($AcumAs1,2,'','').'&nbsp;</td>
		    <td align="right">'.number_format($AcumSb1,2,'','').'&nbsp;</td>
		    <td align="right">'.number_format($AcumFe1,2,'','').'&nbsp;</td>  
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
