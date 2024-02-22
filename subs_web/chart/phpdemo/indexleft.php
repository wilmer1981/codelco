<html>
<script language="Javascript">
var charts = [
    ['', "Pie Chart Samples"],
    ['simplepie.php', "Simple Pie Chart", 1],
    ['threedpie.php', "3D Pie Chart", 1],
    ['sidelabelpie.php', "Side Label Layout", 1],
    ['labelpie.php', "Circular Label Layout", 2],
    ['legendpie.php', "Pie Chart with Legend", 1],
    ['bgpie.php', "Background Coloring", 1],
    ['goldpie.php', "Metallic Background Coloring", 1],
    ['colorpie.php', "Coloring and Wallpaper", 4],
    ['fontpie.php', "Text Style and Colors", 1],
    ['linepie.php', "Sectors with Borders", 1],
    ['3danglepie.php', "3D Angle", 7],
    ['3ddepthpie.php', "3D Depth", 5],
    ['shadowpie.php', "3D Shadow Mode", 4],
    ['anglepie.php', "Layout Angle and Direction", 2],
    ['', ""],
    ['', "Bar Chart Samples"],
    ['simplebar.php', "Simple Bar Chart", 1],
    ['threedbar.php', "3D Bar Chart", 1],
    ['colorbar.php', "Multi-Color Bar Chart", 1],
    ['stackedbar.php', "Stacked Bar Chart", 1],
    ['multibar.php', "Multi-Bar Chart", 1],
    ['depthbar.php', "Depth Bar Chart", 1],
    ['labelbar.php', "Bar Labels", 1],
    ['gapbar.php', "Bar Gap", 4],
    ['posnegbar.php', "Positive Negative Bars", 1],
    ['hbar.php', "Horizontal Bar Chart", 1],
    ['demographics.php', "Dual Horizontal Bar Charts", 1],
    ['', ""],
    ['', "Line Chart Samples"],
    ['simpleline.php', "Simple Line Chart", 1],
    ['enhancedline.php', "Enhanced Line Chart", 1],
    ['threedline.php', "3D Line Chart", 1],
    ['multiline.php', "Multiline Chart", 1],
    ['symbolline.php', "Symbol Line Chart", 1],
    ['trendline.php', "Trend Line Chart", 1],
    ['xyline.php', "Arbitrary XY Line Chart", 1],
    ['xzone.php', "Discontinuous Lines", 1],
    ['', ""],
    ['', "Scatter Chart Samples"],
    ['scatter.php', "Scatter Chart", 1],
    ['scattertrend.php', "Scatter Trend Chart", 1],
    ['', ""],
    ['', "Area Chart Samples"],
    ['simplearea.php', "Simple Area Chart", 1],
    ['threedarea.php', "3D Area Chart", 1],
    ['linearea.php', "Line Area Chart", 1],
    ['stackedarea.php', "Stacked Area Chart", 1],
    ['3dstackarea.php', "3D Stacked Area Chart", 1],
    ['deptharea.php', "Depth Area Chart", 1],
    ['', ""],
    ['', "Misc Chart Samples"],
    ['hloc.php', "High-Low-Open-Close Chart", 1],
    ['candlestick.php', "Candle Stick Chart", 1],
    ['combo.php', "Combination Chart", 1],
    ['', ""],
    ['', "Other XY Chart Features"],
    ['markzone.php', "Marks and Zones", 1],
    ['marks.php', "Marks and Zones (2)", 1],
    ['dualyaxis.php', "Dual Y-Axis", 1],
    ['dualxaxis.php', "Dual X-Axis", 1],
    ['fontxy.php', "Text Style and Colors", 1],
    ['background.php', "Background and Wallpaper", 4],
    ['logaxis.php', "Log Scale Axis", 2],
    ['axisscale.php', "Y-Axis Scaling", 5],
    ['ticks.php', "Tick Density", 2],
    ['', ""],
    ['', "Clickable Charts"],
    ['clickbar.php', "Simple Clickable Charts", 0],
    ['jsarea.php', "Javascript Clickable Charts", 0],
    ['customclick.php', "Custom Clickable Objects", 0],
    ['', ""],
    ['', "Working With Database"],
    ['dbdemo1_shell.php', "Database Integration (1)", 0],
    ['dbdemo2_shell.php', "Database Integration (2)", 0],
    ['dbdemo3_shell.php', "Database Clickable Charts", 0],
    ];
function setChart(c)
{
    var doc = top.indexright.document;
    doc.open();
    doc.writeln('<body topmargin="0" leftmargin="5" rightmargin="0" marginwidth="5" marginheight="0">');
    doc.writeln('<p style="margin-bottom:5px"><font size="5" face="Verdana"><b>' + charts[c][1] + '</b></font></p>');
    doc.writeln('<a href="viewsource.php?file=' + charts[c][0] + '"><font size="2" face="Verdana">View Chart Source Code</font></a>');
    doc.writeln('<p>');
    for (var i = 0; i < charts[c][2]; ++i)
        doc.writeln('<img src="' + charts[c][0] + '?img=' + i + '">');

    doc.writeln('</p>');
    doc.writeln('</body>');
    doc.close();
}
</script>
<body topmargin="0" leftmargin="5" rightmargin="0" marginwidth="5" marginheight="0">
<table border="0" cellpadding="0" cellspacing="0">
<script language="Javascript">
for (var c in charts)
{
    if (charts[c][0] == "")
        document.writeln('<tr><td colspan="2"><font size="2" face="Verdana"><b>' + charts[c][1] + '&nbsp;</b></font></td></tr>');
    else if (charts[c][2] != 0)
        document.writeln('<tr valign="top"><td><font size="1" face="Verdana">&#8226;&nbsp;&nbsp;</font></td><td><font size="1" face="Verdana"><a href="javascript:;" onclick="setChart(\'' + c + '\');">' + charts[c][1] + '</a></font></td></tr>');
    else
        document.writeln('<tr valign="top"><td><font size="1" face="Verdana">&#8226;&nbsp;&nbsp;</font></td><td><font size="1" face="Verdana"><a href="' + charts[c][0] + '" target="indexright">' + charts[c][1] + '</a></font></td></tr>');
}
</script>
</table>
</body>
</html>
