<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    if($opcion == Eliminar)
    {
       $sql="delete from contratos where numero_contrato = '$Codigo'";
       $result=mysql_query($sql);
       echo '<center>'.'<h1>'.'¡ELIMINACION EXITOSA!'.'</h1>'.'</center>';
    }
    else
    {
       echo '<form method="POST" action="mod_contratos.php4">';

       $sql="select * from contratos where numero_contrato like '$Codigo' order by numero_contrato";
       $result1=mysql_query($sql);
       $result2=mysql_query($sql);
       $yatu=" ";

       if($row = mysql_fetch_array($result1))
       {
          echo '<li>'.'Numero contrato a Modificar       :';
          echo '<select name ="Mod">';
          while($row1 = mysql_fetch_array($result2))
          {
             echo '<option>'.$row1['numero_contrato'].'</option>\n';
          }
          echo '<select>';
          echo '<center>';
          echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =65%>';
          echo '<th align = center colspan = 2>'.'Registro';
          echo '<tr>';
          echo '<TD align = center>'.'Nombre contrato : ';
          echo '<TD align = center>'.$row['nombre_contrato'];
          echo '<TD align = center>'.'<input  type="text" name="Nombre_contrato" size="20" maxlength="20">';
          echo '<tr>';
          echo '<TD align = center>'.'Tipo contrato : ';
          echo '<TD align = center>'.$row['tipo_contrato'];
          echo '<TD align = center>'.'<input  type="text" name="Tipo_contrato" size="1" maxlength="1">';
          echo '<tr>';
          echo '<TD align = center>'.'Numero solicitud : ';
          echo '<TD align = center>'.$row['numero_solicitud'];
          echo '<TD align = center>'.'<input  type="text" name="Numero_solicitud" size="8" maxlength="8">';
          echo '<tr>';
          echo '<TD align = center>'.'Fecha inicio contrato : ';
          echo '<TD align = center>'.$row['fecha_ini_contrato'];
          echo '<TD align = center>'.'<input  type="text" name="Fecha_ini_contrato" size="8" maxlength="8">';
          echo '<tr>';
          echo '<TD align = center>'.'Fecha termino contrato : ';
          echo '<TD align = center>'.$row['fecha_ter_contrato'];
          echo '<TD align = center>'.'<input  type="text" name="Fecha_ter_contrato" size="8" maxlength="8">';
          echo '<tr>';
          echo '<TD align = center>'.'Rut adjudicado : ';
          echo '<TD align = center>'.$row['rut_adjudicado'];
          echo '<TD align = center>'.'<input  type="text" name="Rut_adjudicado" size="8" maxlength="8">-<input  type="text" name="Dv" size="1" maxlength="1">';
          echo '<tr>';
          echo '<TD align = center>'.'Valor trabajo: ';
          echo '<TD align = center>'.$row['valor_trabajo'];
          echo '<TD align = center>'.'<input  type="text" name="Valor_trabajo" size="7" maxlength="7">';
          echo '<tr>';
          echo '<TD align = center>'.'Codigo moneda: ';
          echo '<TD align = center>'.$row['codigo_moneda'];
          echo '<TD align = center>'.'<input  type="text" name="Codigo_moneda" size="4" maxlength="1">';
          echo '<tr>';
          echo '<TD align = center>'.'Fecha entrega contrato : ';
          echo '<TD align = center>'.$row['fecha_entrega_contrato'];
          echo '<TD align = center>'.'<input  type="text" name="Fecha_entrega_contrato" size="8" maxlength="8">';
          echo '<tr>';
          echo '<TD align = center>'.'Rut encargado : ';
          echo '<TD align = center>'.$row['rut_encargado'];
          echo '<TD align = center>'.'<input  type="text" name="Rut_encargado" size="8" maxlength="8">-<input  type="text" name="D" size="1" maxlength="1">';
          echo '<tr>';
          echo '<TD align = center>'.'Codigo estado : ';
          echo '<TD align = center>'.$row['codigo_estado'];
          echo '<TD align = center>'.'<input  type="text" name="Codigo_estado" size="1" maxlength="1">';
          echo '<tr>';
          echo '<TD align = center>'.'Numero factura : ';
          echo '<TD align = center>'.$row['numero_factura'];
          echo '<TD align = center>'.'<input  type="text" name="Numero_factura" size="10" maxlength="10">';
          echo '<tr>';
          echo '<TD align = center>'.'Multa : ';
          echo '<TD align = center>'.$row['multa'];
          echo '<TD align = center>'.'<input  type="text" name="Multa" size="7" maxlength="7">';
          echo '<tr>';
          echo '<TD align = center>'.'Item gasto : ';
          echo '<TD align = center>'.$row['item_gastos'];
          echo '<TD align = center>'.'<input  type="text" name="Item_gastos" size="10" maxlength="10">';
          echo '<tr>';
          echo '<TD align = center>'.'Evaluacion anexo : ';
          echo '<TD align = center>'.$row['evaluacion_anexo'];
          echo '<TD align = center>'.'<input  type="text" name="Evaluacion_anexo" size="10" maxlength="10">';
          echo '<tr>';
          echo '<TD align = center>'.'Observaciones : ';
          echo '<TD align = center>'.$row['observaciones'];
          echo '<TD align = center>'.'<input  type="text" name="Observaciones" size="20" maxlength="20">';

          echo '</TABLE>';
          echo '<center>';
          echo '<br>'.'<br>'.'<input type="Submit" name="enviar" value="Modificar">';
       }
    }
?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_contratos.html">ATRAS</A></H2>



</body>
</html>
