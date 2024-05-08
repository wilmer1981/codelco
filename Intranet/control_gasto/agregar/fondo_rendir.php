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
  $Fecha_Fondo="$ano-$mes-$dia";
  $esp=0;
  $Estado=1;
    $consulta="select  max(Num_Movimiento) as mayor from stock";
        $result=mysql_query($consulta);

         while($row=mysql_fetch_array($result))
        {
        $Stock=$row[mayor];
        }

//***** COMPROBANDO CAMPO UNICO

  $sql="select * from fondos where Num_Fondo = '$Num_Fondo'";
  $result=mysql_query($sql);

    if ($row=mysql_fetch_array($result))
    {
        $esp=1;
        $Repetido=1;
    }

    if ($esp == 0)
    {
        //ALMACENANDO DATOS EN REEMBOLSO
     $sql="INSERT INTO fondos (Num_Fondo,Num_Movimiento,Fecha_Fondo,Rut,Costo,Motivo,Total,Estado) VALUES('$Num_Fondo','$Stock','$Fecha_Fondo','$Rut','$Costo','$Motivo','$Total','$Estado')";
        $result=mysql_query($sql);
       echo "<center>"."¡INGRESO EXITOSO!"."</center>";

    }
    else
    {
        echo "<center>"."¡CODIGO REPETIDO!"."</center>";
    }







 echo'<center><A href="..//Index.php">ATRAS</A></center>';
 
?>

 <!--REGRESANDO A PAGINA1-->
</body>
</html>
