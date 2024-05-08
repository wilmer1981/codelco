<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
    <head>
    <meta Autor:Alejandro Arellano
          julio 2002.
          EMAIL:Ajarella@latinmail.com./>

      <title>ALMACENANDO REEMBOLSO Y STOCK!</title>
    </head>
<body background="../imagenes\fondoventanas.gif">
<?php

     // CAPTURANDO TIPO FUNCIONARIO

 echo'<input type="hidden"  name="opcion" value='.$ingreso.'>';

     //CONECTANDO CON BASE DE DATOS
  include("../conex.phtml");
 $link=conectarse();


       //Convirtirndo Fecha para almacenar
  $fecha1=$Fecha_Transaccion;
  $dia=Substr($fecha1,0,2);
  $mes=Substr($fecha1,3,2);
  $ano=Substr($fecha1,6,4);
  $Fecha_Transaccion="$ano-$mes-$dia";
  $esp=0;
  $Estado=1;

   /* $result3=mysql_query("SELECT (Total) as sum  FROM fondos   WHERE Estado='1'",$link);
     while($row=mysql_fetch_array($result))
     {/**/
        $consulta="select  max(Num_Movimiento) as mayor from stock";
        $result=mysql_query($consulta);

         while($row=mysql_fetch_array($result))
        {
        $Stock=$row[mayor];
        }


                          // COMPROBANDO CAMPO UNICO
  $sql="select * from reembolso where Num_Reembolso = '$Num_Reembolso'";
  $result=mysql_query($sql);

    if ($row=mysql_fetch_array($result))
    {
        $esp=1;
        $Repetido=1;
    }

    if ($esp == 0)
    {
        //ALMACENANDO DATOS EN REEMBOLSO
        $sql="INSERT INTO reembolso (Num_Reembolso,Num_Movimiento,Total,Motivo,Rut,Fecha_Transaccion,Estado) VALUES('$Num_Reembolso','$Stock','$Total','$Motivo','$Rut','$Fecha_Transaccion','$Estado')";
        $result=mysql_query($sql);
       echo "<center>"."¡INGRESO EXITOSO!"."</center>";

    }
    else
    {
        echo "<center>"."¡CODIGO REPETIDO!"."</center>";
    }


?>



<?php
      //almacenando datos de stock
    $Tipo_Movimiento=02;
    $Total=(($Total)*(-1));
    $esp=0;

        //$Total=$conv
  if ($Repetido!=1)
    {
    $sql="select  max(Num_Movimiento) as mayor from stock";
    $result=mysql_query($sql);
      while($row=mysql_fetch_array($result))
      {
       $Numero=$row[mayor];// + 1;
      }


  $sql="select * from stock_reembolso where Num_Reembolso = '$Num_Reembolso' and Num_Movimiento='$Numero'";
  $result=mysql_query($sql);

    if ($row=mysql_fetch_array($result))
    {
        $esp=1;

    }

    if ($esp == 0)
    {
        //ALMACENANDO DATOS EN REEMBOLSO

         $sql="INSERT INTO stock_reembolso (Num_Movimiento,Num_Reembolso,Total) VALUES('$Numero','$Num_Reembolso','$Total')";
        $result=mysql_query($sql);


    }

}


 echo'<center><A href="..//Index.php">ATRAS</A></center>';
?>

 <!--REGRESANDO A PAGINA1-->
</body>
</html>
