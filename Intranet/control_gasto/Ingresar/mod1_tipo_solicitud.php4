<html>
<body background="imagenes\amarillo1.jpg">

<CENTER><H1>RESULTADO BUSQUEDA</H1></CENTER>

<form method="POST" action="mod2_tipo_solicitud.php4">

<li>Registro(s):<br>

<?php

$link=mysql_connect("200.1.6.254","root");
mysql_select_db("bd_contrato_maestranza",$link);
$Tipo=strtoupper($Tipo);
$sql="select * from tipo_solicitud where tipo_solicitud like '$Tipo' ";
$sql1="select * from tipo_solicitud where tipo_solicitud like '$Tipo' order by tipo_solicitud";
$result=mysql_query($sql);
$result2=mysql_query($sql1);
$yatu=" ";

if($row = mysql_fetch_array($result))
{
  echo '<H3>'.'Tipo : '.$row['tipo_solicitud'].'</H3>';
  echo '<H3>'.'Descripcion : '.$row['descripcion_solicitud']         .$yatu.$yatu.'Nueva Descripcion : '.'<input  type="text" name="Nombre" size="20" >'.'</H3>';

  echo '<li>'.'Tipo Solicitud a Modificar       :';
  echo '<select name ="Mod">';
  while($row1 = mysql_fetch_array($result2))
  {
      echo '<option>'.$row1['tipo_solicitud'].'</option>\n';
  }
  echo '</select>';
  echo '<br>'.'<br>'.'<input type="Submit" name="enviar" value="Modificar">';
}
else
{
  echo '<h3>'.'No Encontrados'.'</h3>';
}
echo '<H2>'.'<A href="http://200.1.6.254/contrato%20y%20maestranza/bus_mod_tipo_solicitud.html">'.'Atras'.'</A></H2>';
echo '<H2>'.'<A href="http://200.1.6.254/contrato%20y%20maestranza/operaciones.html">'.'Atras Operaciones'.'</A></H2>';
?>





</body>
</html>
