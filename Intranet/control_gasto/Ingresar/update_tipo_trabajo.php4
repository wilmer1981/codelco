<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);

    if($opcion == "Eliminar")
    {
      $sql="delete from tipo_trabajo where tipo_trabajo = '$Codigo'";
      $result=mysql_query($sql);
      echo '<center>'.'<h1>'.'¡ELIMINACION EXITOSA!'.'</h1>'.'</center>';
    }
    else
    {
      echo '<form method="POST" action="mod2_tipo_trabajo.php4">';

      $sql="select * from tipo_trabajo where tipo_trabajo like '$Codigo' ";
      $result=mysql_query($sql);
      $result2=mysql_query($sql);

      if($row = mysql_fetch_array($result))
      {
         echo '<li>'.'Tipo Trabajo a Modificar       :';
         echo '<select name ="Mod">';
         while($row1 = mysql_fetch_array($result2))
         {
           echo '<option>'.$row1['tipo_trabajo'].'</option>\n';
         }
         echo '</select>';
         echo '<center>';
         echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =80%>';
         echo '<th align = center colspan = 2>'.'DATOS ACTUALES';
         echo '<th align = center colspan = 3>'.'DATOS MODIFICADOS';
         echo '<tr>';
         echo '<TD align = center>'.'Descripcion : ' ;
         echo '<TD align = center>'.$row['descripcion_tipo'];
         echo '<TD align = center>'.'<input  type="text" name="Nombre" size="20" >';
         echo '</TABLE>';
         echo '<br>'.'<br>'.'<input type="Submit" name="enviar" value="Modificar">';
         echo '</center>';
      }
    }
?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/search_tipo_trabajo.html">ATRAS</A></H2>



</body>
</html>
