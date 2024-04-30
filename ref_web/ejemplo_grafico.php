<?php
	include("../principal/conectar_ref_web.php");

	$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";

	$dif_ano = $ano;
	$dia_aux = intval($dia);
	$dif_dia = ($dia_aux-15);
	$dif_dia_rest = abs($dif_dia);

	if ($dif_dia<0)
		{$mes_aux=intval($mes);
		 $dif_mes=($mes_aux-1);
		 if ($dif_mes==0)
		    {$dif_mes=12;
			 $dif_ano=strval(intval($ano-1));}
		 $dif_dia=31;
		 $dif_dia=($dif_dia-$dif_dia_rest);
	 	 $dif_dia=strval($dif_dia);
		 $dif_mes=strval($dif_mes);}
	 else {$dif_mes=$mes;}

     $fecha2=$dif_ano."-".$dif_mes."-".$dif_dia;
	 $cont=0;
	 $i=0;
	while ($cont<=15)
    {
	    $arreglo_fecha[$i]=$fecha2;
	   $Consulta ="select fecha,ifnull(sum(unid_recup),0) as recuperado_tot, ifnull(sum(estampa),0) as ne, ifnull(sum(dispersos),0) as nd, ifnull(sum(rayado),0) as ra, ";
	   $Consulta =$Consulta."ifnull(sum(cordon_superior),0) as cs, ifnull(sum(cordon_lateral),0) as cl, ifnull(sum(otros),0) as ot from cal_web.rechazo_catodos as t1 " ;
	   $Consulta = $Consulta."where t1.fecha = '".$fecha2."' group by fecha";
	     
	   if (intval($dif_dia==31))
	   		{$dif_dia='1';
			 $dif_mes=strval(intval($dif_mes+1));
			 if ($dif_mes=='13')
			    {$dif_mes='1';
				 $dif_ano=strval(intval($dif_ano+1));}
			 $fecha2=$dif_ano."-".$dif_mes."-".$dif_dia;	} 
	   else {$dif_dia=strval(intval($dif_dia+1));
	         $fecha2=$dif_ano."-".$dif_mes."-".$dif_dia;	 }
		
	   $Respuesta2 = mysqli_query($link, $Consulta);
       $Fila2 = mysqli_fetch_array($Respuesta2);
	   
	   $total_ne=$Fila2["ne"];
	   $total_nd=$Fila2["nd"];
	   $total_ra=$Fila2["ra"];
	   $total_cl=$Fila2["cl"];
	   $total_cs=$Fila2["cs"];
	   $total_ot=$Fila2["ot"];
	   $total_rechazos=$total_ne+$total_nd+$total_ra+$total_cl+$total_cs+$total_ot;
	   /*echo $total_rechazos."<br>";*/
	   $arreglo2[$i]=$total_rechazos;
	   $i=$i+1;
	   $cont=$cont+1;
	}	

include("phpchartdir.php");

#The data for the line chart

$data = $arreglo2;

#The labels for the line chart
$labels = $arreglo_fecha;

#Create a XYChart object of size 500 x 320 pixels
$c = new XYChart(700, 400);

#Set background color to pale purple 0xffccff, with a black edge and a 1
#pixel 3D border
$c->setBackground(0xffffff, 0x0, 1);

#Set the plotarea at (55, 45) and of size 420 x 210 pixels, with white
#background. Turn on both horizontal and vertical grid lines with light
#grey color (0xc0c0c0)

#Set the plotarea at (55, 45) and of size 420 x 210 pixels, with white
#background. Turn on both horizontal and vertical grid lines with light
#grey color (0xc0c0c0)
$c->setPlotArea(55, 45, 600, 300, 0xffffff, -1, -1, 0xc0c0c0, -1);

#Add a legend box at (55, 25) (top of the chart) with horizontal layout.
#Use 8 pts Arial font. Set the background and border color to Transparent.
$legendObj = $c->addLegend(55, 25, false, "", 8);
$legendObj->setBackground(Transparent);

#Add a title box to the chart using 13 pts Times Bold Italic font. The text
#is white (0xffffff) on a purple (0x800080) background, with a 1 pixel 3D
#border.
$titleObj = $c->addTitle("Total de Catodos Estandar(Ultimos 15 dias)", "timesbi.ttf", 13,
    0xffffff);
$titleObj->setBackground(0x800080, -1, 1);

#Add a title to the y axis
$c->yAxis->setTitle("Unidades");

#Set the labels on the x axis. Rotate the font by 90 degrees.
$labelsObj = $c->xAxis->setLabels($labels);
$labelsObj->setFontAngle(90);

#Add a line layer to the chart
$layer = $c->addLineLayer();

#Add the data to the line layer using light brown color (0xcc9966) with a 7
#pixel square symbol
$dataSetObj = $layer->addDataSet($data, 0xcc9966, "Rechazados");
$dataSetObj->setDataSymbol(SquareSymbol, 7);

#Set the line width to 3 pixels
$layer->setLineWidth(3);

#Add a trend line layer using the same data with a dark green (0x008000)
#color. Set the line width to 3 pixels
$trendLayerObj = $c->addTrendLayer($data, 0x8000, "Linea de Tendencia");
$trendLayerObj->setLineWidth(3);

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
echo "</tr>\n";
include("../ref_web/Grafico2.php?fecha=".$fecha);
?>
