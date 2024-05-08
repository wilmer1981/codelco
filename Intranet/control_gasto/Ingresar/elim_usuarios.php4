<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    if($opcion == Eliminar)
    {
       $sql="delete from usuarios where rut_enami = '$Codigo'";
       $result=mysql_query($sql);
       echo '<center>'.'<h1>'.'¡ELIMINACION EXITOSA!'.'</h1>'.'</center>';
    }
    else
    {
       echo '<form method="POST" action="mod_usuarios.php4">';
       $sql="select * from usuarios where rut_enami like '$Codigo' order by rut_enami";
       $sql1="select tipo_usuario_enami from tipo_usuarios";
       $result1=mysql_query($sql);
       $result2=mysql_query($sql);
       $result3=mysql_query($sql1);

       if($row = mysql_fetch_array($result1))
       {
          echo '<li>'.'Numero Rut Enami a Modificar       :';
          echo '<select name ="Mod">';
          while($row1 = mysql_fetch_array($result2))
          {
             echo '<option>'.$row1['rut_enami'].'</option>\n';
          }
          echo '</select>';
          echo '<center>';
          echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =65%>';
          echo '<th align = center colspan = 2>'.'DATOS ACTUALES';
          echo '<th align = center colspan = 2>'.'DATOS A MODIFICAR';
          echo '<tr>';
          echo '<TD align = center>'.'Nombre  : ';
          echo '<TD align = center>'.$row['nombre_enami'];
          echo '<TD align = center>'.'<input  type="text" name="Nombre_enami" size="20" maxlength="20">';
          echo '<tr>';
          echo '<TD align = center>'.'Tipo usuario : ';
          echo '<TD align = center>'.$row['tipo_usuario'];
          echo '<TD align = center>'.'<select name ="Tipo">';
          while($row3 = mysql_fetch_array($result3))
          {
                      echo '<option>'.$row3['tipo_usuario_enami'].'</option>\n';
          }
          echo '</select>';
          echo '<tr>';
          echo '<TD align = center>'.'Centro costo : ';
          echo '<TD align = center>'.$row['centro_costo'];
          echo '<TD align = center>'.'<input  type="text" name="Centro_costo" size="4" maxlength="4" >';
          echo '</center>';
          echo '</TABLE>';

          echo '<br>'.'<br>'.'<input type="Submit" name="enviar" value="Modificar">';
       }
    }
?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_usuarios.html">ATRAS</A></H2>


</body>
</html>
