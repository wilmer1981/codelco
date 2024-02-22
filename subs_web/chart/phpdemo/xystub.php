
<html>
<body>
<h1>Simple Clickable XY Chart Handler</h1>
<p><a href="viewsource.php?file=<?=$HTTP_SERVER_VARS["SCRIPT_NAME"]?>">
View Source Code
</a></p>

<p><b>You have clicked on the following chart element :</b></p>
<ul>
    <li>Data Set : <?=$HTTP_GET_VARS["dataSetName"]?></li>
    <li>X Position : <?=$HTTP_GET_VARS["x"]?></li>
    <li>X Label : <?=$HTTP_GET_VARS["xLabel"]?></li>
    <li>Data Value : <?=$HTTP_GET_VARS["value"]?></li>
</ul>
</body>
</html>
