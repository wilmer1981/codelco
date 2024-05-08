<html>
<body background="imagenes\amarillo1.jpg">

<?php
$link=mysql_connect("200.1.6.254","root");
mysql_select_db("bd_contrato_maestranza",$link);
if($opcion == eliminar)
{
    echo '<center>'.'<H1>'.'EL REGISTRO SE HA ELIMINADO'.'</H1>'.'</center>';
    $sql="delete from tipo_usuarios where tipo_usuario_enami = '$parametro'";
    $result=mysql_query($sql);
}else
if($opcion == modificar)
{
    echo '<form method="POST" action="tipo_usuario_modificado.php4">';
    echo '<center>'.'<H1>'.'MODIFICAR TIPO USUARIOS'.'</H1>'.'</center>';
    $sql="SELECT * FROM tipo_usuarios where tipo_usuario_enami = '$parametro'";
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result);
    echo "Registro a Modificar:";
    echo '<select name ="parametro">';
    echo '<option>'.$row['tipo_usuario_enami'].'</option>'.'\n';
    echo '<center>';
    echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =80%>';
    echo '<th align = center colspan = 2>'.'DATOS ACTUALES';
    echo '<th align = center colspan = 3>'.'DATOS MODIFICADOS';
    echo '<tr>';
    echo '<TD align = center>'.'Descripcion Tipo Usuario';
    echo '<TD align = center>'.$row['descripcion_tipo_usuario'];
    echo '<TD align = center>'.'<textarea name = "Descripcion" rows=5 cols=20></textarea>';
    echo '<tr>';
    echo '</TABLE>';
    echo '<br><input type="Submit" name="enviar" value="Modificar">';
    echo '</form>';
    echo '</center>';
}else
{
    echo '<CENTER>'.'<H1>'.'DEBE ELEJIR UNA OPCION'.'</H1>'.'</CENTER>';
}
?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_tipo_usuario.html">ATRAS</A></H2>
</body>
</html>

