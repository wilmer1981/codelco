<html>
<body background="imagenes\amarillo1.jpg">
<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $ban=0;
        if ($Item_gasto == "")

        {$ban=1;}
        
        if ($Descripcion_item == "")

        {$ban=1;}

         if ($ban != 0)
     { echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
     }
     else

     { $sql="Insert into ITEM_GASTO (item_gastos , descripcion_item) Values('$Item_gasto','$Descripcion_item')";
     $result=mysql_query($sql);
     echo "<center>"."<h1>"."¡REGISTRO EXITOSO!"."</h1>"."</center>";
     }

?>

<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/item_gastos.html">ATRAS</A></H2>

</body>
</html>

