 <html>
  <body background="../imagenes/fondoventanas.gif">
   <Meta Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com./>


<?php
  // FUNCION QUE CONECTA.
   include("../conex.phtml");
   $link=conectarse();
   mysql_query("delete from ley where Codigo_Ley=$Ley",$link);
   echo'<center>';
  echo ' Eliminacion Exitosa<br>';
   echo'<input type="hidden"  name="ingreso" value='.$opcion.'>';
  echo'<a href="../pagina1.php?opcion='.$ingreso.'">atras</a>'
?>
 </center>
 </body>
 </html>
