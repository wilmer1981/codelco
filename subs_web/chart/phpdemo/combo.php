<?php
include("phpchartdir.php");

#
#  We use a random number generator to simulate collecting data for 24
#  hours. The first two data sets have data points every 15 minutes. The
#  third data set has data points very one hour.
#
$noOfPoints = 97;
$data0 = array_pad(array(), $noOfPoints, 0);
$data1 = array_pad(array(), $noOfPoints, 0);
$data2 = array_pad(array(), $noOfPoints, 0);
$labels = array_pad(array(), $noOfPoints, "");

srand(1);
$data0[0] = 50;
$data1[0] = rand() / getrandmax() * 20 + 40;
$data2[0] = rand() / getrandmax() * 20 + 40;
$labels[0] = "0";
for($i = 1; $i < $noOfPoints; ++$i) {
    $data0[$i] = abs($data0[$i - 1] + rand() / getrandmax() * 30 - 15);
    $data1[$i] = abs($data1[$i - 1] + rand() / getrandmax() * 40 - 20);

    #data2 only has data once per hour (once every 4 points)
    if ($i % 4 == 0) {
        $data2[$i] = abs($data2[$i - 4] + rand() / getrandmax() * 60 - 30);
    } else {
        $data2[$i] = NoValue;
    }

    if ($i % 12 == 0) {
        $labels[$i] = $i / 4;
    } else if ($i % 4 == 0) {
        $labels[$i] = "-";
    }
}

#
#Now we obtain the data into arrays, we can start to draw the chart using
#ChartDirector
#

#Create a XYChart object of size 300 x 210 pixels
$c = new XYChart(300, 210);

#Set the plot area at (45, 10) and of size 240 x 150 pixels
$c->setPlotArea(45, 10, 240, 150);

#Add a legend box at (75, 5) (top of plot area) using 8 pts Arial font. Set
#the background and border to Transparent.
$legendObj = $c->addLegend(75, 5, false, "", 8);
$legendObj->setBackground(Transparent);

#Reserve 10% margin at the top of the plot area during auto-scaling to
#leave space for the legend box
$c->yAxis->setAutoScale(0.1);

#Add a title to the y axis
$c->yAxis->setTitle("Throughput (Mbps)");

#Set the labels on the x axis
$c->xAxis->setLabels($labels);

#Add a title to the x-axis
$c->xAxis->setTitle("June 12, 2001");

#Use non-indent mode for the axis. In this mode, the first and last bar in
#a bar chart is only drawn in half
$c->xAxis->setIndent(false);

#Add a line chart layer using red (0xff8080) with a line width of 3 pixels
$lineLayerObj = $c->addLineLayer($data0, 0xff8080, "Link A");
$lineLayerObj->setLineWidth(3);

#Add a 3D bar chart layer with depth of 2 pixels using green (0x80ff80) as
#both the fill color and line color
$barLayer = $c->addBarLayer2(Side, 2);
$dataSetObj = $barLayer->addDataSet($data2, -1, "Link B");
$dataSetObj->setDataColor(0x80ff80, 0x80ff80);

#Because each data point is 15 minutes, but the bar layer has only 1 point
#per hour, so for every 4 data points, only 1 point that has data. We will
#increase the bar width so that it will cover the neighbouring points that
#have no data. This is done by decreasing the bar gap to a negative value.
$barLayer->setBarGap(-2);

#Add an area chart layer using blue (0x8080ff) for area and line colors
$areaLayerObj = $c->addAreaLayer();
$dataSetObj = $areaLayerObj->addDataSet($data1, -1, "Link C");
$dataSetObj->setDataColor(0x8080ff, 0x8080ff);

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
