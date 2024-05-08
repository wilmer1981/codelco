<html>
  <head><!-- Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.-->

<body background="../imagenes/fondoventanas.gif">
 <?php
    //echo''.$opcion.'-<br>';
    echo'<input type="hidden"  name="ingreso" value='.$opcion.'>';
    include("../conex.phtml");
    $link=conectarse();
   //CONECTANDO A BASE DATO

    $esp=0;
    if ($Codigo == "")
    {
        $esp=1;
    }
    if ($Descripcion == "")
    {
        $esp=1;
    }
    // VERIFICACION DE CAMPO UNICO
    $sql="select * from ley where Codigo_Ley = '$Codigo'";
    $result=mysql_query($sql);
    if($row = mysql_fetch_array($result))
    {
        $esp=1;
    }

    if ($esp == 0)
    {
         // ALMACENANDO DATOS EN TABLA LEY
        $sql="INSERT INTO ley(Codigo_Ley,Descripcion) VALUES('$Codigo','$Descripcion')";
        $result=mysql_query($sql);
        echo "<center>"."¡INGRESO EXITOSO!"."</center>";
    }
    else
    {
        echo "<center>"."¡CODIGO REPETIDO!"."</center>";
    }

   echo'<center><a href="../pagina1.php?opcion='.$opcion.'">ATRAS</a></center>';
?>

<!--REGRESO A PAGINA1-->

</UL>
</form>

</body>
</html>
