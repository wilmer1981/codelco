<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $esp=0;

    if ($Descripcion_item == "")
    {
        $esp=1;
    }


    if ($esp == 0)
    {   $sql="update item_gasto  set descripcion_item='$Descripcion_item' where item_gastos='$Mod'";
        $result=mysql_query($sql);
        echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";

        }
    else
    {
        echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
    }

?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_item_gasto.html">ATRAS</A></H2>

</UL>
</form>

</body>
</html>
