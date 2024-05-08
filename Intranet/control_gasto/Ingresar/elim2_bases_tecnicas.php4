<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    if($opcion == Eliminar)
    {
       $sql="delete from bases_tecnicas where numero_bt = '$Codigo'";
       $result=mysql_query($sql);
       echo '<center>'.'<h1>'.'¡ELIMINACION EXITOSA!'.'</h1>'.'</center>';
    }
    else
    {
       echo '<form method="POST" action="mod2_bases_tecnicas.php4">';
       $sql="select * from bases_tecnicas where numero_bt like '$Codigo' order by numero_bt";
       $result1=mysql_query($sql);
       $result2=mysql_query($sql);
       $yatu=" ";

       if($row = mysql_fetch_array($result1))
       {
          echo '<li>'.'Numero Base Tecnica a Modificar       :';
          echo '<select name ="Mod">';
          while($row1 = mysql_fetch_array($result2))
          {
             echo '<option>'.$row1['numero_bt'].'</option>\n';
          }
          echo '</select>';
          echo '<center>';
          echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =65%>';
          echo '<th align = center colspan = 2>'.'Registro';
          echo '<tr>';
          echo '<TD align = center>'.'Descripcion : ';
          echo '<TD align = center>'.$row['descripcion_bt'];
          echo '<TD align = center>'.'<input  type="text" name="Nombre" size="20" maxlength="20">';
          echo '<tr>';
          echo '<TD align = center>'.'Fecha Creacion : ';
          echo '<TD align = center>'.$row['fecha_creacion'];
          echo '<TD align = center>'.'<input  type="text" name="Fecha" size="10" maxlength="10" >';
          echo '</center>';
          echo '</TABLE>';
          echo '<tr>';

          echo '<br>'.'<br>'.'<input type="Submit" name="enviar" value="Modificar">';
       }
    }
?>

<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/search_bases_tecnicas.html">ATRAS</A></H2>


</body>
</html>
