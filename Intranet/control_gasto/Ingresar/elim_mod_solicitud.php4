              <html>
<body background="imagenes\amarillo1.jpg">

<?php

    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    if($opcion == modificar)
    {
                  echo '<form method="POST" action="solicitud_modificada.php4">';
                  echo '<center>'.'<H1>'.'MODIFICAR SOLICITUD'.'</H1>'.'</center>';
                  $sql="SELECT * FROM solicitud where numero_solicitud = '$parametro'";
                  $result=mysql_query($sql);
                  $row=mysql_fetch_array($result);
                  $sql="select tipo_solicitud,descripcion_solicitud from tipo_solicitud";
                  $result1=mysql_query($sql);
                  $sql="select tipo_trabajo,descripcion_tipo from tipo_trabajo";
                  $result2=mysql_query($sql);
                  $sql="select codigo_moneda,descripcion_moneda from moneda";
                  $result3=mysql_query($sql);

                  echo "Registro a Modificar:";
                  echo '<select name ="parametro">';
                  echo '<option>'.$row['numero_solicitud'].'</option>'.'\n';
                  echo "<tr>";
                  echo '<center>';
                  echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =80%>';
                  echo '<th align = center>'.'Registro';
                  echo '<th align = center>'.'Dato Actuales';
                  echo '<th align = center>'.'Dato a Modificar';
                  echo "<tr>";
                  echo '<TD align = center>'.'Descripcion';
                  echo '<TD align = center>'.$row['descripcion'];
                  echo '<TD align = center>'.'<textarea  name= Descripcion rows=5  cols=20  wrap=virtual>'.'</textarea>';
                  echo "<tr>";
                  echo '<TD align = center>'.'Tipo de Solicitud';
                  echo '<TD align = center>'.$row['tipo_solicitud'];
                  echo '<TD align = center>'.'<select name ="Tipo_solicitud">';
                  while($row1 = mysql_fetch_array($result1))
                  {
                              echo '<option value="'.$row1['tipo_solicitud'].'">'.$row1['descripcion_solicitud'].'</option>\n';
                  }
                  echo '</select>';
                  echo "<tr>";
                  echo '<TD align = center>'.'Fecha de Entrega';
                  echo '<TD align = center>'.$row['fecha_entrega'];
                  echo '<TD align = center>'.'<input  type="text" name="Fecha_entrega" size="20" maxlength="20">';
                  echo "<tr>";
                  echo '<TD align = center>'.'CC entrega';
                  echo '<TD align = center>'.$row['cc_entrega'];
                  echo '<TD align = center>'.'<input  type="text" name="Cc_entrega" size="8" maxlength="8">';
                  echo "<tr>";
                  echo '<TD align = center>'.'Equipo';
                  echo '<TD align = center>'.$row['equipo'];
                  echo '<TD align = center>'.'<input  type="text" name="Equipo" size="8" maxlength="8">';
                  echo "<tr>";
                  echo '<TD align = center>'.'Tipo de Trabajo';
                  echo '<TD align = center>'.$row['tipo_trabajo'];
                  echo '<TD align = center>'.'<select name ="Tipo_trabajo">';
                  while($row2 = mysql_fetch_array($result2))
                  {
                              echo '<option value="'.$row2['tipo_trabajo'].'">'.$row2['descripcion_tipo'].'</option>\n';
                  }
                  echo '</select>';
                  echo "<tr>";
                  echo '<TD align = center>'.'Fecha de Solicitud';
                  echo '<TD align = center>'.$row['fecha_solicitud'];
                  echo '<TD align = center>'.'<input  type="text" name="Fecha_solicitud" size="8" maxlength="8">';
                  echo "<tr>";
                  echo '<TD align = center>'.'Numero Plano';
                  echo '<TD align = center>'.$row['numero_plano'];
                  echo '<TD align = center>'.'<input  type="text" name="Numero_plano" size="8" maxlength="8">';
                  echo "<tr>";
                  echo '<TD align = center>'.'Rut Solicitante';
                  echo '<TD align = center>'.$row['rut_solicitante'];
                  echo '<TD align = center>'.'<input  type="text" name="Rut" size="8" maxlength="8">'.'-'.'<input  type="text" name="Dv" size="1" maxlength="1">';
                  echo "<tr>";
                  echo '<TD align = center>'.'Observacion Plano';
                  echo '<TD align = center>'.$row['observacion_plano'];
                  echo '<TD align = center>'.'<input  type="text" name="Observacion_plano" size="30" maxlength="30">';
                  echo "<tr>";
                  echo '<TD align = center>'.'Muestra';
                  echo '<TD align = center>'.$row['muestra'];
                  echo '<TD align = center>'.'<input  type="text" name="Muestra" size="8" maxlength="8">';
                  echo "<tr>";
                  echo '<TD align = center>'.'Numero Base Tecnica';
                  echo '<TD align = center>'.$row['numero_base_tecnica'];
                  echo '<TD align = center>'.'<input  type="text" name="Numero_base_tecnica" size="8" maxlength="8">';
                  echo "<tr>";
                  echo '<TD align = center>'.'Codigo Moneda';
                  echo '<TD align = center>'.$row['codigo_moneda'];
                  echo '<TD align = center>'.'<select name ="Codigo_moneda">';
                  while($row3 = mysql_fetch_array($result3))
                  {
                  echo '<option value="'.$row3['codigo_moneda'].'">'.$row3['descripcion_moneda'].'</option>\n';
                  }
                  echo '</select>';
                  echo "<tr>";
                  echo '<TD align = center>'.'Item Gasto';
                  echo '<TD align = center>'.$row['item_gasto'];
                  echo '<TD align = center>'.'<input  type="text" name="Item_gasto" size="8" maxlength="8">';
                  echo "<tr>";
                  echo '<TD align = center>'.'Observaciones';
                  echo '<TD align = center>'.$row['observaciones'];
                  echo '<TD align = center>'.'<textarea  name=Observaciones  rows=5  cols=20  wrap=virtual>'.'</textarea>';
                  echo "<tr>";
                  echo "</table>";
                  echo '<br><input type="Submit" name="enviar" value="Modificar">';
                  echo '</center>';
                  echo '</form>';

    }else
    if($opcion == eliminar)
    {
        echo '$parametro';
                  echo '<center>'.'<H1>'.'EL REGISTRO SE HA ELIMINADO'.'</H1>'.'</center>';
                  $sql="delete from solicitud where numero_solicitud = '$parametro'";
                  $result=mysql_query($sql);
    }else
    {
        echo '<center>'.'<H1>'.'ELIJA UNA OPCION'.'</H1>'.'</center>';
    }
?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_solicitud.html">ATRAS</A></H2>
</body>
</html>

