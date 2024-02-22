<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
</head>

<body>
<?
	include("../principal/encabezado.php");
	include("conectar.php");
?>
<table width="700" border="0">
  <tr>
    <td><p align="center"><img src="Manual.JPG" width="157" height="59"></p>
      <p align="center"><img src="PMN.JPG" width="211" height="27"></p>
      <p align="center"><img src="Ma&#241;ana/3.JPG" width="568" height="374"></p>
      <table width="428" border="1" align="center">
        <tr>
          <td colspan="2"><div align="center">Detalle</div></td>
        </tr>
        <tr>
          <td width="132">1.-</td>
          <td width="280">Debe ingresar el numero de flujo, luego debe presionar el boton Buscar</td>
        </tr>
        <tr>
          <td>2.-</td>
          <td>Cuando se presiona el boton lo que hace es asociar el flujo a un nombre de producto (item) </td>
        </tr>
        <tr>
          <td>3.-</td>
          <td>Se selecciona el item que sera buscado.En el caso de seleccionar un item automaticamente asociara el flujo correspondiente</td>
        </tr>
        <tr>
          <td>4.-</td>
          <td>Debera seleccionar el tipo de movimiento para realizar la busqueda</td>
        </tr>
        <tr>
          <td>5.-</td>
          <td><p>Debe hacer click al icono el cual desplegara una calendario para que se seleccione la fecha de inicio de la busqueda .</p>
              <p> Ademas cabe se&ntilde;alar que cuando se realize una busqueda siempre se debe seleccionar el dia primero de cada mes. </p></td>
        </tr>
        <tr>
          <td>6.-</td>
          <td>Se selecciona la fecha de fin de la busqueda </td>
        </tr>
        <tr>
          <td>7.-</td>
          <td>Se muestran los resultados por pantalla de la busqueda</td>
        </tr>
      </table>
    <p align="center"><a href="codelco.php"><img src="backover.jpg" width="24" height="24" border="0"></a></p></td>
  </tr>
</table>
<p align="center">&nbsp;</p>
<?
	include("../principal/pie_pagina.php");
?>
</body>
</html>
