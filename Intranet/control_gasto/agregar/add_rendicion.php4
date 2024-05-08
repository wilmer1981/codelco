<html>
 <head><!-- Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.-->


       <title>ALMACENANDO RENDICION</title>
</head>

<html>

<body background="../imagenes\fondoventanas.gif">
 <?php
  //   echo'<br>hola'.$ingreso.'-<br>';
 echo'<input type="hidden"  name="opcion" value='.$ingreso.'>';

     //conversion de fecha
   $fecha1=$Fecha_Rendicion;
   $dia=Substr($fecha1,0,2);
   $mes=Substr($fecha1,3,2);
   $ano=Substr($fecha1,6,4);
   $Fecha_Rendicion="$ano-$mes-$dia";


           // CONECTANDO BASE DATO
    include("../conex.phtml");
    $link=conectarse();

    $esp=0;
       // VERIFICACION CAMPO UNICO
    $result=mysql_query("select * from rendicion where Num_Rendicion = '$Num_Rendicion'",$link);


    if ($row=mysql_fetch_array($result))
    {
        $esp=1;
    }

    if ($esp == 0)
    {

        //ALMACENANDO INFORMACION
        $sql="INSERT INTO rendicion (Num_Rendicion,Fecha_Rendicion,Total_Rendicion) VALUES('$Num_Rendicion','$Fecha_Rendicion','$Total')";
        $result=mysql_query($sql);
        echo "<center>"."¡INGRESO EXITOSO!"."</center>";

    }
    else
    {
        echo "<center>"."¡Numero Rendicion Repetido!"."</center>";
    }
 ?>


  <?
   // CONECTANDO CON BASE DATO
    $sql="select * from gastos WHERE Tipo_Documento='$ingreso'";
     //
    $result=mysql_query($sql);
    while ($row=mysql_fetch_array($result))
    {
      if ($row[Estado]=='1')
        {
//           and ($row[Tipo_Documento]==$ingreso)
                $insertar="INSERT INTO rendicion_gasto (Num_Gasto,Num_Rendicion) VALUES('".$row[Num_Gasto]."','".$Num_Rendicion."')";
            mysql_query($insertar);
        }
    }

       // CAMBIANDO EL VALOR DEL CAMPO ESTADO

     $sql="select * from gastos where Tipo_Documento='$ingreso'";
     //
    $result=mysql_query($sql);
    while ($row=mysql_fetch_array($result))
    {
      if ($row[Estado]=='1')
      {
   $actualizar="Update gastos set Estado='0' where Estado='1' AND Tipo_Documento='$ingreso'";
    mysql_query($actualizar);
     }
   }

  echo'<center><A href="../rendicion.php?opcion='.$ingreso.'">ATRAS</A></center>';
?>

<!--RERESANDO A PAGINA PEDIR FONDO-->

<?php
 /*   $consulta="select * from rendicion_gasto";
    $result=mysql_query($consulta);
     echo "<table border=1>";

     while ($row=mysql_fetch_array($result))
    {
        echo "<tr>\n";
        echo "<td>CHAO".$row[Num_Rendicion]." | ".$row[Num_Gasto]."</td>\n";
        echo "</tr>\n";
    }
    echo "</table>\n";

switch($ingreso)
      {
         case ($ingreso=="Boleta"):
         {
         $sql = "Update gastos set Estado='0' where Estado='1'";

         }
         break;
         case ($ingreso="Factura"):
         {
         $sql = "Update gastos set Estado='0' where Estado='1'";

         }
         break;
   }        */




          ?>


</body>
</html>
