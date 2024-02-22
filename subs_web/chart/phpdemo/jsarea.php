<?php
include("phpchartdir.php");

#
#For demo purpose, we use hard coded data. In real life, the following data
#could come from a database.
#
$revenue = array(4500, 5600, 6300, 8000, 12000, 14000, 16000, 20000,
    24000, 28000);
$grossMargin = array(62, 65, 63, 60, 55, 56, 57, 53, 52, 50);
$backLog = array(563, 683, 788, 941, 1334, 1522, 1644, 1905, 2222, 2544);
$receviable = array(750, 840, 860, 1200, 2200, 2700, 2800, 3900, 4900, 6000
    );
$labels = array("1992", "1993", "1994", "1995", "1996", "1997", "1998",
    "1999", "2000", "2001");

#Create a XYChart object of size 440 x 200 pixels
$c = new XYChart(440, 200);

#Add a title to the chart using Times Bold Italic font
$c->addTitle("Annual Revenue for Star Tech", "timesbi.ttf");

#Set the plotarea at (60, 5) and of size 350 x 150 pixels
$c->setPlotArea(60, 25, 350, 150);

#Add an area chart layer for the revenue data
$areaLayerObj = $c->addAreaLayer($revenue, 0x3333cc, "Revenue");
$areaLayerObj->setBorderColor(SameAsMainColor);

#Set the x axis labels using the given labels
$c->xAxis->setLabels($labels);

#Add a title to the y axis
$c->yAxis->setTitle("USD (K)");

#Create the image and save it in a temporary location
session_register("chart");
$HTTP_SESSION_VARS["chart"] = $chart = $c->makeChart2(PNG);
$chartURL = "myimage.php?img=chart&id=".uniqid(session_id())."&".SID;

#Client side Javascript to show detail information "onmouseover"
$showText = "onmouseover='setDIV(\"info{x}\", \"visible\");' ";

#Client side Javascript to hide detail information "onmouseout"
$hideText = "onmouseout='setDIV(\"info{x}\", \"hidden\");' ";

#"alt" attribute to show tool tip
$toolTip = "alt='{xLabel}: USD {value|0}K'";

#Create an image map for the chart
$imageMap = $c->getHTMLImageMap("xystub.php", "", $showText.$hideText.
    $toolTip);
?>
<html>
<body>
<h1>Javascript Clickable Chart</h1>
<p><a href="viewsource.php?file=<?=$HTTP_SERVER_VARS["SCRIPT_NAME"]?>">
View Source Code
</a></p>

<p style="width:500px">
Move the mouse cursor over the area chart to see what happens!
This effect is achieved by using image maps with client side Javascript.
</p>

<img src="<?=$chartURL?>" border="0" usemap="#map1">
<map name="map1">
<?=$imageMap?>
</map>

<br>

<!-----------------------------------------------------
    Create the DIV layers to show detail information
-------------------------------------------------------->

<?for($i = 0; $i < count($revenue); ++$i) {?>

    <div id="info<?=$i?>"
        style="visibility:hidden;position:absolute;left:65px;">
        <b>Year <?=$labels[$i]?></b><br>
        Revenue : USD <?=$revenue[$i]?>K<br>
        Gross Margin : <?=$grossMargin[$i]?>%<br>
        Back Log : USD <?=$backLog[$i]?>K<br>
        A/C Receviable : USD <?=$receviable[$i]?>K<br>
    </div>

<?}?>

<!-----------------------------------------------------
    Client side utility function to show and hide
    a layer. Works in both IE and Netscape browsers.
-------------------------------------------------------->
<SCRIPT>
function setDIV(id, cmd) {
    if (document.all)
        //IE Browser
        document.all[id].style.visibility = cmd;
    else
        //Netscape Browser
        document[id].visibility = cmd;
}
</SCRIPT>

</body>
</html>
