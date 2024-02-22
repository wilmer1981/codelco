<?php
include("../chart/lib/phpchartdir.php");
include("../conectar.php");

$consulta = "SELECT fecha, valor from subs_web.mes_uf";
$resp = mysql_query($consulta);
	$i=0;
	while ($row = mysql_fetch_array($resp))
	   {
		$fecha[$i] = $row["fecha"];
	    $valor[$i] = $row["valor"];
		$i++;
		}

#The data for the pie chart
$data = array(25, 18, 15, 12, 8, 30, 35);

#The labels for the pie chart
$labels = array("a", "b", "c", "d", "e",
    "f", "g");

#Create a PieChart object of size 360 x 300 pixels
$c = new PieChart(360, 300);

#Set the center of the pie at (180, 140) and the radius to 100 pixels
$c->setPieSize(180, 140, 100);

#Add a title to the pie chart
$c->addTitle("Accidentes por Centro de Costo");

#Draw the pie in 3D
$c->set3D();

#Set the pie data and the pie labels
$c->setData($data, $labels);

#output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>

