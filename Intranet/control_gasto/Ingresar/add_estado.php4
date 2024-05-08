<html>
<body background="imagenes\amarillo1.jpg">

<?php

    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $esp=0;
    if ($Codigo == "")
    {
        $esp=1;
    }
    if ($Nombre == "")
    {
        $esp=1;
    }

    $sql="select * from estado where codigo_estado = '$Codigo'";
    $result=mysql_query($sql);
    $Codigo=strtoupper($Codigo);
    if( $row = mysql_fetch_array($result))
    {
        $esp=1;

    }

    if ($esp == 0)
    {
        $sql="INSERT INTO estado(codigo_estado,descripcion_estado) VALUES('$Codigo','$Nombre')";
        $result=mysql_query($sql);
        echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</h1>"."</center>";
    }
    else
    {
        echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
    }



?>

<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/add_estado.html">ATRAS</A></H2>


</body>
</html>

