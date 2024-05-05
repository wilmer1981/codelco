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
   $consulta_fecha="select distinct fecha from ref_web.produccion where fecha between '".$FechaInicio."' and '".$FechaTermino."'";
   $respuesta_fecha=mysqli_query($link, $consulta_fecha);
   $i=0;
   $i2=0;
   while ($row_fecha=mysqli_fetch_array($respuesta_fecha))
         {
 		   $arreglo_fecha[$i]=$row_fecha["fecha"];
		   $consulta_grupo1="select sum(rechazo_delgadas+rechazo_gruesas+rechazo_granuladas) as total_rechazo ";
           $consulta_grupo1.="from ref_web.produccion where fecha ='".$row_fecha["fecha"]."' and  cod_grupo='1' ";
		   $respuesta_grupo1=mysqli_query($link, $consulta_grupo1);
		   $row_grupo1=mysqli_fetch_array($respuesta_grupo1);
		   //echo $row_grupo1[total_rechazo];
		   $arreglo_grupo1[$i]=$row_grupo1[total_rechazo];
		   $consulta_grupo2="select sum(rechazo_delgadas+rechazo_gruesas+rechazo_granuladas) as total_rechazo ";
           $consulta_grupo2.="from ref_web.produccion where fecha ='".$row_fecha["fecha"]."' and  cod_grupo='2' ";
		   $respuesta_grupo2=mysqli_query($link, $consulta_grupo2);
		   $row_grupo2=mysqli_fetch_array($respuesta_grupo2);
		   $arreglo_grupo2[$i]=$row_grupo2[total_rechazo];
		   $consulta_grupo7="select sum(rechazo_delgadas+rechazo_gruesas+rechazo_granuladas) as total_rechazo ";
           $consulta_grupo7.="from ref_web.produccion where fecha ='".$row_fecha["fecha"]."' and  cod_grupo='7' ";
		   $respuesta_grupo7=mysqli_query($link, $consulta_grupo7);
		   $row_grupo7=mysqli_fetch_array($respuesta_grupo7);
		   $arreglo_grupo7[$i]=$row_grupo7[total_rechazo];
		   $consulta_grupo8="select sum(rechazo_delgadas+rechazo_gruesas+rechazo_granuladas) as total_rechazo ";
           $consulta_grupo8.="from ref_web.produccion where fecha ='".$row_fecha["fecha"]."' and  cod_grupo='8' ";
		   $respuesta_grupo8=mysqli_query($link, $consulta_grupo8);
		   $row_grupo8=mysqli_fetch_array($respuesta_grupo8);
		   $arreglo_grupo8[$i]=$row_grupo8[total_rechazo];
		   $total_dia[$i]=$row_grupo2[total_rechazo]+$row_grupo2[total_rechazo]+$row_grupo7[total_rechazo]+$row_grupo8[total_rechazo];
		   
		   $consulta_grupo="select distinct cod_grupo from ref_web.grupo_electrolitico2 where hojas_madres<>'0' order by cod_grupo";
		   $respuesta_grupo=mysqli_query($link, $consulta_grupo);
		   $produccion=0;
		   while ($row_grupo=mysqli_fetch_array($respuesta_grupo))
			  {
		       $consulta_fecha_grupo="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <=  '".$row_fecha["fecha"]."' and cod_grupo ='".$row_grupo["cod_grupo"]."' group by cod_grupo";
		       $respuesta_fecha_grupo = mysqli_query($link, $consulta_fecha_grupo);
		       $row_fecha_grupo = mysqli_fetch_array($respuesta_fecha_grupo);
		       $consulta_datos_grupo =  "select max(fecha) as fecha,cod_grupo,cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
		       $consulta_datos_grupo.= " where fecha = '".$row_fecha_grupo["fecha"]."' and cod_grupo ='".$row_grupo["cod_grupo"]."' group by cod_grupo ";
		       $respuesta_datos_grupo = mysqli_query($link, $consulta_datos_grupo);
	   	       $row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
		       $produccion=$produccion+(($row_datos_grupo["hojas_madres"]*$row_datos_grupo[num_catodos_celdas])*2);
			  }
			$arreglo_porc_produccion[$i]=$produccion*0.04;   
		   $i++;
		   $i2++;
		 }		   
    $data0 = $arreglo_grupo1;
	$data1 = $arreglo_grupo2;
	$data2= $arreglo_grupo7;
	$data3=$arreglo_grupo8;
	$data4=$total_dia;
	$data5=$arreglo_porc_produccion;
	$labels = $arreglo_fecha;
	
	$c = new XYChart(920, 720);
	
	$c->setBackground(0xffffc0, 0x0, 1);
	
	$c->setPlotArea(45, 35, 820, 500, 0xffffff, -1, -1, 0xc0c0c0, -1);
	
	$legendObj = $c->addLegend(45, 12, false, "", 8);
	$legendObj->setBackground(Transparent);
	

		$titleObj = $c->addTitle("Tendencia de Rechazo Total Dia entre ".$FechaInicio." y ".$FechaTermino."", "arialbd.ttf",9, 0xffffff);
		$titleObj->setBackground($c->patternColor(array(0x4000, 0x8000), 2));

	
	      $c->yAxis->setTitle("Rechazo");
		  $c->yAxis->setColors(0xc00000, 0xc00000, 0xc00000);
	      $c->yAxis->setLinearScale(0, 1000, 150);
		  $yAxis2Obj = $c->yAxis2();
		  $yAxis2Obj->setTitle("Rechazo");
		  $yAxis2Obj = $c->yAxis2();
		  $yAxis2Obj->setColors(0x8000, 0x8000, 0x8000);
		 $c->yAxis2->setLinearScale(0, 1000, 150);
		  
	$labelsObj = $c->xAxis->setLabels($labels);
    $labelsObj->setFontAngle(90);

	$layer = $c->addLineLayer();
	

    $dataSetObj = $layer->addDataSet($data0, 0xcf4040, "Grupo 1   ");
    $dataSetObj->setDataSymbol(SquareSymbol, 5);
	   
    $dataSetObj = $layer->addDataSet($data1, 0x40cf40, "Grupo 2");
    $dataSetObj->setDataSymbol(DiamondSymbol, 5);
    $dataSetObj->setUseYAxis2();
	 
	$dataSetObj = $layer->addDataSet($data2, 0xcf40cf, "Grupo 7");
    $dataSetObj->setDataSymbol(CircleSymbol, 5);
	   
    $dataSetObj = $layer->addDataSet($data3, 0x4040cf, "Grupo 8");
    $dataSetObj->setDataSymbol(TriangleSymbol, 5);
    $dataSetObj->setUseYAxis2();
	
	$dataSetObj = $layer->addDataSet($data4, 0x990033, "Total Real");
    $dataSetObj->setDataSymbol(TriangleSymbol, 7);
    $dataSetObj->setUseYAxis2();
	
	$dataSetObj = $layer->addDataSet($data5, 0x000000, "Total Meta 4%");
    $dataSetObj->setDataSymbol(CircleSymbol, 5);
    $dataSetObj->setUseYAxis2();

	
	if ($i2 < 15)
	   {
	#Enable data label on the data points. Set the label format to nn%.
	    $layer->setDataLabelFormat("{value}");/* aqui se muestran o no los valores en cada punto del grafico*/
	    }
	#Reserve 10% margin at the top of the plot area during auto-scaling to
	#leave space for the data labels.
	
	$c->yAxis->setAutoScale(0.1);
	$c->yAxis2->setAutoScale(0.1);
	
	#output the chart in PNG format
	header("Content-type: image/png");
	print($c->makeChart2(PNG));
?>

