<html>

<body background="../imagenes\fondoventanas.gif">
 <?php
  $Cerrada=1;

  /* include("fechas.php");
   $Fecha_Transaccion=fecha_ingreso($Fecha_Transaccion );
    */

   $fecha1=$Fecha_Transaccion;
   $dia=Substr($fecha1,0,2);
   $mes=Substr($fecha1,3,2);
   $ano=Substr($fecha1,6,4);
  $Fecha_Transaccion="$ano-$mes-$dia";
  //**********************************

  $esp=0;
  $Estado=1;
  $Stock=0;
  /* include("../conex.phtml");
    $link=conectarse(); */
  $link=mysql_connect("200.1.6.47","user_admgasto","12651265");
  mysql_select_db("Control_gastos",$link);

  $consulta="select * from stock where Num_Movimiento='$Num_Movimiento'";
  $result=mysql_query($consulta);
  if($row = mysql_fetch_array($result))
    {
       $esp=1;
      }

      if ($esp == 0)
      {
      $sql="INSERT INTO stock(Num_Movimiento,Stock,Total,Fecha_Transaccion,Cerrada,Estado) VALUES('$Num_Movimiento','$Stock','$Total','$Fecha_Transaccion','$Cerrada','$Estado')";
     $result=mysql_query($sql);
     echo "<center>"."¡INGRESO EXITOSO!"."</center>";
     }
  else
    {
     echo "<center>"."¡ERROR CODIGO REPETIDO!"."</center>";

   }

echo '<center><A href="../index.php?">ATRAS</A></center>';

?>



</UL>
</form>

</body>
</html>
