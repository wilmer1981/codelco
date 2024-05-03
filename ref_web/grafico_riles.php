<?php
   include("../principal/conectar_ref_web.php");

   $fecha       = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	
	$sql="SELECT  ADDDATE('$fecha',INTERVAL '-15' DAY) as fecha";
    $result=mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    $variable =$row["fecha"];

	$consulta="select t1.fecha_muestra, t1.id_muestra,t1.cod_producto,t1.cod_subproducto, ";
	$consulta.="t2.nro_solicitud,t2.cod_leyes,t2.valor,t2.cod_unidad ";
	$consulta.="from cal_web.solicitud_analisis as t1 ";
	$consulta.="inner join cal_web.leyes_por_solicitud as t2 ";
	$consulta.="on t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora ";
	$consulta.="and t1.id_muestra=t2.id_muestra and t1.recargo=t2.recargo and "; 
	$consulta.="t1.nro_solicitud=t2.nro_solicitud and t1.cod_producto=t2.cod_producto and ";
	$consulta.="t1.cod_subproducto=t2.cod_subproducto ";
	$consulta.="where left(t1.fecha_muestra,10) between '".$variable."' and '".$fecha."' and t1.cod_producto='45' and ";
	$consulta.="t2.cod_subproducto='15' and t1.id_muestra like 'pte-t%' ";
	$consulta.="and t2.cod_leyes in ('70') ";
	$consulta.="order by t1.fecha_muestra asc ";
	
	$respuesta = mysqli_query($link, $consulta);
	$i=0;
	while ($row = mysqli_fetch_array($respuesta))
	   {
	     $arreglo_leyes[$i]=$row["valor"];
		 $ano1=substr($row["fecha_muestra"],0,4);
		 $mes1=substr($row["fecha_muestra"],5,2);
		 $dia1=substr($row["fecha_muestra"],8,2);
		 $hora=substr($row["fecha_muestra"],11,2);
		 $minuto=substr($row["fecha_muestra"],14,2);
		 $segundo=substr($row["fecha_muestra"],17,2);
		 $fecha_m=$dia1.'-'.$mes1.'-'.$ano1.' '.$hora.':'.$minuto.':'.$segundo;
		 $arreglo_fecha[$i]=$fecha_m;
		 $w=8.5;
		 $y=6.5;
		 $arreglo2[$i]=$w;
		 $arreglo3[$i]=$y;		 
		 //$arreglo_fecha[$i]=$row["fecha_muestra"];
		 $i++;
	   }
	
	
	
	
	
	
	
include("phpchartdir.php");

$data0 = $arreglo_leyes;
$data1 = $arreglo2;
$data2 = $arreglo3;

#The labels for the line chart
$labels =  $arreglo_fecha;

#Create a XYChart object of size 500 x 300 pixels
$c = new XYChart(750, 500);

#Set background color to pale yellow 0xffff80, with a black edge and a 1
#pixel 3D border
$c->setBackground(0xffff80, 0x0, 1);

#Set the plotarea at (55, 45) and of size 420 x 210 pixels, with white
#background. Turn on both horizontal and vertical grid lines with light
#grey color (0xc0c0c0)
$c->setPlotArea(55, 45, 680, 300, 0xffffff, -1, -1, 0xc0c0c0, -1);

#Add a legend box at (55, 25) (top of the chart) with horizontal layout.
#Use 8 pts Arial font. Set the background and border color to Transparent.
$legendObj = $c->addLegend(55, 25, false, "", 8);
$legendObj->setBackground(Transparent);

#Add a title box to the chart using 11 pts Arial Bold Italic font. The text
#is white (0xffffff) on a dark red (0x800000) background, with a 1 pixel 3D
#border.
$titleObj = $c->addTitle("Grafico Analisis de pH Riles (Ultimos 15 dias)", "arialbi.ttf", 11, 0xffffff);
$titleObj->setBackground(0x800000, -1, 1);

#Add a title to the y axis
$c->yAxis->setLinearScale(0, 14, 1);

$c->yAxis->setTitle("pH");

#Set the labels on the x axis
//$c->xAxis->setLabels($labels);
$labelsObj = $c->xAxis->setLabels($labels);
$labelsObj->setFontAngle(90);

#Add a title to the x axis
$c->xAxis->setTitle("Fecha/hora toma muestra");

#Add a line layer to the chart
$layer = $c->addLineLayer();

#Set the default line width to 3 pixels
$layer->setLineWidth(2);

#Add the three data sets to the line layer
$layer->addDataSet($data0, -1, "pH");
$layer->addDataSet($data1, -1, "Valor Maximo");
$layer->addDataSet($data2, -1, "Valor Minimo");

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));







#The data for the line chart

/*$data = $arreglo_leyes;

#The labels for the line chart
$labels = $arreglo_fecha;

#Create a XYChart object of size 500 x 320 pixels
$c = new XYChart(750, 500);

#Set background color to pale purple 0xffccff, with a black edge and a 1
#pixel 3D border
$c->setBackground(0xffffff, 0x0, 1);

#Set the plotarea at (55, 45) and of size 420 x 210 pixels, with white
#background. Turn on both horizontal and vertical grid lines with light
#grey color (0xc0c0c0)

#Set the plotarea at (55, 45) and of size 420 x 210 pixels, with white
#background. Turn on both horizontal and vertical grid lines with light
#grey color (0xc0c0c0)
$c->setPlotArea(55, 45, 680, 300, 0xffffff, -1, -1, 0xc0c0c0, -1);

#Add a legend box at (55, 25) (top of the chart) with horizontal layout.
#Use 8 pts Arial font. Set the background and border color to Transparent.
$legendObj = $c->addLegend(55, 25, false, "", 8);
$legendObj->setBackground(Transparent);

#Add a title box to the chart using 13 pts Times Bold Italic font. The text
#is white (0xffffff) on a purple (0x800080) background, with a 1 pixel 3D
#border.
$titleObj = $c->addTitle("Grafico Analisis de pH Riles (Ultimos 15 dias)", "timesbi.ttf", 13,
    0xffffff);
$titleObj->setBackground(0x800080, -1, 1);

#Add a title to the y axis
$c->yAxis->setTitle("Valor Aproximado de Leyes");

#Set the labels on the x axis. Rotate the font by 90 degrees.
$labelsObj = $c->xAxis->setLabels($labels);
$labelsObj->setFontAngle(90);

#Add a line layer to the chart
$layer = $c->addLineLayer();

#Add the data to the line layer using light brown color (0xcc9966) with a 7
#pixel square symbol
$dataSetObj = $layer->addDataSet($data, 0xcc9966, "Ley");
$dataSetObj->setDataSymbol(SquareSymbol, 4);

#Set the line width to 3 pixels
$layer->setLineWidth(3);

#Add a trend line layer using the same data with a dark green (0x008000)
#color. Set the line width to 3 pixels
$trendLayerObj = $c->addTrendLayer($data, 0x8000, "Linea de Tendencia leyes riles");
$trendLayerObj->setLineWidth(3);

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));*/
echo "</tr>\n";
include("../ref_web/grafico_riles.php?fecha=".$fecha);
?>
