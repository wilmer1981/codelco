<?php
include("phpchartdir.php");

#This demo chart shows the male and female population by age groups. It
#actually consists of two bar chart objects. They are merge into one chart
#using the ChartDirector API.

#The age groups
$labels = array("0 - 4", "5 - 9", "10 - 14", "15 - 19", "20 - 24",
    "24 - 29", "30 - 34", "35 - 39", "40 - 44", "44 - 49", "50 - 54",
    "55 - 59", "60 - 64", "65 - 69", "70 - 74", "75 - 79", "80+");

#The male population (in thousands)
$male = array(215, 238, 225, 236, 235, 260, 286, 340, 363, 305, 259, 164,
    135, 127, 102, 68, 66);

#The female population (in thousands)
$female = array(194, 203, 201, 220, 228, 271, 339, 401, 384, 304, 236,
    137, 116, 122, 112, 85, 110);


#=============================================================
#    Draw the main chart, which contains the right bar chart
#=============================================================

#Create a XYChart object of size 590 x 340 pixels
$c = new XYChart(590, 340);

#Add a title to the chart using Arial Bold Italic font
$c->addTitle("Demographics Hong Kong Year 2002", "arialbi.ttf");

#Set the plotarea at (320, 30) and of size 250 x 256 pixels. Use pink
#(0xffdddd) as the background. This is the plot area for the right bar
#chart. Later we will create another XYChart object and merge into the left
#side.
$c->setPlotArea(320, 30, 250, 256, 0xffdddd);

#Add a custom text label at the top right corner of the right bar chart
$textObj = $c->addText(570, 30, "Female", "timesbi.ttf", 12, 0xa07070);
$textObj->setAlignment(TopRight);

#Add the pink (0xf0c0c0) bar chart layer using the female data
$femaleLayer = $c->addBarLayer($female, 0xf0c0c0);

#Swap the axis so that the bars are drawn horizontally
$c->swapXY(true);

#Use a slightly negative bar gap so that the bars are packed tightly with
#the border of a bar overlaps with the borders its neighbours (that is, two
#bars sharing a common border)
$femaleLayer->setBarGap(-0.1);

#Set the border style of the bars to 1 pixel 3D border
$femaleLayer->setBorderColor(-1, 1);

#Add a Transparent line layer to the chart using the male data. As it is
#Transparent, only the female bar chart can be seen. We need both the male
#and female data in both the left and right charts, because we want their
#axis to have the same scale. In this example, we are using auto-scaling.
#If the data for the charts are different, the axis scale can be different.
#That's why we need to add both male and female to both charts, but make
#only one of them visible in each chart.
$c->addLineLayer($male, Transparent);

#Set the y axis label font to Arial Bold
$c->yAxis->setLabelStyle("arialbd.ttf");


#=============================================================
#    Draw the left bar chart
#=============================================================

#We change the data to negative, because the bars on the left bar chart
#start at the right side and extend to the left
for($i = 0; $i < count($labels); ++$i) {
    $male[$i] = -$male[$i];
    $female[$i] = -$female[$i];
}

#Create a XYChart object of size 280 x 300 pixels. This is the left bar
#chart.
$c2 = new XYChart(280, 300);

#Set the plotarea at (19, 0) and of size 250 x 256 pixels. Use pale blue
#(0xddddff) as the background.
$c2->setPlotArea(19, 0, 250, 256, 0xddddff);

#Add a custom text label at the top left corner of the left bar chart
$c2->addText(19, 0, "Male", "timesbi.ttf", 12, 0x7070a0);

#Add the pale blue (0xaaaaff) bar chart layer using the male data
$maleLayer = $c2->addBarLayer($male, 0xaaaaff);

#Swap the axis so that the bars are drawn horizontally
$c2->swapXY(true);

#Use a slightly negative bar gap so that the bars are packed tightly with
#the border of a bar overlaps with the borders its neighbours (that is, two
#bars sharing a common border)
$maleLayer->setBarGap(-0.1);

#Set the border style of the bars to 1 pixel 3D border
$maleLayer->setBorderColor(-1, 1);

#Add a Transparent line layer to the chart using the female data. This is
#to ensure both left and right charts are using the same data (both male
#and female data) so their auto-scaled axis will have the same scale.
$c2->addLineLayer($female, Transparent);

#Set the y-axis label format to ignore the negative sign. So even the data
#are negative, the axis will show positive numbers.
$c2->yAxis->setLabelFormat("{value|0.~~}");

#Set the y axis label font to Arial Bold
$c2->yAxis->setLabelStyle("arialbd.ttf");


#=============================================================
#    Merge the left chart into the main chart
#=============================================================

#Output the main chart into a DrawArea object for further manipulation
$drawarea = $c->makeChart3();

#merge the left chart into the main chart
$drawarea->merge($c2->makeChart3(), 0, 30, TopLeft, 0);


#=============================================================
#    Add more text labels to the chart
#=============================================================

#Add the labels for the age groups to the chart. These labels are located
#between the charts, so we handle them using custom text
for($i = 0; $i < count($labels); ++$i) {
    $textObj = $c->addText(295, $femaleLayer->getXCoor($i), $labels[$i],
        "arialbd.ttf");
    $textObj->setAlignment(Center);
}

#Add a horizontal axis title in the middle of the two charts. We also
#handle this using a custom text
$textObj = $c->addText(295, 315, "Population (in thousands)",
    "arialbi.ttf", 10);
$textObj->setAlignment(Center);

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
