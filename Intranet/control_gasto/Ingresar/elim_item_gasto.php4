<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    if($opcion == Eliminar)
    {
       $sql="delete from item_gasto where item_gastos = '$Codigo'";
       $result=mysql_query($sql);
       echo '<center>'.'<h1>'.'¡ELIMINACION EXITOSA!'.'</h1>'.'</center>';
    }
    else
    {
       echo '<form method="POST" action="mod_item_gasto.php4">';
       echo '<li>'.'<center>'.'<h3>'.'Registro(s):'.'</center>'.'<br>'.'<h3>';
       $sql="select * from item_gasto where item_gastos like '$Codigo' order by item_gastos";
       $result1=mysql_query($sql);
       $result2=mysql_query($sql);
       $yatu=" ";

       if($row = mysql_fetch_array($result1))
       {  echo '<center>';
          echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =65%>';
          echo '<th align = center colspan = 2>'.'DATOS ACTUALES';
          echo '<th align = center colspan = 3>'.'DATOS MODIFICADOS';
          echo "<tr>";
          echo '<TD align = center>'.'Descripcion item:';
          echo '<TD align = center>'.$row['descripcion_item'];
          echo '<TD align = center>'.'<input  type="text" name="Descripcion_item" size="20"maxlength="20" >';
          echo '<tr>';
          echo '</table>';
          echo '<br>'.'<li>'.'Numero Item gasto a Modificar       :';
          echo '<select name ="Mod">';
          while($row1 = mysql_fetch_array($result2))
          {
             echo '<option>'.$row1['item_gastos'].'</option>\n';
          }
          echo '</select>';
          echo '<br>'.'<br>'.'<input type="Submit" name="enviar" value="Modificar">';
       }
    }
?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_item_gasto.html">ATRAS</A></H2>


</body>
</html>
