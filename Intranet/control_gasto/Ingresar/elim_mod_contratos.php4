<html>
<body background="imagenes\amarillo1.jpg">

<?php

    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    if($opcion == modificar)
    {
                  echo '<form method="POST" action="contrato_eliminado.php4">';
                  echo '<center>'.'<H1>'.'MODIFICAR CONTRATISTA'.'</H1>'.'</center>';
                  $sql="SELECT * FROM contratos where numero_contrato = '$parametro'";
                  $result=mysql_query($sql);
                  $row=mysql_fetch_array($result);
                  echo "Registro a Modificar:";
                  echo '<select name ="parametro">';
                  echo '<option>'.$row['numero_contrato'].'</option>'.'\n';
                  echo "<tr>";
                  echo '<center>';
                  echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =80%>';
                  echo '<th align = center colspan = 2>'.'DATOS ACTUALES';
                  echo '<th align = center colspan = 3>'.'DATOS MODIFICADOS';
                  echo "<tr>";
                  echo '<TD align = center>'.'Nombre contrato';
                  echo '<TD align = center>'.$row['nombre_contrato'];
                  echo '<TD align = center>'.'<input  type="text" name="Nombre_contrato" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Tipo  Contrato';
                  echo '<TD align = center>'.$row['tipo_contrato'];
                  echo '<TD align = center>'.'<input  type="text" name="Tipo_contrato" size="20" maxlength="20">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Numero solicitud';
                  echo '<TD align = center>'.$row['numero_solicitud'];
                  echo '<TD align = center>'.'<input  type="text" name="Numero_solicitud" size="20" maxlength="20">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Fecha inicio contrato';
                  echo '<TD align = center>'.$row['fecha_ini_contrato'];
                  echo '<TD align = center>'.'<input  type="text" name="Fecha_ini_contrato" size="40" maxlength="40">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Fecha termino contrato';
                  echo '<TD align = center>'.$row['fecha_ter_contrato'];
                  echo '<TD align = center>'.'<input  type="text" name="Fecha_ter_contrato" size="10" maxlength="10">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Rut adjudicado';
                  echo '<TD align = center>'.$row['rut_adjudicado'];
                  echo '<TD align = center>'.'<input  type="text" name="Rut_adjudicado" size="10" maxlength="10">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Valor trabajo';
                  echo '<TD align = center>'.$row['valor_trabajo'];
                  echo '<TD align = center>'.'<input  type="text" name="Valor_trabajo" size="20" maxlength="20">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Codigo moneda';
                  echo '<TD align = center>'.$row['codigo_moneda'];
                  echo '<TD align = center>'.'<input  type="text" name="Codigo_moneda" size="5" maxlength="5">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Fecha entrega contrato';
                  echo '<TD align = center>'.$row['fecha_entrega_contrato'];
                  echo '<TD align = center>'.'<input  type="text" name="Estado_contratista" size="5" maxlength="5">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Rut encargado';
                  echo '<TD align = center>'.$row['rut_encargado'];
                  echo '<TD align = center>'.'<input  type="text" name="Rut_encargado" size="5" maxlength="5">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Codigo estado';
                  echo '<TD align = center>'.$row['codigo_estado'];
                  echo '<TD align = center>'.'<input  type="text" name="Codigo_estado" size="5" maxlength="5">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Numero factura';
                  echo '<TD align = center>'.$row['numero_factura'];
                  echo '<TD align = center>'.'<input  type="text" name="Numero_factura" size="5" maxlength="5">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Multa';
                  echo '<TD align = center>'.$row['multa'];
                  echo '<TD align = center>'.'<input  type="text" name="Multa" size="5" maxlength="5">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Item gastos';
                  echo '<TD align = center>'.$row['item_gastos'];
                  echo '<TD align = center>'.'<input  type="text" name="Estado_contratista" size="5" maxlength="5">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Evaluacion anexo';
                  echo '<TD align = center>'.$row['evaluacion_anexo'];
                  echo '<TD align = center>'.'<input  type="text" name="Estado_contratista" size="5" maxlength="5">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Observaciones';
                  echo '<TD align = center>'.$row['observaciones'];
                  echo '<TD align = center>'.'<input  type="text" name="Observaciones" size="5" maxlength="5">';
                  echo '<tr>';
                  echo '</TABLE>';
                  
                  echo '<br><input type="Submit" name="enviar" value="Modificar">';
                  echo '</center>';
                  echo '</form>';

    }else
    if($opcion == eliminar)
    {
                  echo '<center>'.'<H1>'.'EL REGISTRO SE HA ELIMINADO'.'</H1>'.'</center>';
                  $sql="delete from contratistas where rut_contratista = '$parametro'";
                  $result=mysql_query($sql);
    }else
    {
        echo '<center>'.'<H1>'.'ELIJA UNA OPCION'.'</H1>'.'</center>';
    }
?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_contratista.html">ATRAS</A></H2>
</body>
</html>

