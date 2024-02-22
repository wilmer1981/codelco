<?php
include("chart/lib/phpchartdir.php");
include("conectar.php");

$consulta = "SELECT fecha, valor from subs_web.mes_uf";
$resp = mysql_query($consulta);
	$i=0;
	while ($row = mysql_fetch_array($resp))
	   {
		$fecha[$i] = $row["fecha"];
	    $valor[$i] = $row["valor"];
		$i++;
		}
		
#The data for the line chart
$data = $valor;

#The labels for the line chart
$labels = $fecha;

#Create a XYChart object of size 300 x 280 pixels
$c = new XYChart(500, 300);

#Set the plotarea at (45, 30) and of size 200 x 200 pixels
$c->setPlotArea(45, 30, 400, 200);

#Add a title to the chart using 12 pts Arial Bold Italic font
$c->addTitle("Valor de la UF", "arialbi.ttf", 12);

#Add a title to the y axis
$labelsObj=$c->xAxis->setLabels($labels);
$labelsObj->setFontAngle(90);
$c->yAxis->setTitle("Pesos");

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

