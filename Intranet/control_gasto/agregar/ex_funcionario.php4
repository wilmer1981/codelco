<html>
  <head><!-- Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.-->
  </HEAD>



 <body background="../imagenes\fondoventanas.gif">
<?php
     $fecha=$Fecha_Ret;
  $dia=substr($fecha,0,2);
  $mes=substr($fecha,3,2);
  $ano=substr($fecha,6,4);
  $Fecha_Ret="$ano-$mes-$dia";
  
           // CONECTANDO CON EX-FUNCIONARIO


     include("../conex.phtml");
    $link=conectarse();
//    $result=mysql_query("SELECT * FROM proveedor where Rut_Proveedor = '$Rut'",$link);

    $sql="select * from ex_funcionario where Rut_Funcionario = '$Rut_Ex'";
    $result=mysql_query($sql);

    if ($row = mysql_fetch_array($result))
      {
       $esp=1;
      }

      if ($esp == 0)
       {
     $sql="INSERT INTO ex_funcionario (Rut_Funcionario,Nombre,Fecha_Retiro) VALUES ('$Rut_Ex','$Nombre','$Fecha_Retiro')";
     $result=mysql_query($sql);
     echo "<center>"."<h3>"."¡INGRESO EXITOSO!"."</h3>"."</center>";
     }
    else
    {
     echo "<center>"."<h3>"."¡RUT YA EXISTE!"."</h3>"."</center>";
}
?>

 <center>
<A href="../ex_funcionario.php">ATRAS</A>
 </center>
</UL>
</form>

</body>
</html>
