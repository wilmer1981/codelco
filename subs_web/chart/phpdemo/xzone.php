<?php
include("phpchartdir.php");

#===================================================================
#    For demo purpose, use random numbers as data for the chart
#===================================================================

#Arrays to hold data for three lines and the labels
$data0 = array_pad(array(), 31, 0);
$data1 = array_pad(array(), 31, 0);
$data2 = array_pad(array(), 31, 0);
$labels = array_pad(array(), 31, "");

#Simulate the data using random numbers
srand(1);
$data0[0] = 40;
$data1[0] = 50;
$data2[0] = 60;
$labels[0] = "1";
for($i = 1; $i < 31; ++$i) {
    $data0[$i] = $data0[$i - 1] + rand() / getrandmax() * 10 - 5;
    $data1[$i] = $data1[$i - 1] + rand() / getrandmax() * 10 - 5;
    $data2[$i] = $data2[$i - 1] + rand() / getrandmax() * 10 - 5;
    $labels[$i] = $i + 1;
}

#Simulate some data points have no data value
for($i = 1; $i < 30; $i += 7) {
    $data0[$i] = NoValue;
    $data1[$i] = NoValue;
    $data2[$i] = NoValue;
}

#===================================================================
#    Now we have the data ready. Actually drawing the chart.
#===================================================================

#Create a XYChart object of size 600 x 220 pixels
$c = new XYChart(600, 220);

#Set the plot area at (100, 25) and of size 450 x 150 pixels. Enabled both
#vertical and horizontal grids by setting their colors to light grey
#(0xc0c0c0)
$plotAreaObj = $c->setPlotArea(100, 25, 450, 150);
$plotAreaObj->setGridColor(0xc0c0c0, 0xc0c0c0);

#Add a legend box (92, 0) (top of plot area) using horizontal layout. Use 8
#pts Arial font. Disable bounding box (set border to transparent).
$legendObj = $c->addLegend(92, 0, false, "", 8);
$legendObj->setBackground(Transparent);

#Add a title to the y axis. Draw the title upright (font angle = 0)
$titleObj = $c->yAxis->setTitle("Average\nUtilization\n(MBytes)");
$titleObj->setFontAngle(0);

#Use manually scaling of y axis from 0 to 100, with ticks every 10 units
$c->yAxis->setLinearScale(0, 100, 10);

#Set the labels on the x axis
$c->xAxis->setLabels($labels);

#Set the title on the x axis
$c->xAxis->setTitle("Jun - 2001");

#Add x axis (vertical) zones to indicate Saturdays and Sundays
for($i = 0; $i < 29; $i += 7) {
    $c->xAxis->addZone($i, $i + 2, 0xc0c0c0);
}

#Add a line layer to the chart
$layer = $c->addLineLayer();

#Set the default line width to 2 pixels
$layer->setLineWidth(2);

#Add the three data sets to the line layer
$layer->addDataSet($data0, 0xcf4040, "Server #1");
$layer->addDataSet($data1, 0x40cf40, "Server #2");
$layer->addDataSet($data2, 0x4040cf, "Server #3");

#Layout the chart to fix the y axis scaling. We can then use getXCoor and
#getYCoor to determine the position of custom objects.
$c->layout();

#Add the "week n" custom text boxes at the top of the plot area.
for($i = 0; $i < 4; ++$i) {
    #Add the "week n" text box using 8 pt Arial font with top center
    #alignment.
    $textbox = $c->addText($layer->getXCoor($i * 7 + 2), 25, "Week ".$i,
        "arialbd.ttf", 8, 0x0, TopCenter);

    #Set the box width to cover five days
    $textbox->setSize($layer->getXCoor($i * 7 + 7) - $layer->getXCoor($i *
        7 + 2) + 1, 0);

    #Set box background to pale yellow 0xffff80, with a 1 pixel 3D border
    $textbox->setBackground(0xffff80, Transparent, 1);
}

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
