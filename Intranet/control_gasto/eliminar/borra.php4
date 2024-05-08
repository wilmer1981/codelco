 <html>
 <body background="../imagenes/fondoventanas.gif">
 <!-- Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.-->


<?php
  // FUNCION QUE CONECTA.
   include("../conex.phtml");
   $link=conectarse();

   mysql_query("delete  from reembolso where Num_Reembolso= $Num_Reembolso",$link);
//   mysql_query("delete  from documento where Num_Gasto= $Num_Gasto",$link);
// mysql_query("delete  from accidente where Cod_Accidente= $Cod_Accidente",$link);

 echo'<input type="hidden"  name="opcion" value='.$ingreso.'>';
  echo'<center>';
  echo " Eliminacion Exitosa";


echo'<br><a href="../pedir_fondo.php"> Atras</a>';

 ?>
 </center>
 <!----></body>
 </html>
