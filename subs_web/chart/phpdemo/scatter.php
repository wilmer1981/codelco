<?php
include("phpchartdir.php");

#The XY points for the scatter chart
$dataX = array(150, 400, 300, 1500, 800);
$dataY = array(0.6, 8, 5.4, 2, 4);

#The labels for the points
$labels = array("Nano\n100", "SpeedTron\n200 Lite", "SpeedTron\n200",
    "Marathon\nExtra", "Marathon\n2000");

#Create a XYChart object of size 450 x 400 pixels
$c = new XYChart(450, 400);

#Set the plotarea at (55, 40) and of size 350 x 300 pixels, with white
#background and a light grey border (0xc0c0c0). Turn on both horizontal and
#vertical grid lines with light grey color (0xc0c0c0)
$c->setPlotArea(55, 40, 350, 300, 0xffffff, -1, 0xc0c0c0, 0xc0c0c0, -1);

#Add a title to the chart using 18 pts Times Bold Itatic font.
$c->addTitle("Product Comparison Chart", "timesbi.ttf", 18);

#Add a title to the y axis using 12 pts Arial Bold Italic font
$c->yAxis->setTitle("Capacity (tons)", "arialbi.ttf", 12);

#Set the y axis line width to 3 pixels
$c->yAxis->setWidth(3);

#Reserve 10% margin at the top of the plot area during auto-scaling to
#leave space for the data labels.
$c->yAxis->setAutoScale(0.1);

#Add a title to the y axis using 12 pts Arial Bold Italic font
$c->xAxis->setTitle("Range (miles)", "arialbi.ttf", 12);

#Set the x axis line width to 3 pixels
$c->xAxis->setWidth(3);

#Set the x axis scale from 0 - 2000, with ticks every 200 units
$c->xAxis->setLinearScale(0, 2000, 200);

#Add the data as a scatter chart layer, using a 15 pixel circle as the
#symbol
$layer = $c->addScatterLayer($dataX, $dataY, "Server BBB", CircleSymbol,
    15, 0xff3333, 0xff3333);

#Add the labels besides the data points using custom data labels
for($i = 0; $i < count($labels); ++$i) {
    #Add a custom data label to data point i using 8 ptrs Arial Bold font
    $textbox = $layer->addCustomDataLabel(0, $i, $labels[$i],
        "arialbd.ttf", 8);

    #Set the background of the custom label to purple (0xcc99ff) with a 1
    #pixel 3D border
    $textbox->setBackground(0xcc99ff, Transparent, 1);

    #Align the text box so that the data point is on the left side
    $textbox->setAlignment(Left);

    #Add (4, 0) offset to the text box position (move right by 4 pixels)
    $textbox->setPos(4, 0);
}

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
