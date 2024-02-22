<?php
include("phpchartdir.php");

#
#    We use a random number generator to simulate a data collector
#    collecting data every 4 minutes from 9:28am onwards.
#
$noOfPoints = 148;
$data = array_pad(array(), $noOfPoints, 0);
$label = array_pad(array(), $noOfPoints, "");

#assume only the first 75% data points have value.
srand(1);
$data[0] = 1800;
for($i = 1; $i < $noOfPoints * 3 / 4; ++$i) {
    $data[$i] = $data[$i - 1] + rand() / getrandmax() * 10 - 5;
}
for($i = $noOfPoints * 3 / 4; $i < $noOfPoints; ++$i) {
    $data[$i] = NoValue;
}

#generate the x-axis labels at 10:00am, 12:00pm, 2:00pm, 4:00pm and 6:00pm
$startTime = 568;
$label[(10 * 60 - $startTime) / 4] = "10am";
$label[(12 * 60 - $startTime) / 4] = "12pm";
$label[(14 * 60 - $startTime) / 4] = "2pm";
$label[(16 * 60 - $startTime) / 4] = "4pm";
$label[(18 * 60 - $startTime) / 4] = "6pm";

#
#    Now we obtain the data into arrays, we can start to draw the chart
#    using ChartDirector
#

#Create a XYChart object of size 180 x 180 pixels with a blue background
#(0x9c9cce)
$c = new XYChart(180, 180, 0x9c9cce);

#Add titles to the top and bottom of the chart using 7.5pt Arial font. The
#text is white 0xffffff on a deep blue 0x31319C background.
$c->addTitle2(Top, "STAR TECH INDEX  2001-03-28", "arial.ttf", 7.5,
    0xffffff, 0x31319c);
$c->addTitle2(Bottom, "CLOSE  STI:1851.41 (+143.51)", "arial.ttf", 7.5,
    0xffffff, 0x31319c);

#Set the plotarea at (31, 21) and of size 145 x 124 pixels, with a pale
#yellow (0xffffc8) background.
$c->setPlotArea(31, 21, 145, 124, 0xffffc8);

#Add custom text at (176, 21) (top right corner of plotarea) using 11pt
#Times Bold Italic font/red (0xc09090) color
$textObj = $c->addText(176, 21, "Chart Demo", "timesbi.ttf", 11, 0xc09090);
$textObj->setAlignment(TopRight);

#Use 7.5 pts Arial as the y axis label font
$c->yAxis->setLabelStyle("", 7.5);

#Set the labels on the x axis
$c->xAxis->setLabels($label);

#Use 7.5 pts Arial as the x axis label font
$c->xAxis->setLabelStyle("", 7.5);

#Add a deep blue (0x000080) line layer to the chart
$c->addLineLayer($data, 0x80);

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
