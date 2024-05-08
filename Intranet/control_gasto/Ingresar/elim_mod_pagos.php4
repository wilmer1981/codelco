<html>
<body background="imagenes\amarillo1.jpg">
<?php

    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    if($opcion == modificar)
    {
                  echo '<form method="POST" action="pagos_modificados.php4">';
                  echo '<center>'.'<H1>'.''.'</H1>'.'</center>';
                  $sql="SELECT * FROM pagos where numero_contrato = '$parametro1' and ano_pago = '$parametro2'";
                  $result=mysql_query($sql);
                  $row=mysql_fetch_array($result);
                  echo "Registro a Modificar:";
                  echo '<select name ="parametro1">';
                  echo '<option>'.$row['numero_contrato'].'</option>'.'\n';
                  echo '</select>';
                  echo '<select name ="parametro2">';
                  echo '<option>'.$row['ano_pago'].'</option>'.'\n';
                  echo '</select>';
                  echo '<center>';
                  echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =80%>';
                  echo '<th align = center colspan = 2>'.'DATOS ACTUALES';
                  echo '<th align = center colspan = 3>'.'DATOS MODIFICADOS';
                  echo "<tr>";
                  echo '<TD align = center>'.'Enero';
                  echo '<TD align = center>'.$row['enero'];
                  echo '<TD align = center>'.'<input  type="text" name="Enero" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Febrero';
                  echo '<TD align = center>'.$row['febrero'];
                  echo '<TD align = center>'.'<input  type="text" name="Febrero" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Marzo';
                  echo '<TD align = center>'.$row['marzo'];
                  echo '<TD align = center>'.'<input  type="text" name="Marzo" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Abril';
                  echo '<TD align = center>'.$row['abril'];
                  echo '<TD align = center>'.'<input  type="text" name="Abril" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Mayo';
                  echo '<TD align = center>'.$row['mayo'];
                  echo '<TD align = center>'.'<input  type="text" name="Mayo" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Junio';
                  echo '<TD align = center>'.$row['junio'];
                  echo '<TD align = center>'.'<input  type="text" name="Junio" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Julio';
                  echo '<TD align = center>'.$row['julio'];
                  echo '<TD align = center>'.'<input  type="text" name="Julio" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Agosto';
                  echo '<TD align = center>'.$row['agosto'];
                  echo '<TD align = center>'.'<input  type="text" name="Agosto" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Septiembre';
                  echo '<TD align = center>'.$row['septiembre'];
                  echo '<TD align = center>'.'<input  type="text" name="Septiembre" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Octubre';
                  echo '<TD align = center>'.$row['octubre'];
                  echo '<TD align = center>'.'<input  type="text" name="Octubre" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Noviembre';
                  echo '<TD align = center>'.$row['noviembre'];
                  echo '<TD align = center>'.'<input  type="text" name="Noviembre" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Diciembre';
                  echo '<TD align = center>'.$row['diciembre'];
                  echo '<TD align = center>'.'<input  type="text" name="Diciembre" size="8" maxlength="8">';
                  echo '</TABLE>';
                  echo '<br><input type="Submit" name="enviar" value="Modificar">';
                  echo '</form>';
                  echo '</center>';
    }else
    if($opcion == eliminar)
    {
                  echo '<center>'.'<H1>'.'EL REGISTRO SE HA ELIMINADO'.'</H1>'.'</center>';
                  $sql="delete from pagos where numero_contrato = '$parametro1' and ano_pago = '$parametro2'";
                  $result=mysql_query($sql);
                  echo '<H2>'.'<A href="http://200.1.6.254/contrato%20y%20maestranza/bus_contratista.html">'.'come back'.'</A>'.'</H2>';
    }else
    {
        echo '<center>'.'<H1>'.'ELIJA UNA OPCION'.'</H1>'.'</center>';
    }
?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_pagos.html">ATRAS</A></H2>
</body>

