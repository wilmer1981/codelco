<?php
    include("../principal/conectar_ref_web.php");

	$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	
	$dia_aux=intval($dia);
	$dif_dia=($dia_aux-15);
	$dif_dia_rest=abs($dif_dia);
	if ($dif_dia<0)
		{$mes_aux=intval($mes);
		 $dif_mes=($mes_aux-1);
		 $dif_dia=31;
		 $dif_dia=($dif_dia-$dif_dia_rest);
	 	 $dif_dia=strval($dif_dia);
		 $dif_mes=strval($dif_mes);}
	 else {$dif_mes=$mes;}
     $fecha2=$ano."-".$dif_mes."-".$dif_dia;
	 $cont=0;
	 $i=0;
	 while ($cont<=15)
      {
	    $arreglo_fecha[$i]=$fecha2;
	   $Consulta ="select fecha,ifnull(sum(unid_recup),0) as recuperado_tot, ifnull(sum(estampa),0) as ne, ifnull(sum(dispersos),0) as nd, ifnull(sum(rayado),0) as ra, ";
	   $Consulta =$Consulta."ifnull(sum(cordon_superior),0) as cs, ifnull(sum(cordon_lateral),0) as cl, ifnull(sum(otros),0) as ot from cal_web.rechazo_catodos as t1 " ;
	   $Consulta = $Consulta."where t1.fecha = '".$fecha2."' group by fecha";
	  //echo $Consulta."<br>";
	   if (intval($dif_dia==31))
	   		{$dif_dia='1';
			 $dif_mes=strval(intval($dif_mes+1));
		     $fecha2=$ano."-".$dif_mes."-".$dif_dia;	} 
	   else {$dif_dia=strval(intval($dif_dia+1));
	         $fecha2=$ano."-".$dif_mes."-".$dif_dia;	 }
	   $Respuesta2 = mysqli_query($link, $Consulta);
       $Fila2 = mysqli_fetch_array($Respuesta2);
			
			$total_ne=$Fila2["ne"];
			$total_nd=$Fila2["nd"];
			$total_ra=$Fila2["ra"];
			$total_cl=$Fila2["cl"];
			$total_cs=$Fila2["cs"];
			$total_ot=$Fila2["ot"];
			$arreglo_ne[$i]=$Fila2["ne"];
			$arreglo_nd[$i]=$Fila2["nd"];
			$arreglo_ra[$i]=$Fila2["ra"];
			$arreglo_cl[$i]=$Fila2["cl"];
			$arreglo_cs[$i]=$Fila2["cs"];
			$arreglo_ot[$i]=$Fila2["ot"];
			$cont=$cont+1;
			$i=$i+1;
			
		}

include("phpchartdir.php");		
		#The data for the bar chart
$data0 =$arreglo_ne;
$data1 =$arreglo_nd;
$data2 =$arreglo_ra;
$data3 =$arreglo_cl;
$data4 =$arreglo_cs;
$data5= $arreglo_ot;
$labels = $arreglo_fecha;

#Create a XYChart object of size 300 x 240 pixels
$c = new XYChart(700, 400);

#Add a title to the chart using 10 pt Arial font
$c->addTitle("Detalle Catodos Estandar(ultimos 15 dias)", "", 10);

#Set the plot area at (45, 25) and of size 240 x 180. Use two alternative
#background colors (0xffffc0 and 0xffffe0)
$plotAreaObj = $c->setPlotArea(45, 30, 600, 300);
$plotAreaObj->setBackground(0xffffc0, 0xffffe0);

#Add a legend box at (50, 20) using horizontal layout. Use 8 pt Arial font,
#with transparent background
$legendObj = $c->addLegend(50, 20, false, "", 8);
$legendObj->setBackground(Transparent);

#Add a title to the y-axis
$c->yAxis->setTitle("Unidades");

#Revenue 20 pixels at the top of the y-axis for the legend box
$c->yAxis->setTopMargin(20);

#Set the x axis labels
$labelsObj = $c->xAxis->setLabels($labels);
$labelsObj->setFontAngle(90);

#Add a multi-bar layer with 3 data sets
$layer = $c->addBarLayer2(Side, 3);
$layer->addDataSet($data0, 0xff8080, "NE");
$layer->addDataSet($data1, 0x80ff80, "ND");
$layer->addDataSet($data2, 0x8080ff, "RA");
$layer->addDataSet($data3, 0xff80ff, "CS");
$layer->addDataSet($data4, 0xffff80, "CL");
$layer->addDataSet($data5, 0xf80f80, "OT");

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));

		

?>
