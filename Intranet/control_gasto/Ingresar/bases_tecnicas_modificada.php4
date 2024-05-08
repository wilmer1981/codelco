<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $esp=0;

    if ($Nombre == "")
    {
        $esp=1;
    }


    if ($esp == 0)
    {$sql="update bases_tecnicas  set descripcion_bt='$Nombre',fecha_creacion='Fecha' where numero_bt='$Mod'";
    $result=mysql_query($sql);
    echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";

        }
    else
    {
        echo "<center>"."<h1>"."¡ERROR,INGRESAR TODOS LOS CAMPOS!"."</h1>"."</center>";
    }

?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/op_buscar.html">come back Buscar</A></H2>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/operaciones.html">come back Operaciones</A></H2>

</UL>
</form>

</body>
</html>
