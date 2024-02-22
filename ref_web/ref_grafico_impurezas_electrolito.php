<?php
  	include("../principal/conectar_ref_web.php");
  	include("phpchartdir.php");
	
	if (strlen($DiaIni)==1)
	   $DiaIni = "0".$DiaIni;
	if (strlen($MesIni)==1)
	   $MesIni = "0".$MesIni;
	if (strlen($DiaFin)==1)
	   $DiaFin = "0".$DiaFin;
	if (strlen($MesFin)==1)
	   $MesFin = "0".$MesFin;

   $FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
   $FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
   	$cont_ley = 1;
   	$consulta = "select * from ref_web.leyes";
	$Respuesta = mysqli_query($link, $consulta);
	 while ($Fila_ley = mysqli_fetch_array($Respuesta))
	 {
	 //	echo "cont".$cont_ley;
		if ($cont_ley == 1)
		{
			$ley1 = $Fila_ley["cod_leyes"];
			//echo "ley1".$ley1;
		}
		if ($cont_ley == 2)
		{
			$ley2 = $Fila_ley["cod_leyes"];
		}
		if ($cont_ley == 3)
		{
			$ley3 = $Fila_ley["cod_leyes"];
		}
			$cont_ley = $cont_ley + 1;
	}		 				 
   
   
   if (($cmbcircuito=='01') or ($cmbcircuito=='02') or ($cmbcircuito=='03') or ($cmbcircuito=='04') or ($cmbcircuito=='05') or ($cmbcircuito=='06'))
      {
	   $cmbcircuito=intval($cmbcircuito);
	  }
		   $Consulta_fecha="select distinct left(t1.fecha_muestra,10) as fecha from cal_web.solicitud_analisis as t1 ";
		   $Consulta_fecha.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario ";
		   $Consulta_fecha.="where t1.id_muestra='".$cmbcircuito."' and t1.cod_producto='41' and t1.cod_subproducto='22' and left(t1.fecha_muestra,10) between '".$FechaInicio."' and '".$FechaTermino."' order by left(t1.fecha_muestra,10) asc";
		   $Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
		   while ($Fila_fecha = mysqli_fetch_array($Respuesta_fecha))
			 {
				$arreglo_fecha[]=$Fila_fecha["fecha"];
				$Consulta="select  left(t1.fecha_muestra,10) as fecha ,t2.valor as valor,t2.candado,t2.cod_unidad,t2.cod_leyes from cal_web.solicitud_analisis as t1 ";
				$Consulta.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario ";
				$Consulta.="where t1.id_muestra='".$cmbcircuito."' and t1.cod_producto='41' and t1.cod_subproducto='22' and t2.cod_leyes='".$ley1."' and left(t1.fecha_muestra,10)='".$Fila_fecha["fecha"]."'";
				//echo $Consulta;
				$Respuesta_res = mysqli_query($link, $Consulta);
				if (!$Fila_res = mysqli_fetch_array($Respuesta_res))
				   {
				    $arreglo_ley1[]=0;
					$unidad_ley1=$Fila_res[cod_unidad];
				   }
				else{
				     $ley=number_format($Fila_res["valor"],"2",".",".");
				     $arreglo_ley1[]=$ley;
					 $unidad_ley1=$Fila_res[cod_unidad];
					}
			    $Consulta="select  left(t1.fecha_muestra,10) as fecha ,t2.valor as valor,t2.candado,t2.cod_unidad,t2.cod_leyes from cal_web.solicitud_analisis as t1 ";
				$Consulta.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario ";
				$Consulta.="where t1.id_muestra='".$cmbcircuito."' and t1.cod_producto='41' and t1.cod_subproducto='22' and t2.cod_leyes='".$ley2."' and left(t1.fecha_muestra,10)='".$Fila_fecha["fecha"]."'";
				$Respuesta_res = mysqli_query($link, $Consulta);
				if (!$Fila_res = mysqli_fetch_array($Respuesta_res))
				   {
				    $arreglo_ley2[]=0;
					$unidad_ley2=$Fila_res[cod_unidad];
				   }
				else{
				     $ley=number_format($Fila_res["valor"],"2",".",".");
				     $arreglo_ley2[]=$ley;
					 $unidad_ley2=$Fila_res[cod_unidad];
					}  
			    $Consulta="select  left(t1.fecha_muestra,10) as fecha ,t2.valor as valor,t2.candado,t2.cod_unidad,t2.cod_leyes from cal_web.solicitud_analisis as t1 ";
				$Consulta.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario ";
				$Consulta.="where t1.id_muestra='".$cmbcircuito."' and t1.cod_producto='41' and t1.cod_subproducto='22' and t2.cod_leyes='".$ley3."' and left(t1.fecha_muestra,10)='".$Fila_fecha["fecha"]."'";
				$Respuesta_res = mysqli_query($link, $Consulta);
				if (!$Fila_res = mysqli_fetch_array($Respuesta_res))
				   {
				    $arreglo_ley3[]=0;
					$unidad_ley3=$Fila_res[cod_unidad];
				   }
				else{
				     $ley=number_format($Fila_res["valor"],"2",".",".");
				     $arreglo_ley3[]=$ley;
					 $unidad_ley3=$Fila_res[cod_unidad];
					}  				  

			 }
    
    $data0 = $arreglo_ley1;
	$data1 = $arreglo_ley2;
	$data2= $arreglo_ley3;
	$labels = $arreglo_fecha;
	
	$c = new XYChart(930, 800);
	
	$c->setBackground(0xffffc0, 0x0, 1);
	
	$c->setPlotArea(50, 50, 830, 500, 0xffffff, -1, -1, 0xc0c0c0, -1);
	
	$legendObj = $c->addLegend(700, 12, false, "", 8);
	$legendObj->setBackground(Transparent);
	

	$titleObj = $c->addTitle("Impurezas Electrolito entre ".$FechaInicio." y ".$FechaTermino." para el circuito ".$cmbcircuito."", "arialbd.ttf",9, 0xffffff);
	$titleObj->setBackground($c->patternColor(array(0x4000, 0x8000), 2));

	
    $c->yAxis->setTitle("mg/l");
    $c->yAxis->setColors(0xc00000, 0xc00000, 0xc00000);
    $c->yAxis->setLinearScale(0, 20, 0.5);
    $yAxis2Obj = $c->yAxis2();
	$yAxis2Obj->setTitle("g/l");
	$yAxis2Obj = $c->yAxis2();
	$yAxis2Obj->setColors(0x8000, 0x8000, 0x8000);
	$c->yAxis2->setLinearScale(0, 200, 10);
		  
	$labelsObj = $c->xAxis->setLabels($labels);
    $labelsObj->setFontAngle(90);

	$layer = $c->addLineLayer();
	
    $consulta_abrev="select abreviatura from proyecto_modernizacion.leyes where cod_leyes='".$ley1."'";
	$respuesta_abrev=mysqli_query($link, $consulta_abrev);
	$row_abrev=mysqli_fetch_array($respuesta_abrev);
	
	if ($unidad_ley1=='15')
	   {
		$dataSetObj = $layer->addDataSet($data0, 0xcf4040, $row_abrev["abreviatura"]);
		$dataSetObj->setDataSymbol(SquareSymbol, 5);
	    }
    else {
	      $dataSetObj = $layer->addDataSet($data0, 0xcf4040, $row_abrev["abreviatura"]);
		  $dataSetObj->setDataSymbol(SquareSymbol, 5);
	      $dataSetObj->setUseYAxis2();
         }		
	 
	$consulta_abrev="select abreviatura from proyecto_modernizacion.leyes where cod_leyes='".$ley2."'";
	$respuesta_abrev=mysqli_query($link, $consulta_abrev);
	$row_abrev=mysqli_fetch_array($respuesta_abrev);  
	
	if ($unidad_ley2=='06')
	   {
		$dataSetObj = $layer->addDataSet($data1, 0x40cf40, $row_abrev["abreviatura"]);
		$dataSetObj->setDataSymbol(DiamondSymbol, 5);
		$dataSetObj->setUseYAxis2();
	   }
	else {
	      $dataSetObj = $layer->addDataSet($data1, 0x40cf40, $row_abrev["abreviatura"]);
	  	  $dataSetObj->setDataSymbol(DiamondSymbol, 5);
	     }   
	 
	$consulta_abrev="select abreviatura from proyecto_modernizacion.leyes where cod_leyes='".$ley3."'";
	$respuesta_abrev=mysqli_query($link, $consulta_abrev);
	$row_abrev=mysqli_fetch_array($respuesta_abrev);  
	
	if ($unidad_ley3=='15')
	   { 
		$dataSetObj = $layer->addDataSet($data2, 0xcf40cf, $row_abrev["abreviatura"]);
    	$dataSetObj->setDataSymbol(CircleSymbol, 5);
	   }
	else {
	      $dataSetObj = $layer->addDataSet($data2, 0xcf40cf, $row_abrev["abreviatura"]);
    	  $dataSetObj->setDataSymbol(CircleSymbol, 5);
	       $dataSetObj->setUseYAxis2();
	     }   
	    
	if ($i2 < 15)
	   {
	#Enable data label on the data points. Set the label format to nn%.
	    $layer->setDataLabelFormat("{value|2}");/* aqui se muestran o no los valores en cada punto del grafico*/
	    }
	#Reserve 10% margin at the top of the plot area during auto-scaling to
	#leave space for the data labels.
	
	$c->yAxis->setAutoScale(0.1);
	$c->yAxis2->setAutoScale(0.1);
	
	#output the chart in PNG format
	header("Content-type: image/png");
	print($c->makeChart2(PNG));



?>

