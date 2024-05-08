<!doctype html public "-//W3C//DTD HTML 4.0 //EN"> 
<html>
<head> <!--Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.-->

       <title>Almacenando informacion pacientes</title>
</head>
<body background="../imagenes\fondoventanas.gif">

<?php
        //CONEXION CON BASE DATOS
     include("../conex.phtml");
 $link=conectarse();

   /* $link=mysql_connect("200.1.6.120","root");
    mysql_select_db("Control Gastos",$link);*/
    
    echo'<input type="hidden"  name="opcion" value='.$ingreso.'>';
    $esp=0;
    $Estado=1;
     //Convirtirndo Fecha Accidente
     $fecha=$Fecha_Acc;
     $dia=substr($fecha,0,2);
     $mes=substr($fecha,3,2);
     $ano=substr($fecha,6,4);
     $Fecha_Acc="$ano-$mes-$dia";

         // Convirtiendo Fecha Documento
     $fecha=$Fecha_Doc;
     $dia=substr($fecha,0,2);
     $mes=substr($fecha,3,2);
     $ano=substr($fecha,6,4);
     $Fecha_Doc1="$ano-$mes-$dia";
    // echo'hola'.$Fecha_Doc1.'<br>';
                 // VERIFICACION DE CAMPO UNICO
    $sql="select * from gastos where Num_Gasto = '$Num_Gasto'";
    $result=mysql_query($sql);
   if ($row=mysql_fetch_array($result))
     {
        $esp=1;

      }

    if ($esp == 0)
    {
          // ALMACENANDO INFORMACION DE PACIENTE EN GASTO
     if($ingreso==opcion1)
     {
      $sql="INSERT INTO gastos (Num_Gasto,Rut,Rut_Proveedor,Num_Documento,Tipo_Documento,Codigo_Ley,Fecha_Accidente,Cod_Accidente,Estado) VALUES('$Num_Gasto','$Rut','$Proveedor','$Numero_Doc','$Tipo_Documento','$Ley','$Fecha_Acc','$Accidente','$Estado')";
     $result=mysql_query($sql);

     $sql="INSERT INTO documento (Num_Gasto,Tipo_Documento,Num_Documento,Fecha_Documento,Rut_Proveedor,Valor_Neto,Valor_Iva,Total) VALUES('$Num_Gasto','$Tipo_Documento','$Numero_Doc','$Fecha_Doc1','$Proveedor','$Neto','$Iva','$Total')";
        $result=mysql_query($sql);
     }
     if($ingreso==opcion2)
     {
     $sql="INSERT INTO gastos    (Num_Gasto,Rut,Rut_Proveedor,Num_Documento,Tipo_Documento,Codigo_Ley,Fecha_Accidente,Cod_Accidente,Estado) VALUES('$Num_Gasto','$Rut_Ex','$Proveedor','$Numero_Doc','$Tipo_Documento','$Ley','$Fecha_Acc','$Accidente','$Estado')";
     $result=mysql_query($sql);
     $sql="INSERT INTO documento (Num_Gasto,Tipo_Documento,Num_Documento,Fecha_Documento,Rut_Proveedor,Valor_Neto,Valor_Iva,Total) VALUES('$Num_Gasto','$Tipo_Documento','$Numero_Doc','$Fecha_Doc1','$Proveedor','$Neto','$Iva','$Total')";
        $result=mysql_query($sql);
     }
        echo "<center>"."¡INGRESO EXITOSO!"."</center>";
    }
    else
    {
        echo "<center>"."¡Numero Gasto Repetido!"."</center>";
    }
?>

<?PHP
 echo'<input type="hidden"  name="opcion" value='.$ingreso.'>';
    // REGRESANDO A LA PAGINA

 ECHO '<center><H2><A href="../pagina1.php?opcion='.$ingreso.'">ATRAS</A></H2></center>';
?>
   </body>
   </html>
