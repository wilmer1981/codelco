<?php
include("../chart/lib/phpchartdir.php");
include("../conectar.php");

$consulta = "SELECT secuencia,campo_1 FROM GESTION_RRHH.GESTION  WHERE ceiling(campo_1) >='82' and cod_gestion ='04'   and campo_7 <> '99' and campo_6 like '02%' order by ceiling(campo_1) desc";
$resp = mysql_query($consulta);
	$i=0;
	while ($row = mysql_fetch_array($resp))
	   {
		$secuencia[$i] = $row[secuencia];
	    $campo_1[$i] = $row[campo_1];
		$i++;
		}
		
#The data for the line chart
$data = $campo_1;

#The labels for the line chart
$labels = $secuencia;

#Create a XYChart object of size 300 x 280 pixels
$c = new XYChart(500, 300);

#Set the plotarea at (45, 30) and of size 200 x 200 pixels
$c->setPlotArea(45, 30, 400, 200);

#Add a title to the chart using 12 pts Arial Bold Italic font
$c->addTitle("GESTION RECURSOS HUMANOS", "arialbi.ttf", 12);

#Add a title to the y axis
$labelsObj=$c->xAxis->setLabels($labels);
$labelsObj->setFontAngle(80);
$c->yAxis->setTitle("PORCENTAJES");

#Add a title to the x axis
$c->xAxis->setTitle("Fecha");

#Add a blue (0x6666ff) 3D line chart layer using the give data
$lineLayerObj = $c->addLineLayer($data, 0x6666ff);
$lineLayerObj->set3D();

#Set the x axis labels using the given labels
$c->xAxis->setLabels($labels);

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>

