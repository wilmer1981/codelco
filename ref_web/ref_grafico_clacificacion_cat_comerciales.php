<?php
  	include("../principal/conectar_ref_web.php");
    include("../principal/graficos/phpchartdir.php");
	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	$cmbcircuito= isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:"";
	
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
	       $i=0;
		   $i2=0;
		   $consulta="SELECT distinct (t1.fecha_produccion) as fecha ";
		   $consulta.="from sec_web.produccion_catodo as t1 ";
		   $consulta.="INNER JOIN ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo ";
		   $consulta.="where t1.fecha_produccion BETWEEN '".$FechaInicio."' and '".$FechaTermino."' and t2.cod_circuito='".$cmbcircuito."' ";
		   $consulta.="and t1.cod_producto='18' and t1.cod_subproducto='1' ";
		   $consulta.="GROUP by t1.fecha_produccion ";
		   $consulta.="ORDER by t1.fecha_produccion";
		   $respuesta = mysqli_query($link, $consulta);
		   while ($fila = mysqli_fetch_array($respuesta))
				 { 
				   $consulta_grupos_dia="SELECT t1.cod_grupo as cod_grupo ";
				   $consulta_grupos_dia.="from sec_web.produccion_catodo as t1 ";
				   $consulta_grupos_dia.="INNER JOIN ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo ";
				   $consulta_grupos_dia.="where t1.fecha_produccion ='".$fila["fecha"]."' and t2.cod_circuito='".$cmbcircuito."' ";
				   $consulta_grupos_dia.="and t1.cod_producto='18' and t1.cod_subproducto='1' ";
				   $consulta_grupos_dia.="GROUP by t1.fecha_produccion,t1.cod_grupo ";
				   $consulta_grupos_dia.="ORDER by t1.fecha_produccion";
				   $respuesta_grupos_dia=mysqli_query($link, $consulta_grupos_dia);
				   $total_grupo=0;
				   $rechazo_total_dias=0;
				   $recuperado_total_dias=0;
				   while ($row_grupos_dia=mysqli_fetch_array($respuesta_grupos_dia))
				        {
					      $consulta_t_rechazo_catodos="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,";
						  $consulta_t_rechazo_catodos.="sum(cordon_superior) as cs,sum(cordon_lateral) as cl,sum(quemados) as qu,sum(redondos) as re,";
						  $consulta_t_rechazo_catodos.="sum(aire) as ai,sum(otros) as ot ";
						  $consulta_t_rechazo_catodos.="from cal_web.rechazo_catodos where fecha='".$fila["fecha"]."' and grupo='".$row_grupos_dia["cod_grupo"]."'";
						  $respuesta_t_rechazo_catodos= mysqli_query($link, $consulta_t_rechazo_catodos);
				          $fila_t_rechazo_catodos = mysqli_fetch_array($respuesta_t_rechazo_catodos);
				          $suma_rechazo=$fila_t_rechazo_catodos["ne"]+$fila_t_rechazo_catodos["nd"]+$fila_t_rechazo_catodos["ra"]+$fila_t_rechazo_catodos["cs"]+$fila_t_rechazo_catodos["cl"]+$fila_t_rechazo_catodos["ot"];	
						  $suma_rechazo=$suma_rechazo+$fila_t_rechazo_catodos["qu"]+$fila_t_rechazo_catodos["re"]+$fila_t_rechazo_catodos["ai"];
						  $consulta_max_fecha_ge="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo='".$row_grupos_dia["cod_grupo"]."' and fecha<='".$fila["fecha"]."' ";
						  $respuesta_max_fecha_ge= mysqli_query($link, $consulta_max_fecha_ge);
						  $row_max_fecha_ge = mysqli_fetch_array($respuesta_max_fecha_ge);
						  $consulta_det_grupo = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos,ifnull(hojas_madres,0) as hojas_madres  from ref_web.grupo_electrolitico2 ";
						  $consulta_det_grupo = $consulta_det_grupo."where cod_grupo = '".$row_grupos_dia["cod_grupo"]."' and  fecha = '".$row_max_fecha_ge["fecha"]."'";
						  $respuesta_det_grupo = mysqli_query($link, $consulta_det_grupo);
						  $row_det_grupo = mysqli_fetch_array($respuesta_det_grupo);
						  
						  $total_grupo=$total_grupo+($row_det_grupo["num_catodos"]*($row_det_grupo["num_cubas"]-$row_det_grupo["hojas_madres"]));
						  $rechazo_total_dias=$rechazo_total_dias+$suma_rechazo;
						  $recuperado_total_dias=$recuperado_total_dias+$fila_t_rechazo_catodos["recuperado_tot"];
						}
					if($total_grupo>0){		
					   $seleccion_inicial=((($rechazo_total_dias+$recuperado_total_dias))/$total_grupo)*100;	
					   $recuperado_total=($recuperado_total_dias/$total_grupo)*100;
					   $rechazo_total=($rechazo_total_dias/$total_grupo)*100; 
					}else{
						$seleccion_inicial=0;	
					    $recuperado_total=0;
					    $rechazo_total=0;
					}
				   
				   $arreglo_fecha[$i]=$fila["fecha"];
				   $arreglo_acumulado_recuperado[$i]=number_format($recuperado_total,"2",".",".");
				   $arreglo_acumulado_rechazo[$i]=number_format($rechazo_total,"2",".",".");
				   
				   $divisor=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"];
				   $divisor2=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"]-$row_det_grupo["hojas_madres"];
				   $divisor2=$divisor2*$row_det_grupo["num_catodos"];
				   //$seleccion_inicial=(($suma_rechazo+$fila_t_rechazo_catodos["recuperado_tot"])/$divisor2)*100;
				   if($divisor2>0){	
				   $porc_recuperado=(($fila_t_rechazo_catodos["recuperado_tot"]/$divisor2)*100);
				   $total_por_rechazado=(($suma_rechazo/$divisor2)*100);
				   }else{
					$porc_recuperado=0;
					$total_por_rechazado=0;  
				   }
				   $arreglo_rechazo_dia[$i]=number_format($total_por_rechazado,"2",".",".");
				   $arreglo_recuperado_dia[$i]=number_format($porc_recuperado,"2",".",".");
				   $i++;
				   $i2++;
			     }	   				 
	$data0 = $arreglo_acumulado_recuperado;
	$data1 = $arreglo_acumulado_rechazo;
	$data2=$arreglo_recuperado_dia;
	$data3=$arreglo_rechazo_dia;
	$labels = $arreglo_fecha;
	
	$c = new XYChart(920, 720);
	
	$c->setBackground(0xffffc0, 0x0, 1);
	
	$c->setPlotArea(45, 35, 820, 500, 0xffffff, -1, -1, 0xc0c0c0, -1);
	
	$legendObj = $c->addLegend(45, 12, false, "", 8);
	$legendObj->setBackground(Transparent);
	

		$titleObj = $c->addTitle("Clasificación de Catodos Comerciales ".$FechaInicio." y ".$FechaTermino." para el circuito ".$cmbcircuito."", "arialbd.ttf",9, 0xffffff);
		$titleObj->setBackground($c->patternColor(array(0x4000, 0x8000), 2));

	
	      $c->yAxis->setTitle("Acumulado Rechazo Dia");
		  $c->yAxis->setColors(0xc00000, 0xc00000, 0xc00000);
	      $c->yAxis->setLinearScale(0, 12, 1);
		  $yAxis2Obj = $c->yAxis2();
		  $yAxis2Obj->setTitle("Acumulado Recuperado Dia");
		  $yAxis2Obj = $c->yAxis2();
		  $yAxis2Obj->setColors(0x8000, 0x8000, 0x8000);
		 $c->yAxis2->setLinearScale(0, 40, 2);
		  
	$labelsObj = $c->xAxis->setLabels($labels);
    $labelsObj->setFontAngle(90);

	$layer = $c->addLineLayer();
	

    $dataSetObj = $layer->addDataSet($data0, 0xcf4040, "Recuperado Acumulado   ");
    $dataSetObj->setDataSymbol(SquareSymbol, 10);
	 $dataSetObj->setUseYAxis2();
	   
    $dataSetObj = $layer->addDataSet($data1, 0x40cf40, "Estandar Acumulado");
    $dataSetObj->setDataSymbol(DiamondSymbol, 10);
    //$dataSetObj->setUseYAxis2();
	 
	$dataSetObj = $layer->addDataSet($data2, 0xcf40cf, "Recuperado Dia");
    $dataSetObj->setDataSymbol(CircleSymbol, 7);
	$dataSetObj->setUseYAxis2();   
    $dataSetObj = $layer->addDataSet($data3, 0x4040cf, "Estandar Dia");
    $dataSetObj->setDataSymbol(TriangleSymbol, 7);
    //$dataSetObj->setUseYAxis2();

	
	if ($i2 < 15)
	   {
	#Enable data label on the data points. Set the label format to nn%.
	    $layer->setDataLabelFormat("{value|1}");/* aqui se muestran o no los valores en cada punto del grafico*/
	    }
	#Reserve 10% margin at the top of the plot area during auto-scaling to
	#leave space for the data labels.
	
	$c->yAxis->setAutoScale(0.1);
	$c->yAxis2->setAutoScale(0.1);
	
	#output the chart in PNG format
	header("Content-type: image/png");
	print($c->makeChart2(PNG));
?>

