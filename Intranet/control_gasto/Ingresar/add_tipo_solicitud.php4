<html>
<body background="imagenes\amarillo1.jpg">

<?php

    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $esp=0;
    if ($Tipo == "")
    {
        $esp=1;
    }
    if ($Descripcion == "")
    {
        $esp=1;
    }

    $Tipo=strtoupper($Tipo);

    $sql="select * from tipo_solicitud where tipo_solicitud = '$Tipo'";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);

    if($row['tipo_solicitud'] == $Tipo)
    {
        $esp=1;

    }

    if ($esp == 0)
    {
        $sql="INSERT INTO tipo_solicitud(tipo_solicitud,descripcion_solicitud) VALUES('$Tipo','$Descripcion')";
        $result=mysql_query($sql);
        echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</h1>"."</center>";
    }
    else
    {
        echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
    }



?>

<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/add_tipo_solicitud.html">ATRAS</A></H2>


</body>
</html>
