  <html>
<body background="../imagenes/fondoventanas.gif">
  <Meta Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com./>


<?php
  // FUNCION QUE CONECTA.
   include("../conex.phtml");
   $link=conectarse();

   mysql_query("delete  from ex_funcionario where Rut_Funcionario= '$Rut'",$link);
   echo'<center>';
  echo 'Eliminacion Exitosa<br>';
?>
  </center>
   <br>
 <a href="../ex_funcionario.php"> Atras</a>
 </body>
 </html>
