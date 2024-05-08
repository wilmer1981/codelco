<html>
    <body background="../imagenes/fondoventanas.gif">
  <Meta Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com./>


<?php
  // FUNCION QUE CONECTA.
   include("../conex.phtml");
   $link=conectarse();

   mysql_query("delete  from reembolso where Num_Reembolso='$Num_Reembolso'",$link);
    mysql_query("delete  from stock where Num_Reembolso='$Num_Reembolso'",$link);
  echo'<center>';
  echo ' Eliminacion Exitosa <br>';
  echo'<a href="../pedir_fondo.php"> Atras</a>';
  ?>
  </center>
  </body>
  </html>
