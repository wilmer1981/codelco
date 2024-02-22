<?php
include("phpchartdir.php");

#The data for the bar chart
$data = array(-6.3, 2.3, 0.7, -3.4, 2.2, -2.9, -0.1, -0.1, 3.3, 6.2, 4.3,
    1.6);

#The labels for the bar chart
$labels = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug",
    "Sep", "Oct", "Nov", "Dec");

#Create a XYChart object of size 500 x 320 pixels
$c = new XYChart(500, 320);

#Add a title to the chart using Arial Bold Italic font
$c->addTitle("Productivity Change - Year 2001", "arialbi.ttf");

#Set the plotarea at (50, 30) and of size 400 x 250 pixels
$c->setPlotArea(50, 30, 400, 250);

#Split the original data array into two data arrays for the +ve and -ve
#data
$posData = array_pad(array(), count($data), 0);
$negData = array_pad(array(), count($data), 0);
for($i = 0; $i < count($labels); ++$i) {
    if ($data[$i] >= 0) {
        $posData[$i] = $data[$i];
        $negData[$i] = NoValue;
    } else {
        $negData[$i] = $data[$i];
        $posData[$i] = NoValue;
    }
}

#Add a blue (0x6666ff) bar chart layer using the positive data
$positiveLayer = $c->addBarLayer($posData, 0x6666ff);

#Use blue bar labels (0x3333ff) for the positive bar layer
$positiveLayer->setAggregateLabelStyle("arialbd.ttf", 8, 0x3333ff);

#Add a red (0xff6600) bar chart layer using the negative data
$negativeLayer = $c->addBarLayer($negData, 0xff6600);

#Use red bar labels (0xcc3300) for the negative bar layer
$negativeLayer->setAggregateLabelStyle("arialbd.ttf", 8, 0xcc3300);

#Set the labels on the x axis
$labelsObj = $c->xAxis->setLabels($labels);
$labelsObj->setFontStyle("arialbd.ttf");

#Reverse 10% margin on top and bottom of the plot area during auto-scaling
#to leave space for the bar labels
$c->yAxis->setAutoScale(0.1, 0.1);

#Draw the y axis on the right of the plot area
$c->setYAxisOnRight(true);

#Use Arial Bold as the y axis label font
$c->yAxis->setLabelStyle("arialbd.ttf");

#Add a title to the y axis
$c->yAxis->setTitle("Percentage");

#
#Draw background colors of the plot area. The positive side is pale blue,
#while the negative side is red. This is done by drawing two custom boxes
#at the plotarea background
#

#Need to layout first to determine the axis-scale, so that the zero point
#position can be determined.
$c->layout();

#Obtain the DrawArea object for custom drawing
$drawarea = $c->getDrawArea();

#Draw the positive rectangle background using pale blue (0xccccff)
$drawarea->rect(50, 30, 450, $positiveLayer->getYCoor(0), 0xccccff,
    0xccccff);

#Draw the negative rectangle background using pale red (0xffcccc)
$drawarea->rect(50, $negativeLayer->getYCoor(0), 450, 280, 0xffcccc,
    0xffcccc);

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
