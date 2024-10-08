<?php
include("phpchartdir.php");

#the tilt angle of the pie
$angle = $HTTP_GET_VARS["img"] * 90 + 45;

#The data for the pie chart
$data = array(25, 18, 15, 12, 8, 30, 35);

#Create a PieChart object of size 100 x 110 pixels
$c = new PieChart(100, 110);

#Set the center of the pie at (50, 55) and the radius to 36 pixels
$c->setPieSize(50, 55, 36);

#Set the depth, tilt angle and 3D mode of the 3D pie (-1 means auto depth,
#"true" means the 3D effect is in shadow mode)
$c->set3D(-1, $angle, true);

#Add a title showing the shadow angle
$c->addTitle("Shadow @ ".$angle." deg", "arial.ttf", 8);

#Set the pie data
$c->setData($data);

#Disable the sector labels by setting the color to Transparent
$c->setLabelStyle("", 8, Transparent);

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
