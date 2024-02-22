<?php
echo round(1.467)."<br>";
echo round(1.467,1)."<br>";
echo round(1.467,2)."<br>";
echo round(1.467,3)."<br>";

echo round(2.467)."<br>";
echo round(2.467,1)."<br>";
echo round(2.467,2)."<br>";
echo round(2.467,3)."<br>";

$FechaAnt = date('Y-m-d',mktime(0,0,0,date("m")-1,date("d"),  date("Y")));
echo "ultimo mes:".$FechaAnt;


/*$Datos="E-450620\r\n12500\r\n";

echo "<script languaje='javascript'>";

echo "var fso = new ActiveXObject('Scripting.FileSystemObject');";
echo "mode=1;";
echo "data=".$Datos.";";
echo "filename='c:/datos.txt';";
echo "if(fso.FileExists(filename) == false&&mode==0) return false;";
echo "if(fso.FileExists(filename) != false&&mode==2) {";
echo "tf = fso.OpenTextFile(filename,1);";
echo "var dataold = tf.readall(); tf.close(); }";
echo "else dataold='';";
echo "var tf = fso.CreateTextFile(filename,2);";
echo "tf.write(dataold+data);";
echo "tf.close();";
echo "</script>";*/

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="javascript">
function Proceso()
{
	var f=document.form1;
	
	
	fwrite_x('c:/','prueba.txt','hola\r\nprueba\r\n',1);
			
}

/*function fwrite_x(folder,filename,data,mode)
{ //fwrite_x v1.0 byScriptman
//modes: 0:si no existe, regresa false ;1: sobreescribe; 2:append.
var fso = new ActiveXObject("Scripting.FileSystemObject");

filename=folder+filename;
if(fso.FileExists(filename) == false&&mode==0) return false;
if(fso.FileExists(filename) != false&&mode==2) {
tf = fso.OpenTextFile(filename,1);
var dataold = tf.readall(); tf.close(); }
else dataold="";
var tf = fso.CreateTextFile(filename,2);
tf.write(dataold+data);
tf.close();
return true;
}*/
</SCRIPT>
</head>

<body>
<form name="form1" method="post" action="">
  <input type="button" name="Submit" value="Enviar" onClick="Proceso()">
</form>
</body>
</html>
