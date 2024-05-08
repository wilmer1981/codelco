<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);

    $ban=0;
    if($Sigla == "")
    {

        $ban=1;
    }else
    if($Nombre == "")
    {

         $ban=1;
    }else
    if($Apellido == "")
    {
         $ban=1;
    }else
    if($Direccion == "")
    {
         $ban=1;
    }else
    if($Telefono == "")
    {
         $ban=1;
    }
    if($ban != 0)
    {

          echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
    }
    else
    {
           $sql="select * from contratistas where rut_contratista = '$Rut_contratista'";
           $result=mysql_query($sql);
           $row = mysql_fetch_array($result);
           $sql="update contratistas set sigla_contratista='$Sigla',nombre_contratista='$Nombre',apellidos_contratista='$Apellido',direccion_contratista='$Direccion',numero_telefonico='$Telefono',numero_fax='$Fax',IMail='$Mail',codigo_esp_contratista='$Cod_especialidad',estado_contratista='$Estado_contratista' where rut_contratista='$parametro'";
           $result=mysql_query($sql);
           echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";
    }

?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_contratista.html">ATRAS</A></H2>


</body>
</html>

