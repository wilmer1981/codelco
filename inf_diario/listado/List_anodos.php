<?php
include("conectar_7.php"); 
	
//include("../../principal/conectar_sea_web.php");
	/*$dia = date("j");
	$mes = date("n");
	$ano = date("Y");
	
	if(strlen($mes) == 1)
		$mes = '0'.$mes;
	if(strlen($dia) == 1)
		$dia = '0'.$dia;

	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;
	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;*/

	//echo "FFFFF".$ano.'-'.$mes.'-'.$dia;
	$Dia = $dia;
	$Mes = $mes;
	$Ano = $ano;
	//echo "EEEEEEE".$Fecha;

	$FechaIni = date("Y-m-d",mktime(7,59,59,$Mes,($Dia - 1),$Ano));	//Fecha para recepciones
	//Fechas Periodo
	$Fecha_Ini = $Ano.'-'.$Mes.'-01';			
	$Fecha_Ter = date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano));
	$Fecha_Ter2 = date($Ano.'-'.$Mes.'-'.$Dia, mktime(1,0,0,$Mes,($Dia +1),$Ano));
//echo "ffff".$Fecha_Ini;
	
	$FechaInicio=$Ano.'-'.$Mes.'-01 08:00:00';
	$FechaTermino =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano))." 07:59:59";
	 
?>
<html>
<head>
<title>Informe Diario Productos Intermedios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Proceso(opc)
{
	var f = document.FrmPrincipal;
	switch (opc)
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
  <br>
  <?php /*
  <table width="561" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><strong>MOVIMIENTOS ACUMULADOS DE ANODOS</strong></td>
      <td width="264"><strong>PERIODO:</strong>&nbsp;&nbsp;<? echo '01-'.$Mes.'-'.$Ano?> AL <? echo $Dia.'-'.$Mes.'-'.$Ano?></td>
    </tr>
  </table>
  <table width="668" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla01">
      <td width="85" align="center">Productos</td>
      <td width="64" align="center">Ex Inicial</td>
      <td align="center" colspan="3">Recepcion</td>
      <td width="64" align="center">A N. Electr.</td>
      <td  align="center" colspan="2">Reproceso a Raf</td>
      <td width="63" align="center">Otros</td>
	  <td width="63" align="center">A</td>
      <td width="73" align="center">Ex Final</td>
    </tr>
    <tr class="Detalle01">
      <td>Anodos</td>
      <td align="center">1&deg; Del Mes</td>
      <td width="55" align="center">Real</td>
      <td width="55" align="center">Proyec</td>
      <td width="53" align="center">Faltan</td>
      <td width="64" align="center">N. Electro.</td>
      <td width="54" align="center">Fisico</td>
	  <td width="61" align="center">Quimico</td>
      <td align="center">Destinos</td>
	  <td align="center">Embarque</td>
      <td align="center">A La Fecha</td>
    </tr>
   	  <?    //ANODOS
			$Consulta = "SELECT distinct cod_subproducto FROM sea_web.movimientos WHERE cod_producto = 17 ";
			//$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter'";
			$resp = mysqli_query($Consulta);
			while($Fila = mysqli_fetch_array($resp))
			{
				echo'<tr>';
				  $ExFinal = 0;
				  $AcumIni2 = 0;
				  $AcumRecep2 = 0;
				  $AcumNave2 = 0;
				  $AcumRaf2 = 0;
				  $AcumDest2 = 0;
				  $AcumEmbResto = 0;
				  $Falta = 0;
				  //Abreviatura
				  $Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto WHERE cod_producto = 17";
				  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto]";	
				  $result = mysqli_query($Consulta);
				  $Fil = mysqli_fetch_array($result);	
				  echo'<td>'.$Fil[abreviatura].'&nbsp;</td>';

                 //STOCK INICIAL
				
				 
                  $Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
                  $Consulta.= " FROM sea_web.stock ";
                  $Consulta.= " WHERE cod_producto = 17";
                  $Consulta.= " AND cod_subproducto = '".$Fila[cod_subproducto]."'";
                  $Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH))";
                  $Consulta.= " GROUP BY cod_producto, cod_subproducto";
			      $rs2 = mysqli_query($Consulta);
				  $Fil2 = mysqli_fetch_array($rs2);						
				  echo'<td align="right">'.number_format($Fil2[peso]/1000,0,"",".").'&nbsp;</td>';
				  $AcumIni = $AcumIni + $Fil2[peso];
				  $AcumIni2 = $AcumIni2 + $Fil2[peso];
 				  
				  //Recep 	
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17 ";
				  if ($Fila[cod_subproducto]==4 || $Fila[cod_subproducto]==8)
				  { 
				  	$Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto] AND tipo_movimiento IN (1,44)";	
				  }
				  else
				  { 
				  	$Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto] AND tipo_movimiento = 1 ";	
				  }				  
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
				
			      $rs3 = mysqli_query($Consulta);
				  $Fil3 = mysqli_fetch_array($rs3);						
				  echo'<td align="right">'.number_format($Fil3[peso]/1000,0,"",".").'&nbsp;</td>';
				  $AcumRecep = $AcumRecep + $Fil3[peso];
				  $AcumRecep2 = $AcumRecep2 + $Fil3[peso];
				  if($Fila[cod_subproducto] == 4)
				  {
					  $Consulta = "SELECT Vent FROM sea_web.inf_prod_inter WHERE Fecha = '$Fecha_Ini' AND Tipo = 'P'";
					  $res = mysqli_query($Consulta);
					  $row = mysqli_fetch_array($res);
					  $peso = $row[Vent]*1000;
					  echo'<td align="right">'.number_format($peso/1000,0,"",".").'&nbsp;</td>';
				  }	
				  if($Fila[cod_subproducto] == 8)
				  {
					  $Consulta = "SELECT HMadres FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha_Ini' AND Tipo = 'P'";
					  $res = mysqli_query($Consulta);
					  $row = mysqli_fetch_array($res);
					  $peso = $row[HMadres]*1000;
					  echo'<td align="right">'.number_format($peso/1000,0,"",".").'&nbsp;</td>';
				  }	
				  if($Fila[cod_subproducto] == 1)
				  {
					  $Consulta = "SELECT FHVL FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha_Ini' AND Tipo = 'P'";
					  $res = mysqli_query($Consulta);
					  $row = mysqli_fetch_array($res);
					  $peso = $row[FHVL]*1000;
					  echo'<td align="right">'.number_format($peso/1000,0,"",".").'&nbsp;</td>';
				  }	
				  if($Fila[cod_subproducto] == 2)
				  {
					  $Consulta = "SELECT Teniente FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha_Ini' AND Tipo = 'P'";
					  $res = mysqli_query($Consulta);
					  $row = mysqli_fetch_array($res);
					  $peso = $row[Teniente]*1000;
					  echo'<td align="right">'.number_format($peso/1000,0,"",".").'&nbsp;</td>';
				  }	
				  if($Fila[cod_subproducto] == 3)
				  {
					  $Consulta = "SELECT Disputada FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha_Ini' AND Tipo = 'P'";
					  $res = mysqli_query($Consulta);
					  $row = mysqli_fetch_array($res);
					  $peso = $row[Disputada]*1000;
					  echo'<td align="right">'.number_format($peso/1000,0,"",".").'&nbsp;</td>';
				  }
                  if ($Fila[cod_subproducto] == 13)
                  {
					  $Consulta = "SELECT Expo FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha_Ini' AND Tipo = 'P'";
					  $res = mysqli_query($Consulta);
					  $row = mysqli_fetch_array($res);
					  $peso = $row[Expo]*1000;
					  echo'<td align="right">'.number_format($peso/1000,0,"",".").'&nbsp;</td>';
                  }

				  $Falta = $peso - $Fil3[peso];
                  if ($Fila[cod_subproducto]==13)
                  {
                      $Falta = 0;
                  }
				  $AcumProy = $AcumProy + $peso;	
				  $AcumFalta = $AcumFalta + $Falta;	
				  echo'<td align="right">'.number_format($Falta/1000,0,"",".").'&nbsp;</td>';

				  //Nave	
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17 ";
				  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto] AND tipo_movimiento = 2";	
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			      $rs4 = mysqli_query($Consulta);
				  $Fil4 = mysqli_fetch_array($rs4);						
				  echo'<td align="right">'.number_format($Fil4[peso]/1000,0,"",".").'&nbsp;</td>';
				  $AcumNave = $AcumNave + $Fil4[peso];
				  $AcumNave2 = $AcumNave2 + $Fil4[peso];


				  //Trasp Raf
				  //Rechazo fisico y quimico 2004-01-10 
				$peso_quimico = 0;
				$peso_fisico = 0;
				$peso_quimico_cte = 0;
				$dospesos = 0;
					
				$consulta1 = "select t1.hornada as hornada, t1.peso as peso, t2.valor as valor from sea_web.movimientos as t1";
				$consulta1 = $consulta1. " left join sea_web.leyes_por_hornada as t2 on t1.hornada = t2.hornada and ";
				$consulta1 =  $consulta1. " t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
				$consulta1 =  $consulta1." and t2.cod_leyes = '09' where t1.cod_producto = 17";
				$consulta1 = $consulta1. " and t1.cod_subproducto = $Fila[cod_subproducto] and t1.tipo_movimiento = 4";
				$consulta1 = $consulta1. " and t1.fecha_movimiento between '$Fecha_Ini' and '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
				$ps = mysqli_query($consulta1);
				while($fila_p = mysqli_fetch_array($ps))
				{
					if ($Fila[cod_subproducto] < 5)
						{
							if  ($fila_p[valor] >= 500)
							{
								 $peso_quimico = $peso_quimico + $fila_p[peso];
							}
							else
							{
								$peso_fisico = $peso_fisico + $fila_p[peso]; 
							}					
				    	}
							
				  		if ($Fila[cod_subproducto] > 4)
						{
						   	if ($fila_p[valor] >= 400)
							{
								$peso_quimico = $peso_quimico + $fila_p[peso];
							}	
							else
							{	
								$peso_fisico = $peso_fisico + $fila_p[peso]; 				
				    		}
			  			  }
					}
					echo '<td align="right">'.number_format($peso_fisico/1000,0,"",".").'&nbsp;</td>';
					echo '<td align="right">'.number_format($peso_quimico/1000,0,"",".").'&nbsp;</td>';
                    $AcumRaf = $AcumRaf + $peso_fisico;
					$AcumRaf1 = $AcumRaf1 + $peso_quimico;
					$dospesos = $AcumRaf + $AcumRaf1;
					$AcumRaf2 = $AcumRaf2 + $dospesos ;	
				 /*$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
				  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto] AND tipo_movimiento = 4";	
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter'";
			      $rs5 = mysqli_query($Consulta);
				  $Fil5 = mysqli_fetch_array($rs5);						
				  echo'<td align="right">'.number_format($Fil5[peso]/1000,0,"",".").'&nbsp;</td>';
				  $AcumRaf = $AcumRaf + $Fil5[peso];
				  $AcumRaf2 = $AcumRaf2 + $Fil5[peso];

				  //Otros Destinos
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
				  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto] AND (tipo_movimiento = 5 or tipo_movimiento = 9)";
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			      $rs6 = mysqli_query($Consulta);
				  $Fil6 = mysqli_fetch_array($rs6);	
				  
				  echo'<td align="right">'.number_format($AcumEmbResto/1000,0,"",".").'&nbsp;</td>';
				  
				 // echo'<td>&nbsp;</td>';					
				  echo'<td align="right">'.number_format($Fil6[peso]/1000,0,"",".").'&nbsp;</td>';
				  $AcumDest = $AcumDest + $Fil6[peso];
				  $AcumDest2 = $AcumDest2 + $Fil6[peso];
                  if ($Fila[cod_subproducto]==13)
                  {
                      //echo "otros ".$Fil6[peso];
                   }

				 
				   
				  $ExFinal = $AcumIni2 + $AcumRecep2 - $AcumNave2 - $peso_quimico - $peso_fisico - $AcumDest2;
				  $AcumFinal = $AcumFinal + $ExFinal;
				  
				  echo'<td align="right">'.number_format($ExFinal/1000,0,"",".").'&nbsp;</td>';				  
			    echo'</tr>';
			}				
	  ?>
    <tr class="Detalle01">
      <td>TOTAL TONS.</td>
      <td align="right"><? echo number_format($AcumIni/1000,0,"","."); ?>&nbsp;</td>
      <td align="right"><? echo number_format($AcumRecep/1000,0,"","."); ?>&nbsp;</td>
      <td align="right"><? echo number_format($AcumProy/1000,0,"","."); ?>&nbsp;</td>
      <td align="right"><? echo number_format($AcumFalta/1000,0,"","."); ?>&nbsp;</td>
      <td align="right"><? echo number_format($AcumNave/1000,0,"","."); ?>&nbsp;</td>
	  <td align="right"><? echo number_format($AcumRaf/1000,0,"","."); ?>&nbsp;</td>
	  <td align="right"><? echo number_format($AcumRaf1/1000,0,"","."); ?>&nbsp;</td>
	  <td align="right"><? echo number_format($AcumDest/1000,0,"","."); ?>&nbsp;</td>
	   <td align="right"><? echo number_format($AcumEmbResto/1000,0,"",".");?>&nbsp;</td>
	 
	  <td align="right"><? echo number_format($AcumFinal/1000,0,"","."); ?>&nbsp;</td>
    </tr>
    <tr class="Detalle02">
      <td>RESTOS</td>
   	  <? 
		//RESTOS
		//STOCK INICIAL
		$Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
		$Consulta.= " FROM sea_web.stock ";
		$Consulta.= " WHERE cod_producto = 19";
		$Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH))";
		$Consulta.= " GROUP BY cod_producto, cod_subproducto";
		//echo $Consulta."<br>";
		$rs2 = mysqli_query($Consulta);
		while($Fil2 = mysqli_fetch_array($rs2))						
 	    {
		    $AcumIni5 = $AcumIni5 + $Fil2[peso];
		}
		echo'<td align="right">'.number_format($AcumIni5/1000,0,"",".").'&nbsp;</td>';

		//Prod.	
		$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
		$Consulta = $Consulta." AND tipo_movimiento = 3";	
		$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
		$rs3 = mysqli_query($Consulta);
		$Fil3 = mysqli_fetch_array($rs3);						
 	    $AcumProd5 = $AcumProd5 + $Fil3[peso];
		echo'<td align="right">'.number_format($Fil3[peso]/1000,0,"",".").'&nbsp;</td>';

	    $Consulta = "SELECT Restos FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha_Ini' AND tipo = 'P'";
		$res = mysqli_query($Consulta);
		$row = mysqli_fetch_array($res);
		$peso = $row[Restos]*1000;
		echo'<td align="right">'.number_format($peso/1000,0,"",".").'&nbsp;</td>';
		$Falta = $peso - $Fil3[peso];	
		echo'<td align="right">'.number_format($Falta/1000,0,"",".").'&nbsp;</td>';

		//Nave	
		$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
		$Consulta = $Consulta." AND tipo_movimiento = 2";	
		$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
		$rs4 = mysqli_query($Consulta);
		$Fil4 = mysqli_fetch_array($rs4);						
 	    $AcumNave5 = $AcumNave5 + $Fil4[peso];
		echo'<td align="right">'.number_format($Fil4[peso]/1000,0,"",".").'&nbsp;</td>';

		//RAf	
		$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
		$Consulta = $Consulta." AND tipo_movimiento = 4";	
		$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
		$rs5 = mysqli_query($Consulta);
		$Fil5 = mysqli_fetch_array($rs5);						
 	    $AcumRaf5 = $AcumRaf5 + $Fil5[peso];
		echo'<td align="right">'.number_format($Fil5[peso]/1000,0,"",".").'&nbsp;</td>';
		
		
		
		
		echo'<td align="right">'.number_format($AcumEmbResto/1000,0,"",".").'&nbsp;</td>';
		echo'<td align="right">'.number_format($AcumEmbResto/1000,0,"",".").'&nbsp;</td>';
		//echo'<td>&nbsp;</td>';
		//echo'<td>&nbsp;</td>';
		//embarque
		
		$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
		$Consulta = $Consulta." AND tipo_movimiento = 10";	
		$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
		$rsresto = mysqli_query($Consulta);
		$Filresto = mysqli_fetch_array($rsresto);						
 	    $AcumEmb = $AcumEmb + $Filresto[peso];
		echo'<td align="right">'.number_format($Filresto[peso]/1000,0,"",".").'&nbsp;</td>';

		
	    $ExFinal5 = $AcumIni5 + $AcumProd5 - $AcumNave5 - $AcumRaf5 - $AcumEmb;
		echo'<td align="right">'.number_format($ExFinal5/1000,0,"",".").'&nbsp;</td>';				  
		$ExFinal5 = 0;			  
	 */ ?>		
  <?php /*  </tr>
  </table>
  <br>  
   */ ?>	
  <table width="400" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><strong>DETALLE DE STOCK DE ANODOS EN PROD INTERMEDIOS</strong></td>
    </tr>
  </table>
  <table width="600" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla01">
	 <td>&nbsp;</td>	
	 <td align="center">APROBADOS</td>	
	 <td width="100" rowspan="3" align="center">Moldeo S/Anal.</td>	
	 <td align="center" colspan="4">Objetados</td>	
	  <td width="63" rowspan="3" align="center">Embarque</td>	
	 <td width="63" rowspan="3" align="center">Ex Final A La Fecha</td>	
    </tr>
    <tr class="Detalle01">
	 <td width="92" rowspan="2" align="center">Anodos</td>	
	 <td width="92" rowspan="2" align="center">Total</td>	
	 <td width="83" rowspan="2" align="center">Calafateo</td>	
	 <td align="center" colspan="2">Rechazo</td>	
	 <td width="81" rowspan="2" align="center">Total</td>	
	 
    </tr>
    <tr class="ColorTabla01">
	 <td width="112" align="center">Fisico</td>	
	 <td width="108" align="center">Quimico</td>	
    </tr>
	<?php

		$Consulta = "SELECT MAX(fecha) as fecha FROM sea_web.inf_rechazos WHERE fecha between '$Fecha_Ini' and '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
		$res = mysqli_query($link,$Consulta);
		$fil = mysqli_fetch_array($res);
		$Fecha_B = $fil["fecha"]; 
		$Consulta = "SELECT * FROM sea_web.inf_rechazos WHERE fecha = '$Fecha_B'";
		$rs = mysqli_query($link,$Consulta);
		$AcumFinal3 = 0;
        $AcumAprob  = 0;
        $AcumTotal  = 0;		
		if($row = mysqli_fetch_array($rs))
		{
			$Consulta = "SELECT distinct cod_subproducto FROM sea_web.movimientos WHERE cod_producto = 17 ";
			$resp = mysqli_query($link,$Consulta);
			$AcumFisi  = 0;
			$AcumQuim  = 0;
			$AcumCalaf = 0;
			$AcumAna   = 0;
			while($Fila = mysqli_fetch_array($resp))
			{	
				 $ExFinal3 = 0;
				 $AcumIni3 = 0;
				 $AcumRecep3 = 0;
				 $AcumNave3 = 0;
				 $AcumRaf3 = 0;
				 $AcumDest3 = 0;
				 $AcumRech3 = 0;
				 $Promedio = 0;
				 $PromStock = 0;
				 $PromRecep = 0;
				 $Total = 0;
				 $AcumEmbResto=0; //WSO
				  //Abreviatura
				  $Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto WHERE cod_producto = 17";
				  $Consulta = $Consulta." AND cod_subproducto = ".$Fila["cod_subproducto"]." ";	
				  $result = mysqli_query($link,$Consulta);
				  $Fil = mysqli_fetch_array($result);	
				  echo'<td>'.$Fil["abreviatura"].'&nbsp;</td>';
	
				 //STOCK INICIAL
				  $Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
				  $Consulta.= " FROM sea_web.stock ";
				  $Consulta.= " WHERE cod_producto = 17";
				  $Consulta.= " AND cod_subproducto = '".$Fila["cod_subproducto"]."'";
				  $Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH))";
				  $Consulta.= " GROUP BY cod_producto, cod_subproducto";
				  $rs2 = mysqli_query($link,$Consulta);
				  $Fil2 = mysqli_fetch_array($rs2);
				  $peso = isset($Fil2["peso"])?$Fil2["peso"]:0;
				  $AcumIni3 = $AcumIni3 + $peso;	
				  //Recep 	
				  $Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM sea_web.movimientos WHERE cod_producto = 17 ";
				  if ($Fila["cod_subproducto"]==4 || $Fila["cod_subproducto"]==8)
				  { 
				  	$Consulta = $Consulta." AND cod_subproducto = ".$Fila["cod_subproducto"]." AND tipo_movimiento IN (1,44)";	
				  }
				  else
				  { 
				  	$Consulta = $Consulta." AND cod_subproducto = ".$Fila["cod_subproducto"]." AND tipo_movimiento = 1 ";	
				  }				  
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			      //if ($Fila[cod_subproducto]==4 || $Fila[cod_subproducto]==8)
				  //		echo "recep".$Consulta;
				  $rs3 = mysqli_query($link,$Consulta);
				  $Fil3 = mysqli_fetch_array($rs3);						
				  $AcumRecep3 = $AcumRecep3 + $Fil3["peso"];

				  //Nave	
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17 ";
				  $Consulta = $Consulta." AND cod_subproducto = ".$Fila["cod_subproducto"]." AND tipo_movimiento = 2";	
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			      //if ($Fila[cod_subproducto]==4 || $Fila[cod_subproducto]==8)
				  //	   echo "benef".$Consulta;
				  $rs4 = mysqli_query($link,$Consulta);
				  $Fil4 = mysqli_fetch_array($rs4);						
				  $AcumNave3 = $AcumNave3 + $Fil4["peso"];
	
				  //Trasp Raf
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
				  $Consulta = $Consulta." AND cod_subproducto = ".$Fila["cod_subproducto"]." AND tipo_movimiento = 4";	
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
				  $rs5 = mysqli_query($link,$Consulta);
				  $Fil5 = mysqli_fetch_array($rs5);						
				  $AcumRaf3 = $AcumRaf3 + $Fil5["peso"];

				  //Otros Destinos
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
				  $Consulta = $Consulta." AND cod_subproducto = ".$Fila["cod_subproducto"]." AND tipo_movimiento IN (5,9)";	
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
				  $rs6 = mysqli_query($link,$Consulta);
				  $Fil6 = mysqli_fetch_array($rs6);						
				  $AcumDest3 = $AcumDest3 + $Fil6["peso"];
				  if($Fila["cod_subproducto"] == 4)
				  {
					  $Consulta = "SELECT Fis_Vent,Quim_Vent,Calaf_Vent,Ana_Vent FROM sea_web.inf_rechazos WHERE Fecha = '$Fecha_B'";
					  $res = mysqli_query($link,$Consulta);
					  $row = mysqli_fetch_array($res);
					  if($row["Fis_Vent"] != '')
						  $peso_fisico = $row["Fis_Vent"]*1000; 
					  if($row["Quim_Vent"] != '')
						  $peso_quimico = $row["Quim_Vent"]*1000;
					  if($row["Calaf_Vent"] != '')
						  $peso_calafateo = $row["Calaf_Vent"]*1000;
					  if($row["Ana_Vent"] != '')
						  $peso_analisis = $row["Ana_Vent"]*1000;
				  }	
				  if($Fila["cod_subproducto"] == 8)
				  {
					  $Consulta = "SELECT Fis_HMadres,Quim_HMadres,Calaf_HMadres,Ana_HMadres FROM sea_web.inf_rechazos WHERE fecha = '$Fecha_B'";
					  $res = mysqli_query($link,$Consulta);
					  $row = mysqli_fetch_array($res);
					  if($row["Fis_HMadres"] != '')
						   $peso_fisico = $row["Fis_HMadres"]*1000;
					  if($row["Quim_HMadres"] != '')
						  $peso_quimico = $row["Quim_HMadres"]*1000;
					  if($row["Calaf_HMadres"] != '')
						  $peso_calafateo = $row["Calaf_HMadres"]*1000;
					  if($row["Ana_HMadres"] != '')
						  $peso_analisis = $row["Ana_HMadres"]*1000;
				  }	
				  if($Fila["cod_subproducto"] == 1)
				  {
					  $Consulta = "SELECT Fis_FHVL,Quim_FHVL,Calaf_FHVL,Ana_FHVL FROM sea_web.inf_rechazos WHERE fecha = '$Fecha_B'";
					  $res = mysqli_query($link,$Consulta);
					  $row = mysqli_fetch_array($res);
					  if($row["Fis_FHVL"] != '')
						   $peso_fisico = $row["Fis_FHVL"]*1000;
					  if($row["Quim_FHVL"] != '')
						   $peso_quimico = $row["Quim_FHVL"]*1000;
					  if($row["Calaf_FHVL"] != '')
						   $peso_calafateo = $row["Calaf_FHVL"]*1000;
					  if($row["Ana_FHVL"] != '')
						   $peso_analisis = $row["Ana_FHVL"]*1000;
				  }	
				  if($Fila["cod_subproducto"] == 2)
				  {
					  $Consulta = "SELECT Fis_Teniente,Quim_Teniente,Calaf_Teniente,Ana_Teniente FROM sea_web.inf_rechazos WHERE fecha = '$Fecha_B'";
					  $res = mysqli_query($link,$Consulta);
					  $row = mysqli_fetch_array($res);
					  if($row["Fis_Teniente"] != '')
						   $peso_fisico = $row["Fis_Teniente"]*1000;
					  if($row["Quim_Teniente"] != '')
						   $peso_quimico = $row["Quim_Teniente"]*1000;
					  if($row["Calaf_Teniente"] != '')
						   $peso_calafateo = $row["Calaf_Teniente"]*1000;
					  if($row["Ana_Teniente"] != '')
						   $peso_analisis = $row["Ana_Teniente"]*1000;
				  }	
				  if($Fila["cod_subproducto"] == 3)
				  {
					  $Consulta = "SELECT Fis_Disputada,Quim_Disputada,Calaf_Disputada,Ana_Disputada FROM sea_web.inf_rechazos WHERE fecha = '$Fecha_B'";
					  $res = mysqli_query($link,$Consulta);
					  $row = mysqli_fetch_array($res);
					  if($row["Fis_Disputada"] != '')
						   $peso_fisico = $row["Fis_Disputada"]*1000;;
					  if($row["Quim_Disputada"] != '')
						   $peso_quimico = $row["Quim_Disputada"]*1000;
					  if($row["Calaf_Disputada"] != '')
						   $peso_calafateo = $row["Calaf_Disputada"]*1000;
					  if($row["Ana_Disputada"] != '')
						   $peso_analisis = $row["Ana_Disputada"]*1000;
				  }				
	              if ($Fila["cod_subproducto"]==13)
                  {
					  $Consulta = "SELECT Fis_Expo,Quim_Expo,Calaf_Expo,Ana_Expo FROM sea_web.inf_rechazos WHERE fecha = '$Fecha_B'";
					  $res = mysqli_query($link,$Consulta);
					  $row = mysqli_fetch_array($res);
					  if($row["Fis_Expo"] != '')
						   $peso_fisico = $row["Fis_Expo"]*1000;;
					  if($row["Quim_Expo"] != '')
						   $peso_quimico = $row["Quim_Expo"]*1000;
					  if($row["Calaf_Expo"] != '')
						   $peso_calafateo = $row["Calaf_Expo"]*1000;
					  if($row["Ana_Expo"] != '')
						   $peso_analisis = $row["Ana_Expo"]*1000;

                  }
				  $AcumFisi = $AcumFisi + $peso_fisico;
				  $AcumQuim = $AcumQuim + $peso_quimico;
				  $AcumCalaf = $AcumCalaf + $peso_calafateo;
				  $AcumAna = $AcumAna + $peso_analisis;
				  
				    
	
				  $ExFinal3 = $AcumIni3 + $AcumRecep3 - $AcumNave3 - $AcumRaf3 - $AcumDest3;
				  $AcumFinal3 = $AcumFinal3 + $ExFinal3;              
				  $Aprobados = $ExFinal3 - $peso_fisico - $peso_calafateo - $peso_quimico - $peso_analisis;
				  $AcumAprob = $AcumAprob + $Aprobados;
				  $Total = $peso_fisico + $peso_calafateo + $peso_quimico + $peso_analisis;					  
				  $AcumTotal = $AcumTotal + $Total;	
				  echo'<td align="right">'.number_format($Aprobados/1000,0,"",".").'&nbsp;</td>';				  
				  echo'<td align="right">'.number_format($peso_analisis/1000,0,"",".").'&nbsp;</td>';
				  echo'<td align="right">'.number_format($peso_calafateo/1000,0,"",".").'&nbsp;</td>';
				  echo'<td align="right">'.number_format($peso_fisico/1000,0,"",".").'&nbsp;</td>';
				  echo'<td align="right">'.number_format($peso_quimico/1000,0,"",".").'&nbsp;</td>';
				  echo'<td align="right">'.number_format($Total/1000,0,"",".").'&nbsp;</td>';
				  echo'<td align="right">'.number_format($AcumEmbResto/1000,0,"",".").'&nbsp;</td>';
				 // echo'<td>&nbsp;</td>';
				  echo'<td align="right">'.number_format($ExFinal3/1000,0,"",".").'&nbsp;</td>';				  
				  $ExFinal3 = 0;			  
				echo'</tr>';
			}
		
		}
		else
		{				
			$Consulta = "SELECT distinct cod_subproducto FROM sea_web.movimientos WHERE cod_producto = 17 ";
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			//echo $Consulta;
			$resp = mysqli_query($link,$Consulta);
			while($Fila = mysqli_fetch_array($resp))
			{
	
				 $ExFinal3 = 0;
				 $AcumIni3 = 0;
				 $AcumRecep3 = 0;
				 $AcumNave3 = 0;
				 $AcumRaf3 = 0;
				 $AcumRech3 = 0;
				 $AcumDest3 = 0;
				 $total = 0;
				  //Abreviatura
				  $Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto WHERE cod_producto = 17";
				  $Consulta = $Consulta." AND cod_subproducto = ".$Fila["cod_subproducto"]." ";	
				  $result = mysqli_query($link,$Consulta);
				  $Fil = mysqli_fetch_array($result);	
				  echo'<td>'.$Fil["abreviatura"].'&nbsp;</td>';
	
				 //STOCK INICIAL
				  $Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
				  $Consulta.= " FROM sea_web.stock ";
				  $Consulta.= " WHERE cod_producto = 17";
				  $Consulta.= " AND cod_subproducto = '".$Fila["cod_subproducto"]."'";
				  $Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH))";
				  $Consulta.= " GROUP BY cod_producto, cod_subproducto";
				  //echo "2".$Consulta;
				  $rs2 = mysqli_query($link,$Consulta);
				  $Fil2 = mysqli_fetch_array($rs2);
				  $AcumIni3 = $AcumIni3 + $Fil2["peso"];			  
				  //Recep 	
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17 ";
				  if ($Fila["cod_subproducto"]==4 || $Fila["cod_subproducto"]==8)
				  { 
				  	$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento IN (1,44)";	
				  }
				  else
				  { 
				  	$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento = 1 ";	
				  }				  
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
				  $rs3 = mysqli_query($link,$Consulta);
				  $Fil3 = mysqli_fetch_array($rs3);						
				  $AcumRecep3 = $AcumRecep3 + $Fil3["peso"];
				  //Nave	
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17 ";
				  $Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento = 2";	
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
				  $rs4 = mysqli_query($link,$Consulta);
				  $Fil4 = mysqli_fetch_array($rs4);						
				  $AcumNave3 = $AcumNave3 + $Fil4[peso];
	
				  //Trasp Raf
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
				  $Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento = 4";	
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
				  $rs5 = mysqli_query($link,$Consulta);
				  $Fil5 = mysqli_fetch_array($rs5);						
				  $AcumRaf3 = $AcumRaf3 + $Fil5["peso"];
	
				  //Otros Destinos
				  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
				  $Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento IN (5,9)";	
				  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			      $rs6 = mysqli_query($link,$Consulta);
				  $Fil6 = mysqli_fetch_array($rs6);						
				  $AcumDest3 = $AcumDest3 + $Fil6["peso"];

				  $Consulta = "SELECT sum(recuperables) as calaf FROM sea_web.rechazos";
				  $Consulta.= " WHERE cod_producto=17 AND cod_subproducto='".$Fila["cod_subproducto"]."' "; 
				  $Consulta.= " AND cod_tipo=6 AND cod_defecto<>0"; 
				  $Consulta.= " AND cod_defecto=15"; 
				  $Consulta.= " AND fecha_ini >= '$Fecha_Ini' AND fecha_ter <= '$Fecha_Ter'";
				  $res = mysqli_query($link,$Consulta);
				  if($row = mysqli_fetch_array($res))
				  {
					   $Consulta = "SELECT (peso_unidades/unidades) as prom from sea_web.hornadas";
					   $Consulta.= " WHERE cod_producto=17";
					   $Consulta.= " AND cod_subproducto='".$Fila["cod_subproducto"]."' group by hornada_ventana";
					   $res = mysqli_query($link,$Consulta);				   
					   $fila = mysqli_fetch_array($res);
					   $prom = $fila["prom"];
					   $peso_calaf = $row["calaf"] * $prom;	
				  }
				  $AcumCalaf = $AcumCalaf + $peso_calaf;
	
				  //Fisico	
				  $Consulta = "SELECT sum(rechazados) as rech FROM sea_web.rechazos";
				  $Consulta.= " WHERE cod_producto=17 AND cod_subproducto=$Fila[cod_subproducto]"; 
				  $Consulta.= " AND cod_tipo=6 AND cod_defecto<>0"; 
				  $Consulta.= " AND cod_defecto <> 15"; 
				  $Consulta.= " AND fecha_ini >= '$Fecha_Ini' AND fecha_ter <= '$Fecha_Ter'";
				  $res = mysqli_query($link,$Consulta);
				  if($row = mysqli_fetch_array($res))
				  {
					   $Consulta = "SELECT (peso_unidades/unidades) as prom from sea_web.hornadas";
					   $Consulta.= " WHERE cod_producto=17";
					   $Consulta.= " AND cod_subproducto='".$Fila["cod_subproducto"]."' group by hornada_ventana";
					   $res = mysqli_query($link,$Consulta);				   
					   $fila = mysqli_fetch_array($res);
					   $prom = $fila["prom"];
					   $peso_fisico = $row["rech"] * $prom;	
				  }
				  $AcumFisi = $AcumFisi + $peso_fisico;
				  
				  //Quimico	
				  $Consulta = "SELECT sum(peso) as peso, hornada FROM sea_web.movimientos WHERE cod_producto = 17";
				  if ($Fila["cod_subproducto"]==4 || $Fila["cod_subproducto"]==8)
				  {
				  	$Consulta.= " AND tipo_movimiento IN (1,44) AND cod_subproducto = ".$Fila["cod_subproducto"];
				  }
				  else
				  {
				  	$Consulta.= " and tipo_movimiento = 1 and cod_subproducto = ".$Fila["cod_subproducto"];
				  }
				  $Consulta.= " AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
				  $Consulta.= " GROUP BY hornada";
				  $rs = mysqli_query($link,$Consulta);
				  $peso_quimico = 0;
				  while($row = mysqli_fetch_array($rs))
				  {
					 $Consulta = "SELECT valor from sea_web.leyes_por_hornada where cod_producto = 17";
					 $Consulta.= " AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND hornada = '".$row["hornada"]."' ";
					 $Consulta.= " AND cod_unidad = 2 AND cod_leyes = '09'";					  
					 $result = mysqli_query($link,$Consulta);
					 $fila = mysqli_fetch_array($result);	
					 if($fila["valor"] > 400)
					 {
						$peso_quimico = $peso_quiminco + $row["peso"];	
					 }
		
				  }
				  $AcumQuim = $AcumQuim + $peso_quimico;
													  
				  $ExFinal3 = $AcumIni3 + $AcumRecep3 - $AcumNave3 - $AcumRaf3 - $AcumDest3;
				  $AcumFinal3 = $AcumFinal3 + $ExFinal3;              
				  $Aprobados = $ExFinal3 - $peso_fisico - $peso_calaf;
				  $AcumAprob = $AcumAprob + $Aprobados;
				  
				  $total = $peso_calaf + $peso_fisico + $peso_quimico;
				  $AcumTotal = $AcumTotal + $total;
				  echo'<td align="right">'.number_format($Aprobados/1000,0,"",".").'&nbsp;</td>';				  
				  echo'<td>&nbsp;</td>';
				  echo'<td align="right">'.number_format($peso_calaf/1000,0,"",".").'&nbsp;</td>';
				  echo'<td align="right">'.number_format($peso_fisico/1000,0,"",".").'&nbsp;</td>';
				  echo'<td align="right">'.number_format($peso_quimico/1000,0,"",".").'&nbsp;</td>';
				  echo'<td align="right">'.number_format($total/1000,0,"",".").'&nbsp;</td>';
				  
				 
				  echo'<td>&nbsp;</td>';
				  echo'<td align="right">'.number_format($ExFinal3/1000,0,"",".").'&nbsp;</td>';				  
				  $ExFinal3 = 0;			  
				echo'</tr>';
			}				
		}	
		
	?>				
    <tr class="Detalle01">
	 <td>Total Tons.</td> 	
	 <td align="right"><?php echo number_format($AcumAprob/1000,0,"","."); ?>&nbsp;</td>	
	 <td align="right"><?php echo number_format($AcumAna/1000,0,"","."); ?>&nbsp;</td>	
	 <td align="right"><?php echo number_format($AcumCalaf/1000,0,"","."); ?>&nbsp;</td>	
	 <td align="right"><?php echo number_format($AcumFisi/1000,0,"","."); ?>&nbsp;</td>	
	 <td align="right"><?php echo number_format($AcumQuim/1000,0,"","."); ?>&nbsp;</td>	
	 <td align="right"><?php echo number_format($AcumTotal/1000,0,"","."); ?>&nbsp;</td>	
	  <td align="right"><?php echo number_format($AcumEmbResto/1000,0,"","."); ?>&nbsp;</td>
	 <td align="right"><?php echo number_format($AcumFinal3/1000,0,"","."); ?>&nbsp;</td>	
    </tr>	
    <tr class="Detalle02">
	 <td>Restos</td> 	
   	  <?php 
		//RESTOS
		$Consulta = "SELECT * FROM sea_web.inf_rechazos WHERE fecha = '$Fecha_B'";
		$rs = mysqli_query($link,$Consulta);		
		if($row = mysqli_fetch_array($rs))
		{
			//STOCK INICIAL
			
			$ExFinal5 = 0;
			$AcumIni5 = 0;
			$AcumProd5 = 0;
			$AcumNave5 = 0;
			$AcumRaf5 = 0;
			$AcumEmb1 = 0;
			$Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
			$Consulta.= " FROM sea_web.stock ";
			$Consulta.= " WHERE cod_producto = 19";
			$Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH))";
			$Consulta.= " GROUP BY cod_producto, cod_subproducto";
			//echo "uno".$Consulta;
			$rs2 = mysqli_query($link,$Consulta);
			while($Fil2 = mysqli_fetch_array($rs2))						
			{
				$AcumIni5 = $AcumIni5 + $Fil2["peso"];
			}
			//Prod.	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
			$Consulta = $Consulta." AND tipo_movimiento = 3";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs3 = mysqli_query($link,$Consulta);
			$Fil3 = mysqli_fetch_array($rs3);						
			$AcumProd5 = $AcumProd5 + $Fil3["peso"];
	
			//Nave	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
			$Consulta = $Consulta." AND tipo_movimiento = 2";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs4 = mysqli_query($link,$Consulta);
			$Fil4 = mysqli_fetch_array($rs4);						
			$AcumNave5 = $AcumNave5 + $Fil4["peso"];
	
			//RAf	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
			$Consulta = $Consulta." AND tipo_movimiento = 4";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs5 = mysqli_query($link,$Consulta);
			$Fil5 = mysqli_fetch_array($rs5);						
			$AcumRaf5 = $AcumRaf5 + $Fil5["peso"];
	
			$Consulta = "SELECT Fis_Restos, Quim_Restos, Calaf_Restos, Ana_Restos FROM sea_web.inf_rechazos WHERE fecha = '$Fecha_B'";
			$res = mysqli_query($link,$Consulta);
			$row = mysqli_fetch_array($res);
		    if($row["Fis_Restos"] != '')
			  $peso_fisico = $row["Fis_Restos"]*1000;;
 		    if($row["Quim_Restos"] != '')
			  $peso_quimico = $row["Quim_Restos"]*1000;
		    if($row["Calaf_Restos"] != '')
			  $peso_calafateo = $row["Calaf_Restos"]*1000;
		    if($row["Ana_Restos"] != '')
			  $peso_analisis = $row["Ana_Restos"]*1000;
		
		//embarque
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
			$Consulta = $Consulta." AND tipo_movimiento = 10";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			$rsresto = mysqli_query($link,$Consulta);
			$Filresto = mysqli_fetch_array($rsresto);						
			$AcumEmb1 = $AcumEmb1 + $Filresto["peso"];

	
	
	
			$ExFinal5 = $AcumIni5 + $AcumProd5 - $AcumNave5 - $AcumRaf5;
			$AprobRestos = $ExFinal5 - $peso_fisico - $peso_quimico - $peso_calafateo - $peso_analisis;
			$peso_total = $peso_fisico + $peso_quimico + $peso_calafateo + $peso_analisis;
			/* echo'<td align="right">'.number_format($AprobRestos/1000,0,"",".").'&nbsp;</td>';	 se cambia a solicitud de Jefe 
			  productos metalurgicos, por intemedio de mail enviado por Alexandra Roco F. 26-08-2008, se solicita que en restos 
			  aprobados figuren los stock reales  */  
			echo'<td align="right">'.number_format(($AprobRestos - $AcumEmb1)/1000,0,"",".").'&nbsp;</td>';				  
			echo'<td align="right">'.number_format($peso_analisis/1000,0,"",".").'&nbsp;</td>';				  
			echo'<td align="right">'.number_format($peso_calafateo/1000,0,"",".").'&nbsp;</td>';				  
			echo'<td align="right">'.number_format($peso_fisico/1000,0,"",".").'&nbsp;</td>';				  
			echo'<td align="right">'.number_format($peso_quimico/1000,0,"",".").'&nbsp;</td>';				  
			echo'<td align="right">'.number_format($peso_total/1000,0,"",".").'&nbsp;</td>';	
			 echo'<td align="right">'.number_format($AcumEmb1/1000,0,"",".").'&nbsp;</td>'; 
			
			echo'<td align="right">'.number_format(($ExFinal5 - $AcumEmb1)/1000,0,"",".").'&nbsp;</td>';				  
		}
		else
		{
		
			$ExFinal5 = 0;
			$AcumIni5 = 0;
			$AcumProd5 = 0;
			$AcumNave5 = 0;
			$AcumRaf5 = 0;
			$Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
			$Consulta.= " FROM sea_web.stock ";
			$Consulta.= " WHERE cod_producto = 19";
			$Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH))";
			$Consulta.= " GROUP BY cod_producto, cod_subproducto";
			$rs2 = mysqli_query($link,$Consulta);
			while($Fil2 = mysqli_fetch_array($rs2))						
			{
				$AcumIni5 = $AcumIni5 + $Fil2["peso"];
			}
			//Prod.	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
			$Consulta = $Consulta." AND tipo_movimiento = 3";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs3 = mysqli_query($link,$Consulta);
			$Fil3 = mysqli_fetch_array($rs3);						
			$AcumProd5 = $AcumProd5 + $Fil3["peso"];
	
			//Nave	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
			$Consulta = $Consulta." AND tipo_movimiento = 2";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs4 = mysqli_query($link,$Consulta);
			$Fil4 = mysqli_fetch_array($rs4);						
			$AcumNave5 = $AcumNave5 + $Fil4["peso"];
	
			//RAf	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 19";
			$Consulta = $Consulta." AND tipo_movimiento = 4";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs5 = mysqli_query($link,$Consulta);
			$Fil5 = mysqli_fetch_array($rs5);						
			$AcumRaf5 = $AcumRaf5 + $Fil5["peso"];
	
			$Consulta = "SELECT Restos FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha_Ter' AND Tipo = 'R'";
			$res = mysqli_query($link,$Consulta);
			$row = mysqli_fetch_array($res);
			$peso_restos = $row["Restos"]*1000;
	
			$ExFinal5 = $AcumIni5 + $AcumProd5 - $AcumNave5 - $AcumRaf5;
			$AprobRestos = $ExFinal5 - $peso_restos;
			echo'<td align="right">'.number_format($AprobRestos/1000,0,"",".").'&nbsp;</td>';				  
			echo'<td>&nbsp;</td>';
			echo'<td>&nbsp;</td>';
			echo'<td align="right">'.number_format($peso_restos/1000,0,"",".").'&nbsp;</td>';		
			
			echo'<td>&nbsp;</td>';

			echo'<td>&nbsp;</td>';
			echo'<td>&nbsp;</td>';
			echo'<td align="right">'.number_format($ExFinal5/1000,0,"",".").'&nbsp;</td>';				  
				
		}
	  ?>		
    </tr>	
  </table> 		
  <br>

  
  <?php

  	/*if ($opcion == 2)
	
	{  
	
		$diar = date("j");
		$mesr = date("n");
		$anor = date("Y");   
		if (strlen($mesr==1))
		{
			$mesr = '0'.$mesr;
		}
		if (strlen($diar==1))
		{
			$diar = '0'.$diar;
		}		
		$FechaTitulo = date("d-m-Y",mktime(7,59,59,$mesr,$diar,$anor));
			//$FechaIni = date("Y-m-d",mktime(7,59,59,$Mes,($Dia - 1),$Ano));	//Fecha para recepciones

		$FechaTer2   = date("Y-m-d",mktime(7,59,59,$mesr,$diar,$anor));
		
	}
	else
	{
	    $FechaTitulo = date("d-m-Y",mktime(7,59,59,$Mes,$Dia,$Ano));
		$FechaTer2   = date("Y-m-d",mktime(7,59,59,$Mes,$Dia,$Ano));
		
	}
				
	 ?>
 <? /*poly  
  <table width="561" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><strong>RENOVACION PROYECTADA PARA </strong></td>
	  <td width="264"><strong></strong>&nbsp;&nbsp;<? echo $FechaTitulo; ?></td>

	 
    </tr>
  </table>
  <table width="600" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla01">
	 <td width="71">&nbsp;</td>
	 <td colspan="2" align="center">Turno A</td>
	 <td colspan="2" align="center">Turno B</td>
	 <td colspan="2" align="center">Turno C</td>
	</tr>	
    <tr>
	 <td>Grupos</td>
	 <?

		//$FechaTer = date("Y-m-d",mktime(7,59,59,$Mes,($Dia + 1),$Ano));
		$Consulta = "SELECT * FROM sea_web.renovacion_grupos WHERE fecha = '$FechaTer2'";
		$resp = mysqli_query($Consulta);
		if($fila = mysqli_fetch_array($resp))
		{
		 	$Consulta = "SELECT * FROM sea_web.renovacion_grupos WHERE fecha = '$FechaTer2' AND turno = 'A'";
			$rs = mysqli_query($Consulta);
			$fil = mysqli_fetch_array($rs);
				echo'<td width="63" align="center">'.$fil[grupo1].'&nbsp;</td>';
				echo'<td width="63" align="center">'.$fil[grupo2].'&nbsp;</td>';
				//echo'<td width="63" align="center">'.$fil[grupo3].'&nbsp;</td>';

		 	$Consulta = "SELECT * FROM sea_web.renovacion_grupos WHERE fecha = '$FechaTer2' AND turno = 'B'";
			$rs = mysqli_query($Consulta);
			$fil = mysqli_fetch_array($rs);
				echo'<td width="63" align="center">'.$fil[grupo1].'&nbsp;</td>';
				echo'<td width="63" align="center">'.$fil[grupo2].'&nbsp;</td>';
				//echo'<td width="63" align="center">'.$fil[grupo3].'&nbsp;</td>';

		 	$Consulta = "SELECT * FROM sea_web.renovacion_grupos WHERE fecha = '$FechaTer2' AND turno = 'C'";
			$rs = mysqli_query($Consulta);
			$fil = mysqli_fetch_array($rs);
				echo'<td width="63" align="center">'.$fil[grupo1].'&nbsp;</td>';
				echo'<td width="63" align="center">'.$fil[grupo2].'&nbsp;</td>';
				//echo'<td width="63" align="center">'.$fil[grupo3].'&nbsp;</td>';
		}
		else
		{
			$Dia_R = $Dia + 1;
			//$FechaTer = date("Y-m-d",mktime(7,59,59,$Mes,($Dia + 1),$Ano));		
			$Dia_R = substr($FechaTer2,8,2);
			$Fecha_In = substr($FechaTer2,0,7).'-01';
			$Consulta = "SELECT t1.cod_grupo, t2.cod_subproducto FROM sec_web.renovacion_prog_prod as t1";
			$Consulta = $Consulta." INNER JOIN sea_web.movimientos as t2"; 
			$Consulta = $Consulta." ON (t2.campo2 * 1) = (t1.cod_grupo * 1)"; 
			$Consulta = $Consulta." WHERE t1.cod_concepto = 'A' and t1.dia_renovacion = '$Dia_R'";
			$Consulta = $Consulta." and t1.fecha_renovacion = '$Fecha_In' and t2.fecha_movimiento = '$FechaTer2'";
			$Consulta = $Consulta." and t2.tipo_movimiento = 2 and t2.cod_subproducto != 8 group by t1.cod_grupo";		
			$rs = mysqli_query($Consulta);
			while($Fila = mysqli_fetch_array($rs))
			{		
				echo'<td width="63" align="center">'.$Fila[cod_grupo].'&nbsp;</td>';
			}
	
			$Consulta = "SELECT t1.cod_grupo, t2.cod_subproducto FROM sec_web.renovacion_prog_prod as t1";
			$Consulta = $Consulta." INNER JOIN sea_web.movimientos as t2"; 
			$Consulta = $Consulta." ON (t2.campo2 * 1) = (t1.cod_grupo * 1)"; 
			$Consulta = $Consulta." WHERE t1.cod_concepto = 'B' and t1.dia_renovacion = '$Dia_R'";
			$Consulta = $Consulta." and t1.fecha_renovacion = '$Fecha_In' and t2.fecha_movimiento = '$FechaTer2'";
			$Consulta = $Consulta." and t2.tipo_movimiento = 2 and t2.cod_subproducto != 8 group by t1.cod_grupo";		
			$rs = mysqli_query($Consulta);
			while($Fila = mysqli_fetch_array($rs))
			{		
				echo'<td width="63" align="center">'.$Fila[cod_grupo].'&nbsp;</td>';
			}
			$Consulta = "SELECT t1.cod_grupo, t2.cod_subproducto FROM sec_web.renovacion_prog_prod as t1";
			$Consulta = $Consulta." INNER JOIN sea_web.movimientos as t2"; 
			$Consulta = $Consulta." ON (t2.campo2 * 1) = (t1.cod_grupo * 1)"; 
			$Consulta = $Consulta." WHERE t1.cod_concepto = 'C' and t1.dia_renovacion = '$Dia_R'";
			$Consulta = $Consulta." and t1.fecha_renovacion = '$Fecha_In' and t2.fecha_movimiento = '$FechaTer2'";
			$Consulta = $Consulta." and t2.tipo_movimiento = 2 and t2.cod_subproducto != 8 group by t1.cod_grupo";		
			//echo $Consulta;
			$rs = mysqli_query($Consulta);
			while($Fila = mysqli_fetch_array($rs))
			{		
				echo'<td width="63" align="center">'.$Fila[cod_grupo].'&nbsp;</td>';
			}
		}
	 ?>
	</tr>	
    <tr>
	 <td>Tipo Anodos</td>
	 <?php
	 	$Consulta = "SELECT * FROM sea_web.renovacion_grupos WHERE fecha = '$FechaTer2'";
		$resp = mysqli_query($Consulta);
		if($fila = mysqli_fetch_array($resp))
		{
		 	$Consulta = "SELECT * FROM sea_web.renovacion_grupos WHERE fecha = '$FechaTer2' AND turno = 'A'";
	//$Consulta = "SELECT * FROM sea_web.inf_rechazos WHERE fecha = '$Fecha_B'"; 
			$rs = mysqli_query($Consulta);
			$fil = mysqli_fetch_array($rs);
				echo'<td width="63" align="center">'.$fil[producto1].'&nbsp;</td>';
				echo'<td width="63" align="center">'.$fil[producto2].'&nbsp;</td>';
				//echo'<td width="63" align="center">'.$fil[producto3].'&nbsp;</td>';

		 	$Consulta = "SELECT * FROM sea_web.renovacion_grupos WHERE fecha = '$FechaTer2' AND turno = 'B'";
			$rs = mysqli_query($Consulta);
			$fil = mysqli_fetch_array($rs);
				echo'<td width="63" align="center">'.$fil[producto1].'&nbsp;</td>';
				echo'<td width="63" align="center">'.$fil[producto2].'&nbsp;</td>';
				//echo'<td width="63" align="center">'.$fil[producto3].'&nbsp;</td>';
		 	
			$Consulta = "SELECT * FROM sea_web.renovacion_grupos WHERE fecha = '$FechaTer2' AND turno = 'C'";
			$rs = mysqli_query($Consulta);
			$fil = mysqli_fetch_array($rs);
				echo'<td width="63" align="center">'.$fil[producto1].'&nbsp;</td>';
				echo'<td width="63" align="center">'.$fil[producto2].'&nbsp;</td>';
				//echo'<td width="63" align="center">'.$fil[producto3].'&nbsp;</td>';

		}
		else
		{
	
			$Consulta = "SELECT t1.cod_grupo, t2.cod_subproducto FROM sec_web.renovacion_prog_prod as t1";
			$Consulta = $Consulta." INNER JOIN sea_web.movimientos as t2"; 
			$Consulta = $Consulta." ON (t2.campo2 * 1) = (t1.cod_grupo * 1)"; 
			$Consulta = $Consulta." WHERE t1.cod_concepto = 'A' and t1.dia_renovacion = '$Dia_R'";
			$Consulta = $Consulta." and t1.fecha_renovacion = '$Fecha_In' and t2.fecha_movimiento = '$FechaTer2'";
			$Consulta = $Consulta." and t2.tipo_movimiento = 2 and t2.cod_subproducto != 8 group by t1.cod_grupo";		
			$rs = mysqli_query($Consulta);
			while($Fila = mysqli_fetch_array($rs))
			{		
				if($Fila[cod_subproducto] == 1)
					$Producto = HVL;
				if($Fila[cod_subproducto] == 2)
					$Producto = TTE;
				if($Fila[cod_subproducto] == 3)
					$Producto =DISP;
				if($Fila[cod_subproducto] == 4)
					$Producto = VENT;
					
				echo'<td width="63" align="center">'.$Producto.'&nbsp;</td>';
			}
	
			$Consulta = "SELECT t1.cod_grupo, t2.cod_subproducto FROM sec_web.renovacion_prog_prod as t1";
			$Consulta = $Consulta." INNER JOIN sea_web.movimientos as t2"; 
			$Consulta = $Consulta." ON (t2.campo2 * 1) = (t1.cod_grupo * 1)"; 
			$Consulta = $Consulta." WHERE t1.cod_concepto = 'B' and t1.dia_renovacion = '$Dia_R'";
			$Consulta = $Consulta." and t1.fecha_renovacion = '$Fecha_In' and t2.fecha_movimiento = '$FechaTer2'";
			$Consulta = $Consulta." and t2.tipo_movimiento = 2 and t2.cod_subproducto != 8 group by t1.cod_grupo";		
			$rs = mysqli_query($Consulta);
			while($Fila = mysqli_fetch_array($rs))
			{		
				if($Fila[cod_subproducto] == 1)
					$Producto = HVL;
				if($Fila[cod_subproducto] == 2)
					$Producto = TTE;
				if($Fila[cod_subproducto] == 3)
					$Producto = DISP;
				if($Fila[cod_subproducto] == 4)
					$Producto = VENT;
					
				echo'<td width="63" align="center">'.$Producto.'&nbsp;</td>';
			}
			$Consulta = "SELECT t1.cod_grupo, t2.cod_subproducto FROM sec_web.renovacion_prog_prod as t1";
			$Consulta = $Consulta." INNER JOIN sea_web.movimientos as t2"; 
			$Consulta = $Consulta." ON (t2.campo2 * 1) = (t1.cod_grupo * 1)"; 
			$Consulta = $Consulta." WHERE t1.cod_concepto = 'C' and t1.dia_renovacion = '$Dia_R'";
			$Consulta = $Consulta." and t1.fecha_renovacion = '$Fecha_In' and t2.fecha_movimiento = '$FechaTer2'";
			$Consulta = $Consulta." and t2.tipo_movimiento = 2 and t2.cod_subproducto != 8 group by t1.cod_grupo";		
			$rs = mysqli_query($Consulta);
			while($Fila = mysqli_fetch_array($rs))
			{		
				if($Fila[cod_subproducto] == 1)
					$Producto = HVL;
				if($Fila[cod_subproducto] == 2)
					$Producto = TTE;
				if($Fila[cod_subproducto] == 3)
					$Producto = DISP;
				if($Fila[cod_subproducto] == 4)
					$Producto = VENT;
					
				echo'<td width="63" align="center">'.$Producto.'&nbsp;</td>';
			}

		}
	 ?>
	</tr>	
  </table> 	
  <br>
    <table width="561" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><strong>RECEP. MOLDEOS PROYECT. PARA </strong></td>
	  <td width="264"><strong></strong>&nbsp;&nbsp;<? echo $FechaTitulo; ?></td>

	 
    </tr>
  </table>
  
 
  <table width="814" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr>
	 <td width="54" rowspan="2" class="ColorTabla01">&nbsp;</td>
	 <td colspan="2" align="center" class="ColorTabla01">Turno A</td>
	 <td colspan="2" align="center" class="ColorTabla01">Turno B</td>
	 <td colspan="2" align="center" class="ColorTabla01">Turno C</td>
	 <td width="24" rowspan="5" align="center">&nbsp;</td>
	 <td width="397" align="center" class="ColorTabla01">Observaciones</td>
	</tr>	
    <tr>
	 <td width="54" align="center" class="Detalle01">Hornada</td>
	 <td width="55" align="center" class="Detalle01">TM/PROY</td>
	 <td width="49" align="center" class="Detalle01">Hornada</td>
	 <td width="55" align="center" class="Detalle01">TM/PROY</td>
	 <td width="48" align="center" class="Detalle01">Hornada</td>
	 <td width="57" align="center" class="Detalle01">TM/PROY</td>
	 <?
		//$Fecha_Ter = $Ano.'-'.$Mes.'-'.($Dia + 1);	  
		$Fecha_Ter = $Ano.'-'.$Mes.'-'.$Dia;
		
 		$Consulta = "SELECT observacion FROM raf_web.proyeccion_moldeo WHERE fecha = '$FechaTer2' AND observacion != ''";
		$rs4 = mysqli_query($Consulta);
		$row4 = mysqli_fetch_array($rs4);
	 ?>	 
	 <td rowspan="4">&nbsp;<? echo nl2br($row4[observacion]);?></td>
	</tr>	
    <tr>
	  <td>Reverb 1</td>
	  <?php
		$Consulta = "SELECT * FROM raf_web.proyeccion_moldeo WHERE fecha = '$FechaTer2' AND turno = 'A'";
		$rs1 = mysqli_query($Consulta);
		$row1 = mysqli_fetch_array($rs1);				

		$Consulta = "SELECT * FROM raf_web.proyeccion_moldeo WHERE fecha = '$FechaTer2' AND turno = 'B'";
		$rs2 = mysqli_query($Consulta);
		$row2 = mysqli_fetch_array($rs2);				

		$Consulta = "SELECT * FROM raf_web.proyeccion_moldeo WHERE fecha = '$FechaTer2' AND turno = 'C'";
		$rs3 = mysqli_query($Consulta);
		$row3 = mysqli_fetch_array($rs3);				
		//$Fecha_Ter = $Ano.'-'.$Mes.'-'.$Dia;		
		$Fecha_Ter = date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano));	  
	  ?> 	
	 <td align="center"><? echo $row1[hornada1]; ?>&nbsp;</td>
	 <td align="center"><? echo $row1[ton_proy1]; ?>&nbsp;</td>
	 <td align="center"><? echo $row2[hornada1]; ?>&nbsp;</td>
	 <td align="center"><? echo $row2[ton_proy1]; ?>&nbsp;</td>
	 <td align="center"><? echo $row3[hornada1]; ?>&nbsp;</td>
	 <td align="center"><? echo $row3[ton_proy1]; ?>&nbsp;</td>
	</tr>	
    <tr>
	 <td>Reverb 2</td>
	 <td align="center"><? echo $row1[hornada2]; ?>&nbsp;</td>
	 <td align="center"><? echo $row1[ton_proy2]; ?>&nbsp;</td>
	 <td align="center"><? echo $row2[hornada2]; ?>&nbsp;</td>
	 <td align="center"><? echo $row2[ton_proy2]; ?>&nbsp;</td>
	 <td align="center"><? echo $row3[hornada2]; ?>&nbsp;</td>
	 <td align="center"><? echo $row3[ton_proy2]; ?>&nbsp;</td>
	</tr>	
    <tr>
	 <td>Bascul.</td>
	 <td align="center"><? echo $row1[hornada3]; ?>&nbsp;</td>
	 <td align="center"><? echo $row1[ton_proy3]; ?>&nbsp;</td>
	 <td align="center"><? echo $row2[hornada3]; ?>&nbsp;</td>
	 <td align="center"><? echo $row2[ton_proy3]; ?>&nbsp;</td>
	 <td align="center"><? echo $row3[hornada3]; ?>&nbsp;</td>
	 <td align="center"><? echo $row3[ton_proy3]; ?>&nbsp;</td>
	</tr>	
  </table> 
  <br>
  <table width="400" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><strong>RECEPCION ANODOS EXTERNOS</strong></td>
    </tr>
  </table>
  <table width="550" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla01">
	  <td colspan="3">Anodos Hernan Videla Lira</td>
	  <td colspan="2">Anodos Teniente</td>
	  <td colspan="2">Anodos Anglo American SA</td>
	</tr>
	<tr class="Detalle01">
	  <td width="67" align="center">Fecha</td> 
	  <td width="98" align="center">N� Camiones</td> 
	  <td width="60" align="center">TMS</td> 
	  <td width="94" align="center">N� Camiones</td> 
	  <td width="54" align="center">TMS</td> 
	  <td width="105" align="center">N� Camiones</td> 
	  <td width="55" align="center">TMS</td> 
	</tr>
	<?php  //RECEPCION ANODOS EXTERNOS
		$Consulta = "SELECT distinct FECHA AS FECHA_A FROM sipa_web.recepciones WHERE cod_producto='1' and cod_subproducto = 17 ";
		$Consulta = $Consulta." AND FECHA BETWEEN '$FechaIni' AND '$Fecha_Ter2'";
		$Consulta = $Consulta." ORDER BY FECHA";
		//echo "uno".$Consulta."<br>";
		$resp = mysqli_query($Consulta);
		while($Fila = mysqli_fetch_array($resp))
		{	
			$FechaTerm2=date("Y-m-d", mktime(1,0,0,substr($Fila[FECHA_A],5,2),(substr($Fila[FECHA_A],8,2) +1),substr($Fila[FECHA_A],0,4)));
			$FechaHoraIni=$Fila[FECHA_A].' 08:00:00';
			$FechaHoraFin=date("Y-m-d", mktime(1,0,0,substr($Fila[FECHA_A],5,2),(substr($Fila[FECHA_A],8,2) +1),substr($Fila[FECHA_A],0,4)))." 07:59:59";

			echo'<tr>';
              //HVL			
			  echo'<td align="center">'.$Fila[FECHA_A].'</td>';
			  $Consulta = "SELECT count(*) as cont FROM sipa_web.recepciones WHERE FECHA = '$Fila[FECHA_A]'";
			  $Consulta = $Consulta." AND RUT_PRV = '1100-2' AND COD_SUBPRODUCTO = '17'";
			  //echo "dos".$Consulta;
			  $rs = mysqli_query($Consulta);
			  $Fil = mysqli_fetch_array($rs);			  
			  echo'<td align="center">'.$Fil[cont].'&nbsp;</td>';

			  $Consulta = "SELECT sum(peso) as peso FROM sea_web.movimientos WHERE fecha_movimiento between '$Fila[FECHA_A]' AND '$FechaTerm2' and hora between '$FechaHoraIni' and '$FechaHoraFin'";
			  $Consulta = $Consulta." AND tipo_movimiento = 1";
			  $Consulta = $Consulta." AND cod_producto = 17 AND cod_subproducto = 1";
			  //echo "tres".$Consulta;
			  $rs = mysqli_query($Consulta);
			  $Fil = mysqli_fetch_array($rs);			  
			  echo'<td align="right">'.number_format($Fil[peso]/1000,0,"","").'&nbsp;</td>'; 
			  
			  //TTE
			  $Consulta = "SELECT count(*) as cont FROM SIPA_WEB.recepciones WHERE FECHA = '$Fila[FECHA_A]'";
			  $Consulta = $Consulta." AND RUT_PRV = '61704005-0' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17'";
			  //echo "cuatro".$Consulta;
			  $rs2 = mysqli_query($Consulta);
			  $Fil2 = mysqli_fetch_array($rs2);			  
			  echo'<td align="center">'.$Fil2[cont].'&nbsp;</td>';

			  $Consulta = "SELECT sum(peso) as peso FROM sea_web.movimientos WHERE fecha_movimiento between '$Fila[FECHA_A]' AND '$FechaTerm2' and hora between '$FechaHoraIni' and '$FechaHoraFin'";
			  $Consulta = $Consulta." AND tipo_movimiento = 1";
			  $Consulta = $Consulta." AND cod_producto = 17 AND cod_subproducto = 2";
			  //echo "cinco".$Consulta;
			  $rs2 = mysqli_query($Consulta);
			  $Fil2 = mysqli_fetch_array($rs2);			  
			  echo'<td align="right">'.number_format($Fil2[peso]/1000,0,"","").'&nbsp;</td>'; 

			  //DISP.
			  $Consulta = "SELECT count(*) as cont, sum(PESO_NETO) as peso FROM SIPA_WEB.recepciones ";
			  $Consulta.= " WHERE FECHA = '$Fila[FECHA_A]'";
			  $Consulta = $Consulta." AND RUT_PRV = '77762940-9' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '17'";
			  //echo "seis".$Consulta;
			  $rs3 = mysqli_query($Consulta);
			  $Fil3 = mysqli_fetch_array($rs3);			
			  
			  echo'<td align="center">'.$Fil3[cont].'&nbsp;</td>';

			  $Consulta = "SELECT sum(peso) as peso FROM sea_web.movimientos WHERE fecha_movimiento between '$Fila[FECHA_A]' AND '$FechaTerm2' and hora between '$FechaHoraIni' and '$FechaHoraFin'";
			  $Consulta = $Consulta." AND tipo_movimiento = 1";
			  $Consulta = $Consulta." AND cod_producto = 17 AND cod_subproducto = 3";
			  //echo "siete".$Consulta;
			  $rs3 = mysqli_query($Consulta);
			  $Fil3 = mysqli_fetch_array($rs3);			  
			  echo'<td align="right">'.number_format($Fil3[peso]/1000,0,"","").'&nbsp;</td>'; 


			echo'</tr>';
		}			
    ?>
  </table>	
  <br>
  <table width="400" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><strong>RECEPCION BLISTER EXTERNOS</strong></td>
    </tr>
  </table>
  <table width="550" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla01">
	  <td colspan="3">Blister Scrap Potrerillos</td>
	  <td colspan="2">Codelco Teniente</td>
    </tr>
	<tr class="Detalle01">
	  <td align="center">Fecha</td>	
	  <td align="center">N� Camiones</td>	
	  <td align="center">TMS</td>	
	  <td align="center">N� Camiones</td>	
	  <td align="center">TMS</td>	
	</tr>
	<?  //RECEPCION BLISTER EXTERNOS 
		$Consulta = "SELECT distinct FECHA AS FECHA_A FROM SIPA_WEB.recepciones WHERE COD_PRODUCTO='1' AND COD_SUBPRODUCTO = 16 ";
		$Consulta = $Consulta." AND FECHA BETWEEN '$FechaIni' AND '$Fecha_Ter'";
		$Consulta = $Consulta." AND RUT_PRV IN('61704000-K','61704005-0') ORDER BY FECHA";
		$resp = mysqli_query($Consulta);
		while($Fila = mysqli_fetch_array($resp))
		{	
			echo'<tr>';
              //POTRERILLOS			
			  echo'<td align="center">'.$Fila[FECHA_A].'</td>';
			  $Consulta = "SELECT count(*) as cont, sum(PESO_NETO) as peso FROM SIPA_WEB.recepciones WHERE FECHA = '$Fila[FECHA_A]'";
			  $Consulta = $Consulta." AND RUT_PRV = '61704000-K' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '16'";
			  $rs = mysqli_query($Consulta);
			  $Fil = mysqli_fetch_array($rs);			  
			  echo'<td align="center">'.$Fil[cont].'&nbsp;</td>';
			  echo'<td align="right">'.number_format($Fil[peso]/1000,0,"","").'&nbsp;</td>'; 
			  
			  //CODEL.TTE
			  $Consulta = "SELECT count(*) as cont, sum(PESO_NETO) as peso FROM SIPA_WEB.recepciones WHERE FECHA = '$Fila[FECHA_A]'";
			  $Consulta = $Consulta." AND RUT_PRV = '61704005-0' AND COD_PRODUCTO='1' AND COD_SUBPRODUCTO = '16'";
			  $rs2 = mysqli_query($Consulta);
			  $Fil2 = mysqli_fetch_array($rs2);
			  echo'<td align="center">'.$Fil2[cont].'&nbsp;</td>';
			  echo'<td align="right">'.number_format($Fil2[peso]/1000,0,"","").'&nbsp;</td>'; 
	       echo'</tr>';		   
	   }	   
   ?>
  </table> 	
  <br>
  <table width="400" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><strong>MOVIMIENTO BLISTER</strong></td>
    </tr>
  </table>
  <table width="550" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla01">
	  <td width="195">Tipo Blister</td>
	  <td width="57">Exist. Ini</td>
	  <td width="78" align="center">Recep. Mes</td>	
	  <td width="83">Trasp. a Raf</td>
	  <td width="53">Otros</td>
	  <td width="69">Exist. Actual</td>
	</tr>
   	<?  //MOV BLISTER
        $FechaIni = $Ano.'-01-01' ; 
		$AcumIni = 0;
		$AcumRecep = 0;
		$AcumRaf = 0;
		$AcumRaf1 = 0;
		//*******************************************         QUERY ANTERIOR        *************************
		//$Consulta = "SELECT distinct cod_subproducto FROM sea_web.movimientos WHERE cod_producto = 16 ";
		//$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$FechaIni' AND '$Fecha_Ter'";
		//************ NUEVO QUERY, SI FALLA DEBERIAMOS CONSERVAR EL ANTERIOR PERO SIN LA SEGUNDA LINEA ************************
		$Consulta = "SELECT distinct cod_subproducto ";
	    $Consulta.= " FROM sea_web.stock ";
	    $Consulta.= " WHERE cod_producto = 16";
	    $Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ter."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ter."', INTERVAL 1 MONTH))";		
		$resp = mysqli_query($Consulta);
		while($Fila = mysqli_fetch_array($resp))
		{
			echo'<tr>';
		      $ExFinal2 = 0;
			  $AcumIni2 = 0;
			  $AcumRecep2 = 0;
			  $AcumRaf2 = 0;
			  //Abreviatura
			  $Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto WHERE cod_producto = 16";
			  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto]";	
			  $result = mysqli_query($Consulta);
			  $Fil = mysqli_fetch_array($result);	
			  if($Fila[cod_subproducto] == 15)
				  echo'<td>'.$Fil[abreviatura].'&nbsp;(kgs)</td>';
			  else
				  echo'<td>'.$Fil[abreviatura].'&nbsp;(Tons)</td>';
                 
			  //STOCK INICIAL
              $Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
			  $Consulta.= " FROM sea_web.stock ";
			  $Consulta.= " WHERE cod_producto = 16";
			  $Consulta.= " AND cod_subproducto = '".$Fila[cod_subproducto]."'";
			  $Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ter."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ter."', INTERVAL 1 MONTH))";
			  $Consulta.= " GROUP BY cod_producto, cod_subproducto";
			  $rs2 = mysqli_query($Consulta);
			  $Fil2 = mysqli_fetch_array($rs2);
			  if($Fila[cod_subproducto] == 15)
				  echo'<td align="right">'.$Fil2[peso].'&nbsp;</td>';			  
			  else
				  echo'<td align="right">'.number_format($Fil2[peso]/1000,0,"",".").'&nbsp;</td>';
				  
			  $AcumIni = $AcumIni + $Fil2[peso]; 				  
			  $AcumIni2 = $AcumIni2 + $Fil2[peso]; 				  
			  
			  //Recep 	
			  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 16 ";
			  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto] AND tipo_movimiento = 1";	
			  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			  $rs3 = mysqli_query($Consulta);
			  $Fil3 = mysqli_fetch_array($rs3);						

			  if($Fila[cod_subproducto] == 15)
				  echo'<td align="right">'.$Fil3[peso].'&nbsp;</td>';			  
			  else
				  echo'<td align="right">'.number_format($Fil3[peso]/1000,0,"",".").'&nbsp;</td>';
	
			  $AcumRecep = $AcumRecep + $Fil3[peso];
			  $AcumRecep2 = $AcumRecep2 + $Fil3[peso];

			  //Trasp Raf
			  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 16";
			  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto] AND tipo_movimiento = 4";	
			  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaInicio' and '$FechaTermino'";
			  $rs5 = mysqli_query($Consulta);
			  $Fil5 = mysqli_fetch_array($rs5);						

			  if($Fila[cod_subproducto] == 15)
				  echo'<td align="right">'.$Fil5[peso].'&nbsp;</td>';			  
			  else
			  echo'<td align="right">'.number_format($Fil5[peso]/1000,0,"",".").'&nbsp;</td>';

			  $AcumRaf = $AcumRaf + $Fil5[peso];			  
			  $AcumRaf2 = $AcumRaf2 + $Fil5[peso];			  

	          echo'<td>&nbsp;</td>';  
			  $ExFinal2 = $AcumIni2 + $AcumRecep2 - $AcumRaf2;
			  $AcumFinal2 = $AcumFinal2 + $ExFinal2;

			  if($Fila[cod_subproducto] == 15)
				  echo'<td align="right">'.$ExFinal2.'&nbsp;</td>';			  
			  else	
				  echo'<td align="right">'.number_format($ExFinal2/1000,0,"",".").'&nbsp;</td>';				  
	        echo'</tr>';
	   }
	?>    		  
	<tr class="Detalle01">
	   <td>Total Exist.</td>  
       <td align="right"><? echo number_format($AcumIni/1000,0,"","."); ?>&nbsp;</td>
       <td align="right"><? echo number_format($AcumRecep/1000,0,"","."); ?>&nbsp;</td>
       <td align="right"><? echo number_format($AcumRaf/1000,0,"","."); ?>&nbsp;</td>
	   <td>&nbsp;</td>  
       <td align="right"><? echo number_format($AcumFinal2/1000,0,"","."); ?>&nbsp;</td>
	</tr>  
  </table>
  <br>
  <table width="400" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><strong>MOVIMIENTO SUBPRODUCTOS</strong></td>
    </tr>
  </table>
  <table width="550" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla01">
	  <td width="195">Tipo Catodos</td>
	  <td width="57">Exist. Ini</td>
	  <td width="78" align="center">Recep. Mes</td>	
	  <td width="83">Trasp. a Raf</td>
	  <td width="53">Otros</td>
	  <td width="69">Exist. Actual</td>
	</tr>
   	<?  //MOV CATODOS
        $FechaIni = $Ano.'-01-01' ; 
		$FechaStock =date("Y-m-d", mktime(1,0,0,$Mes,$Dia,$Ano));		
		//echo "FECHA:".$FechaStock;
		$AcumFinal2 = 0;
		$AcumIni = 0;
		$AcumRecep = 0;
		$AcumRaf = 0;
		$FechaHi = $Fecha_Ini." 08:00:00";
		$FechaHf = $Fecha_Ter." 07:59:59";
		$Consulta = "SELECT distinct cod_producto,cod_subproducto FROM sea_web.movimientos WHERE cod_producto in (18,48) ";
		$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$FechaIni' AND '$Fecha_Ter'";
		//echo $Consulta."<br>";
		$resp = mysqli_query($Consulta);
		while($Fila = mysqli_fetch_array($resp))
		{
			echo'<tr>';
		      $ExFinal2 = 0;
			  $AcumIni2 = 0;
			  $AcumRecep2 = 0;
			  $AcumRaf2 = 0;
			  //Abreviatura
			  $Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto WHERE cod_producto = $Fila[cod_producto]";
			  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto]";	
			  $result = mysqli_query($Consulta);
			  $Fil = mysqli_fetch_array($result);	
			  echo'<td>'.$Fil[abreviatura].'&nbsp;</td>';
                 
			  //STOCK INICIAL
              $Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
			  $Consulta.= " FROM sea_web.stock ";
			  $Consulta.= " WHERE cod_producto = ".$Fila[cod_producto];
			  $Consulta.= " AND cod_subproducto = '".$Fila[cod_subproducto]."'";
			  //$Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ter."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ter."', INTERVAL 1 MONTH))";
			  $Consulta.= " AND ano = YEAR(SUBDATE('".$FechaStock."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaStock."', INTERVAL 1 MONTH))";
			  $Consulta.= " GROUP BY cod_producto, cod_subproducto";
			  //echo "Con".$Consulta."<BR>";
			  $rs2 = mysqli_query($Consulta);
			  $Fil2 = mysqli_fetch_array($rs2);
			  echo'<td align="right">'.number_format($Fil2[peso]/1000,0,"",".").'&nbsp;</td>';
			  $AcumIni = $AcumIni + $Fil2[peso]; 				  
			  $AcumIni2 = $AcumIni2 + $Fil2[peso]; 				  
			  
			  //Recep 	
			  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = ".$Fila[cod_producto];
			  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto] AND tipo_movimiento = 1";	
			  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaHi' and '$FechaHf'";
				//echo "Con2".$Consulta;
			  
			  $rs3 = mysqli_query($Consulta);
			  $Fil3 = mysqli_fetch_array($rs3);
			  if($Fil3[peso]>1000)						
				  echo'<td align="right">'.number_format($Fil3[peso]/1000,0,"",".").'&nbsp;</td>';
			  else
			  	  echo'<td align="right">'.number_format($Fil3[peso]/1000,2,"",".").'&nbsp;</td>';
			  $AcumRecep = $AcumRecep + $Fil3[peso];
			  $AcumRecep2 = $AcumRecep2 + $Fil3[peso];

			  //Trasp Raf
			  $Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = ".$Fila[cod_producto];
			  $Consulta = $Consulta." AND cod_subproducto = $Fila[cod_subproducto] AND tipo_movimiento = 4";	
			  $Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter' and hora between '$FechaHi' and '$FechaHf'";
			  //echo $Consulta;
			  $rs5 = mysqli_query($Consulta);
			  $Fil5 = mysqli_fetch_array($rs5);						
			  if($Fil5[peso]>1000)
				  echo'<td align="right">'.number_format($Fil5[peso]/1000,0,"",".").'&nbsp;</td>';
			  else
			 	  echo'<td align="right">'.number_format($Fil5[peso]/1000,2,"",".").'&nbsp;</td>';
			  $AcumRaf = $AcumRaf + $Fil5[peso];			  
			  $AcumRaf2 = $AcumRaf2 + $Fil5[peso];			  

	          echo'<td>&nbsp;</td>';  
			  $ExFinal2 = $AcumIni2 + $AcumRecep2 - $AcumRaf2;
			  $AcumFinal2 = $AcumFinal2 + $ExFinal2;

			  echo'<td align="right">'.number_format($ExFinal2/1000,0,"",".").'&nbsp;</td>';				  
	        echo'</tr>';
	   }
	*/
	?>  
	  
  </table>
  <br> 
  
</form>
</body>
</html>
