<html>
<body background="imagenes\amarillo1.jpg">
<?php
$link=mysql_connect("200.1.6.254","root");
mysql_select_db("bd_contrato_maestranza",$link);
$ban=0;

if($numero_bt == "" )
{

    $ban=1;
}
   
if($descripcion_bt == "" )
{

    $ban=1;
}
    
if($fecha_creacion == "" )
{
    $ban=1;
}
if ($ban == 0)
{
    $sql="INSERT INTO bases_tecnicas(numero_bt,descripcion_bt,fecha_creacion) VALUES('$numero_bt','$descripcion_bt','$fecha_creacion')";
    $result=mysql_query($sql);
     echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</h1>"."</center>";
} else
{
      echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";

}
?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/add_bases_tecnicas.html">ATRAS</A></H2>
</body>
</html>

