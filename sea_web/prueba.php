<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function ll(f)
{	
	f.action = "prueba01.php";
	f.submit();
	
}
</script>
</head>

<body>  
<form action="" name="f" method="post">
<?php
/*
	$linea = 'load data local infile "C:/Archivos de programa/Apache Group/Apache/htdocs/sef/TraspasoPHP/Archivos/equipos.txt" into table equipos fields terminated by "," optionally enclosed by '."'".'"'."'".' lines terminated by ";"';   
	//mysqli_query($link, $linea);
	echo $linea;
*/
	$GLOBALS["arreglo"];
	$arreglo = array("hola","chao");
?>
  <input type="button" name="Button" value="Enviar" onClick="JavaScript:ll(this.form)">
</form>
</body>
</html>
