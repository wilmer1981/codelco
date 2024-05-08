<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
     $sql="select campo2  from temporal where campo1='1'";
     $result=mysql_query($sql);
      $row=mysql_fetch_array($result);
      $valor=$row['campo2'];
    $sql="delete from cotizaciones_contratistas where numero_cotizacion ='$valor'";
    $result=mysql_query($sql);
   echo '<center>'.'<H1>'.'EL REGISTRO SE HA ELIMINADO'.'</H1>'.'</center>';
?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_cotizaciones.html">ATRAS</A></H2>
</body>
</html>

