<html>
 <head><!-- Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.-->


       <title>ALMACENANDO FONDO</title>
</head>
<body background="../imagenes\fondoventanas.gif">

<html>
<body background="imagenes\amarillo1.jpg">

 <?php
    // CONECTANDO BASE DATO

    include("../conex.phtml");
    $link=conectarse();
    $esp=0;
  // VERIFICACION CAMPO UNICO
    $result=mysql_query("select * from Memo Reembolso_Memo where Num_Memo = '$Num_Memo'",$link);
    echo'<input type="hidden"  name="fondos" value="'.$fondo.'">';
    if ($row=mysql_fetch_array($result))
    {
        $esp=1;
    }

    if ($esp == 0)
    {
        //ALMACENANDO INFORMACION
        $sql="INSERT INTO memo (Num_Memo,Fecha_Memo,Total_Memo,Fondos_Rendido) VALUES('$Num_Memo','$Fecha_Memo','$Total_Memo','$fondo')";
        $result=mysql_query($sql);
       echo "<center>"."¡INGRESO EXITOSO!"."</center>";

    }
    else
    {
        echo "<center>"."¡ERROR DE INGRESO!"."</center>";
    }
 ?>


  <?

    $sql="select * from reembolso";
    $result=mysql_query($sql);
   // $result3=mysql_query("Select
    while ($row=mysql_fetch_array($result))
    {
      if ($row[Estado]=='1')
        {
            $insertar="INSERT INTO reembolso_memo (Num_Reembolso,Num_Memo) VALUES('".$row[Num_Reembolso]."','".$Num_Memo."')";
            mysql_query($insertar);
        }
    }
    // CAMBIANDO EL VALOR DEL CAMPO ESTADO
    $actualizar="Update reembolso set Estado='0' where Estado='1'";
    mysql_query($actualizar);

     $actualizar2="Update fondos set Estado='0' where Estado='1'";
    mysql_query($actualizar2);
?>
<!--RERESANDO A PAGINA PEDIR FONDO-->
 <center><A href="../index.php">ATRAS</A></center>
</body>
</html>
