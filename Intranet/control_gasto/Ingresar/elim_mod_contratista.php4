<html>
<body background="imagenes\amarillo1.jpg">

<?php

    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    if($opcion == modificar)
    {
                  echo '<form method="POST" action="contratista_eliminado.php4">';
                  echo '<center>'.'<H1>'.'MODIFICAR CONTRATISTA'.'</H1>'.'</center>';
                  $sql="SELECT * FROM contratistas where rut_contratista = '$parametro'";
                  $result=mysql_query($sql);
                  $row=mysql_fetch_array($result);
                  $sql="select codigo_especialidad,nombre_especialidad from especialidades";
                  $result1=mysql_query($sql);
                  $sql="select codigo_estado,descripcion_estado from estado";
                  $result2=mysql_query($sql);
                  echo "Registro a Modificar:";
                  echo '<select name ="parametro">';
                  echo '<option>'.$row['rut_contratista'].'</option>'.'\n';
                  echo "<tr>";
                  echo '<center>';
                  echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =80%>';
                  echo '<th align = center colspan = 2>'.'DATOS ACTUALES';
                  echo '<th align = center colspan = 3>'.'DATOS MODIFICADOS';
                  echo "<tr>";
                  echo '<TD align = center>'.'Sigla Contratista';
                  echo '<TD align = center>'.$row['sigla_contratista'];
                  echo '<TD align = center>'.'<input  type="text" name="Sigla" size="8" maxlength="8">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Nombre Contratista';
                  echo '<TD align = center>'.$row['nombre_contratista'];
                  echo '<TD align = center>'.'<input  type="text" name="Nombre" size="20" maxlength="20">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Apellidos Contratista';
                  echo '<TD align = center>'.$row['apellidos_contratista'];
                  echo '<TD align = center>'.'<input  type="text" name="Apellido" size="20" maxlength="20">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Direccion Contratista';
                  echo '<TD align = center>'.$row['direccion_contratista'];
                  echo '<TD align = center>'.'<input  type="text" name="Direccion" size="40" maxlength="40">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Numero Telefonico';
                  echo '<TD align = center>'.$row['numero_telefonico'];
                  echo '<TD align = center>'.'<input  type="text" name="Telefono" size="10" maxlength="10">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Numero de Fax';
                  echo '<TD align = center>'.$row['numero_fax'];
                  echo '<TD align = center>'.'<input  type="text" name="Fax" size="10" maxlength="10">';
                  echo '<tr>';
                  echo '<TD align = center>'.'E-mail';
                  echo '<TD align = center>'.$row['IMail'];
                  echo '<TD align = center>'.'<input  type="text" name="Mail" size="20" maxlength="20">';
                  echo '<tr>';
                  echo '<TD align = center>'.'Codigo Especialidad';
                  echo '<TD align = center>'.$row['codigo_esp_contratista'];
                  echo '<TD align = center>'.'<select name ="Cod_especialidad">';
                  while($row1 = mysql_fetch_array($result1))
                  {
                             echo '<option>'.$row1['codigo_especialidad'].'</option>\n';
                  }
                  echo '</select>';
                  echo '<tr>';
                  echo '<TD align = center>'.'Estado Contratista';
                  echo '<TD align = center>'.$row['estado_contratista'];
                  echo '<TD align = center>'.'<select name ="Estado_contratista">';
                  while($row2 = mysql_fetch_array($result2))
                  {
                             echo '<option>'.$row2['codigo_estado'].'</option>\n';
                  }
                  echo '</select>';
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
                  echo '<H2>'.'<A href="http://200.1.6.47/contrato%20y%20maestranza/bus_contratista.html">'.'come back'.'</A>'.'</H2>';
    }else
    {
        echo '<center>'.'<H1>'.'ELIJA UNA OPCION'.'</H1>'.'</center>';
    }
?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_contratista.html">ATRAS</A></H2>
</body>
</html>

