<html>
<body>
<?php

$myFile = $HTTP_GET_VARS["file"];
print("<h2>$myFile</h2>\n");
print("<p><a href='javascript:history.go(-1);'>Back to Chart Graphics</a></p>\n");
print("<xmp>\n");
readfile(dirname($HTTP_SERVER_VARS["PATH_TRANSLATED"])."/".basename($myFile));
print("</xmp>");

?>
</body>
</html>
