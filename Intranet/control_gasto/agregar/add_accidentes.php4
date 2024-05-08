<html>
<head><!-- Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.-->
</Head>

<body background="imagenes/fondo.gif">

<?php
    //echo''.$opcion.'-<br>';
    echo'<input type="hidden"  name="ingreso" value='.$opcion.'>';
      include("../conex.phtml");
    $link=conectarse();

 /*    $link=mysql_connect("200.1.6.120","root");
       mysql_select_db("Control Gastos",$link);*/
     $esp=0;
    $sql="select * from accidente where Cod_Accidente = '$Codigo'";
    $result=mysql_query($sql);
    if($row = mysql_fetch_array($result))
      {
       $esp=1;
      }

      if ($esp == 0)
      {
        // ALMACENANDO DATOS
        $sql="INSERT INTO accidente(Cod_Accidente,Descripcion_Acc) VALUES('$Codigo','$Descripcion')";
        $result=mysql_query($sql);
       echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</h1>"."</center>";
      }
    else
    {
     echo "<center>"."<h3>"."¡ERROR CODIGO REPETIDO!"."</h3>"."</center>";
}

 //echo'<a href="../pagina1.html?opcion='.$opcion.'"><img src="imagenes/left.gif" alt="Volver" border=0></a>';
 echo'<a href="../pagina1.php?opcion='.$opcion.'">Atras</a>';
?>
</UL>
</body>
</html>
