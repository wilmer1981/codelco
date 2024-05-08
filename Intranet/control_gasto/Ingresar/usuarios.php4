<html>
<body background="imagenes\amarillo1.jpg">
<?php
$link=mysql_connect("200.1.6.254","root");
mysql_select_db("bd_contrato_maestranza", $link);
$largo=strlen($Rut);
$i=0;$ban=0;

while($i<$largo)
{
    if(!($Rut[$i] <= ':' && $Rut[$i] >= '/'))
    {
        $ban=1;
        echo '1';
    }
     $i=$i+1;

       if(!($Dv <= ':' && $Dv >= '/') && (($Dv != 'k')&&($Dv != 'K')))
            {
                $ban=1;
                echo '2';
            }
}
if ($Nombre_enami == "")
   {
       $ban=1;
       echo '3';
   }


if ($Centro_costo == "")
   {
       $ban=1;
       echo '4';
   }

if ($ban == 0)
    {
    $g='-';
    $Rut=$Rut.$g.$Dv;
    $sql="INSERT INTO usuarios(rut_enami,nombre_enami,tipo_usuario,centro_costo) values ('$Rut','$Nombre_enami','$Tipo','$Centro_costo')";
    $result=mysql_query($sql);
    echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</center>"."</h1>";
    }

 else{
   echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</center>"."</h1>";

   }

?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/usuarios.html">ATRAS</A></H2>

</body>
</html>
