<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $esp=0;

    if ($Nombre_enami == "")
    {
        $esp=1;
    }

    if ($Centro_costo == "")
    {
        $esp=1;
    }


    if ($esp == 0)
    {$sql="update usuarios  set nombre_enami='$Nombre_enami',tipo_usuario='$Tipo',centro_costo='$Centro_costo' where rut_enami='$Mod'";
    $result=mysql_query($sql);
    echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";

        }
    else
    {
        echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
    }

?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_usuarios.html">ATRAS</A></H2>

</UL>
</form>

</body>
</html>
