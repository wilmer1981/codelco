<html>
  <head><!-- Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.-->
   </HEAD>

<body background="../imagenes\fondoventanas.gif">
<?php
    include("../conex.phtml");
    $link=conectarse();
    $result=mysql_query("SELECT * FROM proveedor where Rut_Proveedor = '$Rut'",$link);
    $esp=0;
    if($row = mysql_fetch_array($result))
    {
        $esp=1;
    }

    if ($esp == 0)
    {
        //ALMACENANDO DATOS DEL PROVEEDOR
        $sql="INSERT INTO Proveedor(Rut_Proveedor,Descripcion) VALUES('$Rut','$Descripcion')";
        $result=mysql_query($sql);
        echo "<center>"."¡INGRESO EXITOSO!"."</center>";
    }
    else
    {
        echo "<center>"."¡RUT PROVEEDOR YA EXISTE!"."</center>";
    }
echo'<center><a href="../pagina1.php?opcion='.$opcion.'">ATRAS</a></center>';
?>

</UL>
</form>

</body>
</html>
