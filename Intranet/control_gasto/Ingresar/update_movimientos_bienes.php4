<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);

    if($opcion == "Eliminar")
    {
      $sql="delete from movimientos_bienes where numero_contrato = '$Numero'";
      $result=mysql_query($sql);
      echo '<center>'.'<h1>'.'¡ELIMINACION EXITOSA!'.'</h1>'.'</center>';
    }
    else
    {
      echo '<form method="POST" action="mod2_movimientos_bienes.php4">';

      $sql="select * from movimientos_bienes where numero_contrato = '$Numero' and tipo_movimiento = '$Numero1' ";
      $result=mysql_query($sql);
      $result2=mysql_query($sql);
      $result3=mysql_query($sql);
      if($row = mysql_fetch_array($result))
      {
         echo '<li>'.'Numero Contrato a Modificar       :';
         echo '<select name ="Mod">';
         while($row1 = mysql_fetch_array($result2))
         {
           echo '<option>'.$row1['numero_contrato'].'</option>\n';
         }
         echo '</select>';
         echo '<li>'.'Tipo Movimiento a Modificar       :';
         echo '<select name ="Mod1">';
         while($row2 = mysql_fetch_array($result3))
         {
           echo '<option>'.$row2['tipo_movimiento'].'</option>\n';
         }
         echo '</select>';
         echo '<center>';
         echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =80%>';
         echo '<th align = center colspan = 2>'.'DATOS ACTUALES';
         echo '<th align = center colspan = 3>'.'DATOS MODIFICADOS';
         echo '<tr>';

         echo '<TD align = center>'.'Fecha Movimiento:';
         echo '<TD align = center>'.$row['fecha_movimiento'];
         echo '<TD align = center>'.'<input  type="text" name="Fecha_mov" size="20" >';
         echo '<tr>';
         echo '<TD align = center>'.'Procedencia:';
         echo '<TD align = center>'.$row['procedencia'];
         echo '<TD align = center>'.'<input  type="text" name="Procedencia" size="20" >';
         echo '<tr>';
         echo '<TD align = center>'.'Destino:';
         echo '<TD align = center>'.$row['destino'];
         echo '<TD align = center>'.'<input  type="text" name="Destino" size="20" >';
         echo '<tr>';
         echo '<TD align = center>'.'Rut Autoriza:';
         echo '<TD align = center>'.$row['rut_autoriza'];
         echo '<TD align = center>'.'<input  type="text" name="Rut" size="8" maxlenght="8">'.'-'.'<input  type="text" name="Dv" size="1" maxlenght="1" >';
         echo '<tr>';
         echo '<TD align = center>'.'Centro Costo:';
         echo '<TD align = center>'.$row['centro_costo'];
         echo '<TD align = center>'.'<input  type="text" name="CC" size="20" >';
         echo '<tr>';
         echo '<TD align = center>'.'Guia Despacho:';
         echo '<TD align = center>'.$row['guia_despacho'];
         echo '<TD align = center>'.'<input  type="text" name="Guia" size="20" >';
         echo '<tr>';
         echo '<TD align = center>'.'Fecha Guia:';
         echo '<TD align = center>'.$row['fecha_guia'];
         echo '<TD align = center>'.'<input  type="text" name="Fecha_guia" size="20" >';
         echo '<tr>';
         echo '<TD align = center>'.'Observacion:';
         echo '<TD align = center>'.$row['observacion'];
         echo '<TD align = center>'.'<input  type="text" name="Observacion" size="20" >';
         echo '</TABLE>';
         echo '<br>'.'<br>'.'<input type="Submit" name="enviar" value="Modificar">';
         echo '</center>';
      }
    }
?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/search_movimientos_bienes.html">ATRAS</A></H2>
</body>
</html>
