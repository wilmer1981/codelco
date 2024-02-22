<?
	include("../principal/conectar_pac_web.php");
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;

	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;

	$Fecha = $Ano.'-'.$Mes;

    $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
			
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
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

<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body class="TablaPrincipal">
<form name="FrmPrincipal" method="post" action="">
  <table width="400" border="1" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td colspan="4" align="center"><strong> Cobre En Proceso Hornos Raf</strong></td>
    </tr>
    <tr> 
      <td colspan="4" align="center"><strong> Fecha: <? echo $Meses[$Mes-1].'-'.$Ano; ?></strong></td>
    </tr>
  </table>
  <br>
  <br> 	
  <table width="401" border="0" cellspacing="0" cellpadding="0" align="center" class="TablaPrincipal">
    <tr> 
      <td colspan="4" class="Detalle01"><b>Hornos Reverberos</b></td>
	  <?
		$Consulta = "SELECT max(hornada) as horn_max,min(hornada) as horn_min FROM raf_web.det_carga";
		$Consulta.= " WHERE left(fecha,7) = '$Fecha'"; 
		$Consulta.= " AND right(hornada,4) BETWEEN '1000' AND '3999'";
		$rs = mysql_query($Consulta);
		$Fila = mysql_fetch_array($rs);
		$Hornada_Min = substr($Fila[horn_min],6,4);	  
		$Hornada_Max = substr($Fila[horn_max],6,4);	  
	  ?>
      <td width="212" colspan="4" class="Detalle01"><strong>Hornadas</strong>:<? echo $Hornada_Min.'/'.$Hornada_Max;?> 
      </td>
    </tr>
  </table>

  <table width="640" border="1" cellspacing="0" cellpadding="0" align="center" class="TablaPrincipal">
    <tr class="ColorTabla01">
      <td width="112">&nbsp;</td>
      <td width="59">&nbsp;</td>
      <td width="52">&nbsp;</td>
      <td width="62">&nbsp;</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Finos</td>
    </tr>
    <tr class="Detalle01">
      <td>Productos</td>
      <td align="center">P. Hdo</td>
      <td align="center">Hdad.%</td>
      <td align="center">P Seco</td>
      <td width="56" align="center">Cobre %</td>
      <td width="59" align="center">Plata g/t</td>
      <td width="50" align="center">Oro g/t</td>
      <td width="60" align="center">Cobre kgs</td>
      <td width="55" align="center">Plata grs</td>
      <td width="53" align="center">Oro grs</td>
    </tr>
    <tr>
      <td>Restos Anodos</td>
	  <?
	  //Peso Humedo
	  $Consulta = "SELECT SUM(peso) as peso_restos FROM raf_web.det_carga";
	  $Consulta.= " WHERE cod_producto = 19";
	  $Consulta.= " AND left(fecha,7) = '$Fecha'";  
	  $Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
	  $rs = mysql_query($Consulta);
	  $Fila = mysql_fetch_array($rs);
	  $PesoRestos = $Fila[peso_restos];		  
	  ?>	
      <td align="right"><? echo number_format($PesoRestos,0,'','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($PesoRestos,0,'','.');?>&nbsp;</td>
	  <?
		$Consulta = "SELECT distinct hornada_sea FROM raf_web.det_carga";
		$Consulta.= " WHERE cod_producto = 19";
		$Consulta.= " AND left(fecha,7) = '$Fecha'";  
		$Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
		$rs = mysql_query($Consulta);
		$cont = '';
		$cont1 = '';
		$cont2 = '';
		$cont3 = '';
		while($Fila = mysql_fetch_array($rs))
		{
			$cont++;
			$Consulta = "SELECT valor, cod_leyes FROM sea_web.leyes_por_hornada ";
			$Consulta.= " WHERE hornada = '".$Fila[hornada_sea]."'";
			$Consulta.= " AND (cod_leyes = '02' or cod_leyes ='04' or cod_leyes = '05') ";
			$resp = mysql_query($Consulta);
			while($fila1 = mysql_fetch_array($resp))
			{
				if($fila1["cod_leyes"] == '02')
				{
					$Cu = $Cu + $fila1[valor];
					$AcumCu = $AcumCu + $fila1[valor];
					$Cont1++;
					$cont1++;
				}
				if($fila1["cod_leyes"] == '04')
				{
					$Ag = $Ag + $fila1[valor];
					$AcumAg = $AcumAg + $fila1[valor];
					$Cont2++;
					$cont2++;
				}
				if($fila1["cod_leyes"] == '05')
				{
					$Au = $Au + $fila1[valor];
					$AcumAu = $AcumAu + $fila1[valor];
					$Cont3++;
					$cont3++;
				}
			}										
		}		  
		//Leyes
		if($cont != 0 || $cont != '')
		{
			echo'<td align="right">'.number_format($Cu/$cont1,2,',','').'&nbsp;</td>';
			echo'<td align="right">'.number_format($Ag/$cont2,2,',','').'&nbsp;</td>';
			echo'<td align="right">'.number_format($Au/$cont3,2,',','').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';						
		}
		//Finos
		if($cont != 0 || $cont != '')
		{
			echo'<td align="right">'.number_format(($PesoRestos*($Cu/$cont1))/100,0,',','.').'&nbsp;</td>';
			echo'<td align="right">'.number_format(($PesoRestos*($Ag/$cont2))/1000,0,',','.').'&nbsp;</td>';
			echo'<td align="right">'.number_format(($PesoRestos*($Au/$cont3))/1000,0,',','.').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';						
		}

	  ?> 	
    </tr>
    <tr>
      <td>Anod. Rech. TTE</td>
	  <?
	  //Peso Humedo
	  $Consulta = "SELECT SUM(peso) as peso_tte FROM raf_web.det_carga";
	  $Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 2";
	  $Consulta.= " AND left(fecha,7) = '$Fecha'";  
	  $Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
	  $rs = mysql_query($Consulta);
	  $Fila = mysql_fetch_array($rs);
	  $PesoTTE = $Fila[peso_tte];		  
	  ?>	
      <td align="right"><? echo number_format($PesoTTE,0,'','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($PesoTTE,0,'','.');?>&nbsp;</td>
	  <?
		$Consulta = "SELECT distinct hornada_sea FROM raf_web.det_carga";
 	    $Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 2";
		$Consulta.= " AND left(fecha,7) = '$Fecha'";  
		$Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
		$rs = mysql_query($Consulta);
		$cont = '';
		$cont1 = '';
		$cont2 = '';
		$cont3 = '';
		$Cu = '';
		$Ag = '';		
		$Au = '';
		while($Fila = mysql_fetch_array($rs))
		{
			$cont++;
			$Consulta = "SELECT valor, cod_leyes FROM sea_web.leyes_por_hornada ";
			$Consulta.= " WHERE hornada = '".$Fila[hornada_sea]."'";
			$Consulta.= " AND (cod_leyes = '02' or cod_leyes ='04' or cod_leyes = '05') ";
			$resp = mysql_query($Consulta);
			while($fila1 = mysql_fetch_array($resp))
			{
				if($fila1["cod_leyes"] == '02')
				{
					$Cu = $Cu + $fila1[valor];
					$AcumCu = $AcumCu + $fila1[valor];
					$Cont1++;
					$cont1++;
				}
				if($fila1["cod_leyes"] == '04')
				{
					$Ag = $Ag + $fila1[valor];
					$AcumAg = $AcumAg + $fila1[valor];
					$Cont2++;
					$cont2++;
				}
				if($fila1["cod_leyes"] == '05')
				{
					$Au = $Au + $fila1[valor];
					$AcumAu = $AcumAu + $fila1[valor];
					$Cont3++;
					$cont3++;
				}
			}										
		}		  	
		//Leyes
		if($cont != 0 || $cont != '')
		{
			echo'<td align="right">'.number_format($Cu/$cont1,2,',','').'&nbsp;</td>';
			echo'<td align="right">'.number_format($Ag/$cont2,2,',','').'&nbsp;</td>';
			echo'<td align="right">'.number_format($Au/$cont3,2,',','').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
		}

		//Finos
		if($cont != 0 || $cont != '')
		{
		    echo'<td align="right">'.number_format(($PesoTTE*($Cu/$cont1))/100,0,',','.').'&nbsp;</td>';
		    echo'<td align="right">'.number_format(($PesoTTE*($Ag/$cont2))/1000,0,',','.').'&nbsp;</td>';
	    	echo'<td align="right">'.number_format(($PesoTTE*($Au/$cont3))/1000,0,',','.').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';		
		}

	  ?> 	
    </tr>

    <tr>
      <td>Anod. Rech. HVL</td>
	  <?
	  //Peso Humedo
	  $Consulta = "SELECT SUM(peso) as peso_hvl FROM raf_web.det_carga";
	  $Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 1";
	  $Consulta.= " AND left(fecha,7) = '$Fecha'";  
	  $Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
	  $rs = mysql_query($Consulta);
	  $Fila = mysql_fetch_array($rs);
	  $PesoHVL = $Fila[peso_hvl];		  
	  ?>	
      <td align="right"><? echo number_format($PesoHVL,0,'','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($PesoHVL,0,'','.');?>&nbsp;</td>
	  <?
		$Consulta = "SELECT distinct hornada_sea FROM raf_web.det_carga";
 	    $Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 1";
		$Consulta.= " AND left(fecha,7) = '$Fecha'";  
		$Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
		$rs = mysql_query($Consulta);
		$cont = '';
		$cont1 = '';
		$cont2 = '';
		$cont3 = '';
		$Cu = '';
		$Ag = '';		
		$Au = '';
		while($Fila = mysql_fetch_array($rs))
		{
			$cont++;
			$Consulta = "SELECT valor, cod_leyes FROM sea_web.leyes_por_hornada ";
			$Consulta.= " WHERE hornada = '".$Fila[hornada_sea]."'";
			$Consulta.= " AND (cod_leyes = '02' or cod_leyes ='04' or cod_leyes = '05') ";
			$resp = mysql_query($Consulta);
			while($fila1 = mysql_fetch_array($resp))
			{
				if($fila1["cod_leyes"] == '02')
				{
					$Cu = $Cu + $fila1[valor];
					$AcumCu = $AcumCu + $fila1[valor];
					$Cont1++;
					$cont1++;
				}
				if($fila1["cod_leyes"] == '04')
				{
					$Ag = $Ag + $fila1[valor];
					$AcumAg = $AcumAg + $fila1[valor];
					$Cont2++;
					$cont2++;
				}
				if($fila1["cod_leyes"] == '05')
				{
					$Au = $Au + $fila1[valor];
					$AcumAu = $AcumAu + $fila1[valor];
					$Cont3++;
					$cont3++;
				}
			}										
		}		  	
		//Leyes
		if($cont != 0 || $cont != '')
		{
		    echo'<td align="right">'.number_format($Cu/$cont1,2,',','').'&nbsp;</td>';
		    echo'<td align="right">'.number_format($Ag/$cont2,2,',','').'&nbsp;</td>';
	    	echo'<td align="right">'.number_format($Au/$cont3,2,',','').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';						
		}
		//Finos
		if($cont != 0 || $cont != '')
		{
			echo'<td align="right">'.number_format(($PesoHVL*($Cu/$cont1))/100,0,',','.').'&nbsp;</td>';
			echo'<td align="right">'.number_format(($PesoHVL*($Ag/$cont2))/1000,0,',','.').'&nbsp;</td>';
			echo'<td align="right">'.number_format(($PesoHVL*($Au/$cont3))/1000,0,',','.').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';						
		}


	  ?> 	
    </tr>	
    <tr>
      <td>Anod. Rech. Comer.</td>
	  <?
	  //Peso Humedo
	  $Consulta = "SELECT SUM(peso) as peso_vent FROM raf_web.det_carga";
	  $Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 4";
	  $Consulta.= " AND left(fecha,7) = '$Fecha'";  
	  $Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
	  $rs = mysql_query($Consulta);
	  $Fila = mysql_fetch_array($rs);
	  $PesoVent = $Fila[peso_vent];		  
	  ?>	
      <td align="right"><? echo number_format($PesoVent,0,'','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($PesoVent,0,'','.');?>&nbsp;</td>
	  <?
		$Consulta = "SELECT distinct hornada_sea FROM raf_web.det_carga";
 	    $Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 4";
		$Consulta.= " AND left(fecha,7) = '$Fecha'";  
		$Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
		$rs = mysql_query($Consulta);
		$cont = '';
		$cont1 = '';
		$cont2 = '';
		$cont3 = '';
		$Cu = '';
		$Ag = '';		
		$Au = '';
		while($Fila = mysql_fetch_array($rs))
		{
			$cont++;
			$Consulta = "SELECT valor, cod_leyes FROM sea_web.leyes_por_hornada ";
			$Consulta.= " WHERE hornada = '".$Fila[hornada_sea]."'";
			$Consulta.= " AND (cod_leyes = '02' or cod_leyes ='04' or cod_leyes = '05') ";
			$resp = mysql_query($Consulta);
			while($fila1 = mysql_fetch_array($resp))
			{
				if($fila1["cod_leyes"] == '02')
				{
					$Cu = $Cu + $fila1[valor];
					$AcumCu = $AcumCu + $fila1[valor];
					$Cont1++;
					$cont1++;
				}
				if($fila1["cod_leyes"] == '04')
				{
					$Ag = $Ag + $fila1[valor];
					$AcumAg = $AcumAg + $fila1[valor];
					$Cont2++;
					$cont2++;
				}
				if($fila1["cod_leyes"] == '05')
				{
					$Au = $Au + $fila1[valor];
					$AcumAu = $AcumAu + $fila1[valor];
					$Cont3++;
					$cont3++;
				}
			}										
		}		  	
		//Leyes
		if($cont != 0 || $cont != '')
		{
		    echo'<td align="right">'.number_format($Cu/$cont1,2,',','').'&nbsp;</td>';
		    echo'<td align="right">'.number_format($Ag/$cont2,2,',','').'&nbsp;</td>';
	    	echo'<td align="right">'.number_format($Au/$cont3,2,',','').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';						
		}
		//Finos
		if($cont != 0 || $cont != '')
		{
			echo'<td align="right">'.number_format(($PesoVent*($Cu/$cont1))/100,0,',','.').'&nbsp;</td>';
			echo'<td align="right">'.number_format(($PesoVent*($Ag/$cont2))/1000,0,',','.').'&nbsp;</td>';
			echo'<td align="right">'.number_format(($PesoVent*($Au/$cont3))/1000,0,',','.').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';						
		}


	  ?> 	
    </tr>
    <tr>
      <td>Anod. Rech. H.M.</td>
	  <?
	  //Peso Humedo
	  $Consulta = "SELECT SUM(peso) as peso_hm FROM raf_web.det_carga";
	  $Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 8";
	  $Consulta.= " AND left(fecha,7) = '$Fecha'";  
	  $Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
	  $rs = mysql_query($Consulta);
	  $Fila = mysql_fetch_array($rs);
	  $PesoHm = $Fila[peso_hm];		  
	  ?>	
      <td align="right"><? echo number_format($PesoHm,0,'','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($PesoHm,0,'','.');?>&nbsp;</td>
	  <?
		$Consulta = "SELECT distinct hornada_sea FROM raf_web.det_carga";
 	    $Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 8";
		$Consulta.= " AND left(fecha,7) = '$Fecha'";  
		$Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
		$rs = mysql_query($Consulta);
		$cont = '';
		$cont1 = '';
		$cont2 = '';
		$cont3 = '';
		$Cu = '';
		$Ag = '';		
		$Au = '';
		while($Fila = mysql_fetch_array($rs))
		{
			$cont++;
			$Consulta = "SELECT valor, cod_leyes FROM sea_web.leyes_por_hornada ";
			$Consulta.= " WHERE hornada = '".$Fila[hornada_sea]."'";
			$Consulta.= " AND (cod_leyes = '02' or cod_leyes ='04' or cod_leyes = '05') ";
			$resp = mysql_query($Consulta);
			while($fila1 = mysql_fetch_array($resp))
			{
				if($fila1["cod_leyes"] == '02')
				{
					$Cu = $Cu + $fila1[valor];
					$AcumCu = $AcumCu + $fila1[valor];
					$Cont1++;
					$cont1++;
				}
				if($fila1["cod_leyes"] == '04')
				{
					$Ag = $Ag + $fila1[valor];
					$AcumAg = $AcumAg + $fila1[valor];
					$Cont2++;
					$cont2++;
				}
				if($fila1["cod_leyes"] == '05')
				{
					$Au = $Au + $fila1[valor];
					$AcumAu = $AcumAu + $fila1[valor];
					$Cont3++;
					$cont3++;
				}
			}										
		}		  	
		//Leyes
		if($cont1 != 0 || $cont1 != '')
		{
		    echo'<td align="right">'.number_format($Cu/$cont1,2,',','').'&nbsp;</td>';
		    echo'<td align="right">'.number_format($Ag/$cont2,2,',','').'&nbsp;</td>';
	    	echo'<td align="right">'.number_format($Au/$cont3,2,',','').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';						
		}
		//Finos
		if($cont1 != 0 || $cont1 != '')
		{
			echo'<td align="right">'.number_format(($PesoHm*($Cu/$cont1))/100,0,',','.').'&nbsp;</td>';
			echo'<td align="right">'.number_format(($PesoHm*($Ag/$cont2))/1000,0,',','.').'&nbsp;</td>';
			echo'<td align="right">'.number_format(($PesoHm*($Au/$cont3))/1000,0,',','.').'&nbsp;</td>';
		}
		else
		{
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';
			echo'<td align="right">&nbsp;</td>';						
		}


	  ?> 	
    </tr>	
    <tr>
      <td>Blister Liquido</td>
	  <?
	  //Peso Humedo
	  $Consulta = "SELECT SUM(peso) as peso_blister FROM raf_web.det_carga";
	  $Consulta.= " WHERE cod_producto = 16 AND cod_subproducto IN ('40','41','42')";
	  $Consulta.= " AND left(fecha,7) = '$Fecha'";  
	  $Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
	  $rs = mysql_query($Consulta);
	  $Fila = mysql_fetch_array($rs);
	  $PesoBlister = $Fila[peso_blister];		  
	  ?>	
      <td align="right"><? echo number_format($PesoBlister,0,'','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($PesoBlister,0,'','.');?>&nbsp;</td>
	  <?
		$Consulta = "select t2.cod_leyes, t2.valor, t2.cod_unidad, t3.conversion ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
		$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
		$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad ";
		$Consulta.= " where t1.cod_periodo = '2'"; //POR SEMANA
		$Consulta.= " and t1.cod_producto = '16'";
		$Consulta.= " and t1.cod_subproducto IN ('40','41','42')";
		$Consulta.= " and t1.tipo = '1'";
		$Consulta.= " and t1.cod_analisis = '1'";
		$Consulta.= " and t1.a�o = '".intval(substr($Fecha,0,4))."' ";
		$Consulta.= " and t1.mes = '".intval(substr($Fecha,5,2))."' ";	
		$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";						
		$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
		$Consulta.= " order by t1.id_muestra, t2.cod_leyes";
		$rs = mysql_query($Consulta);
		$cont1 = '';
		$cont2 = '';
		$cont3 = '';
		$Cu = '';
		$Ag = '';		
		$Au = '';
		while($Fila = mysql_fetch_array($rs))
		{
				if($Fila["cod_leyes"] == '02')
				{
					$cont1++;
					$Cu = $Cu + $Fila[valor];
					$AcumCu = $AcumCu + $Fila[valor];
					$Cont1++;
				}
				if($Fila["cod_leyes"] == '04')
				{
					$cont2++;
					$Ag = $Ag + $Fila[valor];
					$AcumAg = $AcumAg + $Fila[valor];
					$Cont2++;
				}
				if($Fila["cod_leyes"] == '05')
				{
					$cont3++;
					$Au = $Au + $Fila[valor];
					$AcumAu = $AcumAu + $Fila[valor];
					$Cont3++;
				}
		}		  	
		//Leyes
		if($cont1 != 0 || $cont1 != '') 
		    echo'<td align="right">'.number_format($Cu/$cont1,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont2 != 0 || $cont2 != '') 		
		    echo'<td align="right">'.number_format($Ag/$cont2,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont3 != 0 || $cont3 != '') 		
	    	echo'<td align="right">'.number_format($Au/$cont3,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';						

		//Finos
		if($cont1 != 0 || $cont1 != '')
			echo'<td align="right">'.number_format(($PesoBlister*($Cu/$cont1))/100,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont2 != 0 || $cont2 != '')
			echo'<td align="right">'.number_format(($PesoBlister*($Ag/$cont2))/1000,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont3 != 0 || $cont3 != '')
			echo'<td align="right">'.number_format(($PesoBlister*($Au/$cont3))/1000,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';						

	  ?> 	
    </tr>	
    <tr>
      <td>Circulantes Raf</td>
	  <?
	  //Peso Humedo
	  $Consulta = "SELECT SUM(peso_humedo) as peso_circ FROM raf_web.leyes_circulantes";
	  $Consulta.= " WHERE cod_producto = 42";
	  $Consulta.= " AND left(fecha,7) = '$Fecha'";  
	  $rs = mysql_query($Consulta);
	  $Fila = mysql_fetch_array($rs);
	  $PesoCirc = $Fila[peso_circ];		  
	  ?>	
      <td align="right"><? echo number_format($PesoCirc,0,'','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($PesoCirc,0,'','.');?>&nbsp;</td>
	  <?
		$Consulta = "SELECT cod_leyes, valor, cod_unidad ";
		$Consulta.= " FROM raf_web.leyes_circulantes";
		$Consulta.= " WHERE cod_producto = 42";
	    $Consulta.= " AND left(fecha,7) = '$Fecha'";  
		$rs = mysql_query($Consulta);
		$cont1 = '';
		$cont2 = '';
		$cont3 = '';
		$Cu = '';
		$Ag = '';		
		$Au = '';
		while($Fila = mysql_fetch_array($rs))
		{
				if($Fila["cod_leyes"] == '02')
				{
					$cont1++;
					$Cu = $Cu + $Fila[valor];
					$AcumCu = $AcumCu + $Fila[valor];
					$Cont1++;
				}
				if($Fila["cod_leyes"] == '04')
				{
					$cont2++;
					$Ag = $Ag + $Fila[valor];
					$AcumAg = $AcumAg + $Fila[valor];
					$Cont2++;
				}
				if($Fila["cod_leyes"] == '05')
				{
					$cont3++;
					$Au = $Au + $Fila[valor];
					$AcumAu = $AcumAu + $Fila[valor];
					$Cont3++;
				}
		}		  	
		//Leyes
		if($cont1 != 0 || $cont1 != '') 
		    echo'<td align="right">'.number_format($Cu/$cont1,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont2 != 0 || $cont2 != '') 		
		    echo'<td align="right">'.number_format($Ag/$cont2,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont3 != 0 || $cont3 != '') 		
	    	echo'<td align="right">'.number_format($Au/$cont3,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';						

		//Finos
		if($cont1 != 0 || $cont1 != '')
			echo'<td align="right">'.number_format(($PesoCirc*($Cu/$cont1))/100,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont2 != 0 || $cont2 != '')
			echo'<td align="right">'.number_format(($PesoCirc*($Ag/$cont2))/1000,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont3 != 0 || $cont3 != '')
			echo'<td align="right">'.number_format(($PesoCirc*($Au/$cont3))/1000,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';						

	  ?> 	
    </tr>		
    <tr class="ColorTabla02">
      <td>Total</td>
	  <?
			$Total = $PesoBlister + $PesoHm + $PesoRestos + $PesoHVL + $PesoTTE + $PesoVent + $PesoCirc; 
	  ?>	
      <td align="right"><? echo number_format($Total,0,'','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($Total,0,'','.');?>&nbsp;</td>
<?		
//Leyes
		if($Cont1 != 0 || $Cont1 != '' AND ($PesoBlister != 0 || $PesoBlister != ''))
			echo'<td align="right">'.number_format($AcumCu/$Cont1,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($Cont2 != 0 || $Cont2 != '' AND ($PesoBlister != 0 || $PesoBlister != ''))
			echo'<td align="right">'.number_format($AcumAg/$Cont2,2,',','').'&nbsp;</td>';
    	else	
			echo'<td align="right">&nbsp;</td>';

		if($Cont3 != 0 || $Cont3 != '' AND ($PesoBlister != 0 || $PesoBlister != ''))
			echo'<td align="right">'.number_format($AcumAu/$Cont3,2,',','').'&nbsp;</td>';
    	else	
			echo'<td align="right">&nbsp;</td>';

	//Finos
		if($Cont1 != 0 || $Cont1 != '' AND ($PesoBlister != 0 || $PesoBlister != ''))
			echo'<td align="right">'.number_format(($Total*($AcumCu/$Cont1))/100,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($Cont2 != 0 || $Cont2 != '' AND ($PesoBlister != 0 || $PesoBlister != ''))
			echo'<td align="right">'.number_format(($Total*($AcumAg/$Cont2))/1000,0,',','.').'&nbsp;</td>';
    	else	
			echo'<td align="right">&nbsp;</td>';

		if($Cont3 != 0 || $Cont3 != '' AND ($PesoBlister != 0 || $PesoBlister != ''))
			echo'<td align="right">'.number_format(($Total*($AcumAu/$Cont3))/1000,0,',','.').'&nbsp;</td>';
    	else	
			echo'<td align="right">&nbsp;</td>';

	  ?> 	
    </tr>				
  </table>
  <br>
  
<!--  Horno Basculante  -->  
  <table width="401" border="0" cellspacing="0" cellpadding="0" align="center" class="TablaPrincipal">
    <tr> 
      <td colspan="4" class="Detalle01"><b>Horno Basculante</b></td>
	  <?
		$Consulta = "SELECT max(hornada) as horn_max,min(hornada) as horn_min FROM raf_web.det_carga";
		$Consulta.= " WHERE left(fecha,7) = '$Fecha'"; 
		$Consulta.= " AND right(hornada,4) BETWEEN '4000' AND '4999'";
		$rs = mysql_query($Consulta);
		$Fila = mysql_fetch_array($rs);
		$Hornada_Min = substr($Fila[horn_min],6,4);	  
		$Hornada_Max = substr($Fila[horn_max],6,4);	  
	  ?>
      <td width="212" colspan="4" class="Detalle01"><strong>Hornadas</strong>:<? echo $Hornada_Min.'/'.$Hornada_Max;?> 
      </td>
    </tr>
  </table>
  <table width="640" border="1" cellspacing="0" cellpadding="0" align="center" class="TablaPrincipal">
    <tr class="ColorTabla01">
      <td width="112">&nbsp;</td>
      <td width="59">&nbsp;</td>
      <td width="52">&nbsp;</td>
      <td width="62">&nbsp;</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Finos</td>
    </tr>
    <tr class="Detalle01">
      <td>Productos</td>
      <td align="center">P. Hdo</td>
      <td align="center">Hdad.%</td>
      <td align="center">P Seco</td>
      <td width="56" align="center">Cobre %</td>
      <td width="59" align="center">Plata g/t</td>
      <td width="50" align="center">Oro g/t</td>
      <td width="60" align="center">Cobre kgs</td>
      <td width="55" align="center">Plata grs</td>
      <td width="53" align="center">Oro grs</td>
    </tr>
    <tr>
      <td>Blister Liquido</td>
	  <?
	  //Peso Humedo
	  $Consulta = "SELECT SUM(peso) as peso_blister FROM raf_web.det_carga";
	  $Consulta.= " WHERE cod_producto = 16 AND cod_subproducto IN ('40','41','42')";
	  $Consulta.= " AND left(fecha,7) = '$Fecha'";  
	  $Consulta.= " AND right(hornada,4) BETWEEN '$Hornada_Min' AND '$Hornada_Max'";  
	  $rs = mysql_query($Consulta);
	  $Fila = mysql_fetch_array($rs);
	  $PesoBlister = $Fila[peso_blister];		  
	  ?>	
      <td align="right"><? echo number_format($PesoBlister,0,'','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($PesoBlister,0,'','.');?>&nbsp;</td>
	  <?
		if($PesoBlister != 0 || $PesoBlister != '')
		{
			$Consulta = "select t2.cod_leyes, t2.valor, t2.cod_unidad, t3.conversion ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
			$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
			$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad ";
			$Consulta.= " where t1.cod_periodo = '2'"; //POR SEMANA
			$Consulta.= " and t1.cod_producto = '16'";
			$Consulta.= " and t1.cod_subproducto IN ('40','41','42')";
			$Consulta.= " and t1.tipo = '1'";
			$Consulta.= " and t1.cod_analisis = '1'";
			$Consulta.= " and t1.a�o = '".intval(substr($Fecha,0,4))."' ";
			$Consulta.= " and t1.mes = '".intval(substr($Fecha,5,2))."' ";	
			$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";						
			$Consulta.= " and (t2.valor <> '' and NOT isnull(t2.valor))";
			$Consulta.= " order by t1.id_muestra, t2.cod_leyes";
			$rs = mysql_query($Consulta);
			$cont1 = '';
			$cont2 = '';
			$cont3 = '';
			$Cu = '';
			$Ag = '';		
			$Au = '';
			while($Fila = mysql_fetch_array($rs))
			{
					if($Fila["cod_leyes"] == '02')
					{
						$cont1++;
						$Cu = $Cu + $Fila[valor];
						$AcumCu = $AcumCu + $Fila[valor];
						$Cont1++;
					}
					if($Fila["cod_leyes"] == '04')
					{
						$cont2++;
						$Ag = $Ag + $Fila[valor];
						$AcumAg = $AcumAg + $Fila[valor];
						$Cont2++;
					}
					if($Fila["cod_leyes"] == '05')
					{
						$cont3++;
						$Au = $Au + $Fila[valor];
						$AcumAu = $AcumAu + $Fila[valor];
						$Cont3++;
					}
			}		  	
		}		
		//Leyes
		if(($cont1 != 0 || $cont1 != '') AND ($PesoBlister != 0 || $PesoBlister != '')) 
		    echo'<td align="right">'.number_format($Cu/$cont1,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont2 != 0 || $cont2 != '' AND ($PesoBlister != 0 || $PesoBlister != '')) 		
		    echo'<td align="right">'.number_format($Ag/$cont2,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont3 != 0 || $cont3 != '' AND ($PesoBlister != 0 || $PesoBlister != '')) 		
	    	echo'<td align="right">'.number_format($Au/$cont3,2,',','').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';						

		//Finos
		if($cont1 != 0 || $cont1 != '' AND ($PesoBlister != 0 || $PesoBlister != ''))
			echo'<td align="right">'.number_format(($PesoBlister*($Cu/$cont1))/100,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont2 != 0 || $cont2 != '' AND ($PesoBlister != 0 || $PesoBlister != ''))
			echo'<td align="right">'.number_format(($PesoBlister*($Ag/$cont2))/1000,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';

		if($cont3 != 0 || $cont3 != '' AND ($PesoBlister != 0 || $PesoBlister != ''))
			echo'<td align="right">'.number_format(($PesoBlister*($Au/$cont3))/1000,0,',','.').'&nbsp;</td>';
		else
			echo'<td align="right">&nbsp;</td>';						

	  ?> 	
    </tr>		
  </table>
  <br>
  <table width="640" border="1" cellspacing="0" cellpadding="0" align="center" class="TablaPrincipal">
	<tr class="Detalle01">
      <td width="112">Totales</td>	  
      <td width="59" align="center"><? echo number_format($Total,0,'','.');?>&nbsp;</td>
      <td width="51" align="right">&nbsp;</td>
      <td width="59" align="center"><? echo number_format($Total,0,'','.');?>&nbsp;</td>
<?
//Leyes
		if($Cont1 != 0 || $Cont1 != '')
			echo'<td width="56" align="right">'.number_format($AcumCu/$Cont1,2,',','').'&nbsp;</td>';
		else
			echo'<td width="56" align="right">&nbsp;</td>';

		if($Cont2 != 0 || $Cont2 != '')
			echo'<td width="59" align="right">'.number_format($AcumAg/$Cont2,2,',','').'&nbsp;</td>';
    	else	
			echo'<td width="59" align="right">&nbsp;</td>';

		if($Cont3 != 0 || $Cont3 != '')
			echo'<td width="50" align="right">'.number_format($AcumAu/$Cont3,2,',','').'&nbsp;</td>';
    	else	
			echo'<td width="50" align="right">&nbsp;</td>';

		if($Cont1 != 0 || $Cont1 != '')
			echo'<td width="60" align="right">'.number_format(($Total*($AcumCu/$Cont1))/100,0,',','.').'&nbsp;</td>';
		else
			echo'<td width="60" align="right">&nbsp;</td>';

		if($Cont2 != 0 || $Cont2 != '')
			echo'<td width="55" align="right">'.number_format(($Total*($AcumAg/$Cont2))/1000,0,',','.').'&nbsp;</td>';
    	else	
			echo'<td width="55" align="right">&nbsp;</td>';

		if($Cont3 != 0 || $Cont3 != '')
			echo'<td width="53" align="right">'.number_format(($Total*($AcumAu/$Cont3))/1000,0,',','.').'&nbsp;</td>';
    	else	
			echo'<td width="53" align="right">&nbsp;</td>';
	  ?>
	</tr>  
  </table> 
  <br>	
  
  <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">  
	<tr>
	  <td align="center">	
 	   <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('P');">
	   <? if($Valor != 1)
	   	  {	
	   ?>
	         <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
	   <?
		  } 	
	      else
	   	  {	
	   ?>
   	         <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="self.close()">
	   <? 
	   	  }	
	   ?>

      </td>
	</tr>
  </table>	
</form>
</body>
</html>
