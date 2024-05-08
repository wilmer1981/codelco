 </html>
 <body background="../imagenes/fondoventanas.gif">
  <Meta Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com./>


<?php

  // FUNCION QUE CONECTA.
   include("../conex.phtml");
   $link=conectarse();

   mysql_query("delete  from gastos where Num_Gasto= $Num_Gasto",$link);
   mysql_query("delete  from documento where Num_Gasto= $Num_Gasto",$link);
// mysql_query("delete  from accidente where Cod_Accidente= $Cod_Accidente",$link);

 echo'<input type="hidden"  name="opcion" value='.$ingreso.'>';
  ECHO'<center>';
  echo 'Eliminacion Exitosa<br>';
  echo'<a href="../rendicion.php?opcion='.$opcion.'"> Atras</a>';
?>
 </center>
 </body>
 </html>

