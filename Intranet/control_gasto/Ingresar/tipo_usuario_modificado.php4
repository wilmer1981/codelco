<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);

    $ban=0;
    if($Descripcion == "")
    {

        $ban=1;
    }
    if($ban==1)
    {

          echo "<center>"."<h1>"."¡ERROR,INTENTELO NUEVAMENTE!"."</h1>"."</center>";
    }
    else
    {
           $sql="update tipo_usuarios set descripcion_tipo_usuario='$Descripcion' where tipo_usuario_enami='$parametro'";
           $result=mysql_query($sql);
           echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";
    }

?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_tipo_usuario.html">ATRAS</A></H2>


</body>
</html>

