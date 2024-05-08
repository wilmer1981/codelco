  <html>
    <body background="../imagenes/fondoventanas.gif">
   <Meta Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com./>


<?php
  // FUNCION QUE CONECTA.
   include("../conex.phtml");
   $link=conectarse();
   mysql_query("DELETE  FROM proveedor where Rut_Proveedor='$Proveedor'",$link);

  echo'<center>';
  echo 'Eliminacion Exitosa<br>';
  echo'<br>';
  echo'<input type="hidden"  name="ingreso" value='.$opcion.'>';
  echo'<a href="../pagina1.php?opcion='.$ingreso.'">ATRAS</a>'
?>
  </center>
   </body>
  </html>
