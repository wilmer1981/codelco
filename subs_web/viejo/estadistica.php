<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
/****Funcion de PopUp_grafico A******/
function popup_grafico(letra){
	var f = document.form1;
	if (letra =="A"){
	window.open("grafico_gen.php",""," fullscreen=no,left=165,top=100,width=500,height=260,scrollbars=yes,resizable = no");
	}
	if (letra =="B"){
	window.open("grafico_gen_1.php",""," fullscreen=no,left=165,top=100,width=600,height=360,scrollbars=yes,resizable = no");
	}
	if (letra =="C"){
	window.open("grafico_gen_2.php",""," fullscreen=no,left=165,top=100,width=600,height=360,scrollbars=yes,resizable = no");
	}
}
/*****************************/
</script>
</head>

<body>
<p>Graficos </p>
<p> 
  <input type="button" name="Submit3" value="Generar Grafico" style="width:155" onClick="popup_grafico('A') ">
</p>
<p> 
  <input type="button" name="Submit32" value="Generar Grafico" style="width:155" onClick="popup_grafico('B') ">
</p>
<p>
  <input type="button" name="Submit322" value="Generar Grafico" style="width:155" onClick="popup_grafico('C') ">
</p>
</body>
</html>
