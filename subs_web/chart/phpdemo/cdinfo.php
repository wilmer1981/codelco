<html>
<body topmargin="0" leftmargin="5" rightmargin="0" marginwidth="5" marginheight="0">
<p><font size="5" face="Verdana"><b>ChartDirector Information</b></font></p>
<?php
include("phpchartdir.php");
?>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td valign="top"><font size="3" face="Verdana">&#8226&nbsp;&nbsp;</font></td>
	<td><font size="3" face="Verdana">Description : <?=getDescription()?><br>&nbsp;</td>
</tr>
<tr>
	<td valign="top"><font size="3" face="Verdana">&#8226&nbsp;&nbsp;</font></td>
	<td><font size="3" face="Verdana">Version : <?=(getVersion() & 0x7f000000) / 0x1000000?>.<?=(getVersion() & 0xff0000) / 0x10000?>.<?=getVersion() & 0xffff?><br>&nbsp;</td>
</tr>
<tr>
	<td valign="top"><font size="3" face="Verdana">&#8226&nbsp;&nbsp;</font></td>
	<td><font size="3" face="Verdana">Copyright : <?=getCopyright()?><br>&nbsp;</td>
</tr>
<tr>
	<td valign="top"><font size="3" face="Verdana">&#8226&nbsp;&nbsp;</font></td>
	<td><font size="3" face="Verdana">Boot Log : <br><li><?=str_replace("\n", "<li>", getBootLog())?><br>&nbsp;</td>
</tr>
<tr>
	<td valign="top"><font size="3" face="Verdana">&#8226;&nbsp;&nbsp;</font></td>
	<td><font size="3" face="Verdana">Font Loading Test : <br><li><?=str_replace("\n", "<li>", libgTTFTest())?><br>&nbsp;</td>
</tr>
</table>

</body>
</html>
