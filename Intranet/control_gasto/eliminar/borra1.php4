<html>
<body background="../imagenes/fondoventanas.gif">

   <!-- Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.-->

<?php
    include("../conex.phtml");
   $link=conectarse();
   mysql_query("delete from accidente where Cod_Accidente=$Accidente",$link);
  echo'<center>';
  echo ' Eliminacion Exitosa <br>';

  //echo'<input type="hidden"  name="opcion" value='.$ingreso.'>';
  echo'<input type="hidden"  name="ingreso" value='.$opcion.'>';
  echo'<a href="../pagina1.php?opcion='.$ingreso.'">ATRAS</a>';
?>
</center>
</body>
</html>
