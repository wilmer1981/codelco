<html>
<body background="imagenes\amarillo1.jpg">

<?php

if($Tipo == "" || $Descripcion == "")
{
    echo '<CENTER>'.'<H1>'.'ERROR DE INGRESO!'.'</H1>'.'</CENTER>';
}else
{
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);


    $sql="select * from tipo_contrato where tipo_contrato = '$Tipo'";
    $result=mysql_query($sql);
    if($row = mysql_fetch_array($result))
    {
              echo "<center>"."<h1>"."¡REGISTRO REPETIDO!"."</h1>"."</center>";
    }else
    {
              $sql="insert into tipo_contrato (tipo_contrato,descripcion_tipo) values('$Tipo','$Descripcion')";
              $result=mysql_query($sql);
              echo '<CENTER>'.'<H1>'.'INGRESO EXITOSO!'.'</H1>'.'</CENTER>';
    }
}





?>

<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/add_tipo_contrato.html">ATRAS</A></H2>
</UL>
</form>

</body>
</html>
