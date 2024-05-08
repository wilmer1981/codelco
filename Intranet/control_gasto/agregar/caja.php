<html>
 <head>
 <meta Autor:Alejandro Arellano
         julio 2002.
         EMAIL:Ajarella@latinmail.com.>


       <title>ALMACENANDO FONDO</title>
</head>
<body background="../imagenes\fondoventanas.gif">

<html>
<body background="imagenes\amarillo1.jpg">

<?php
include("../conex.phtml");
$link=conectarse();
$result=mysql_query("SELECT * FROM stock",$link);
$result1=mysql_query("SELECT Total FROM stock where Estado='1'",$link);
$result2=mysql_query("SELECT SUM(Total) as sum  FROM Reembolso WHERE Estado='1'",$link);
$result3=mysql_query("SELECT SUM(Total) as sum  FROM fondos   WHERE Estado='1'",$link);

  // CAMBIANDO EL VALOR DEL CAMPO ESTADO

 while($row=mysql_fetch_array($result))
     {
        $consulta="select  max(Num_Movimiento) as mayor from stock";
        $result=mysql_query($consulta);

         while($row=mysql_fetch_array($result))
        {
        $Numero_Stock=$row[mayor];
        }
     }

//**************suma de stock***********

   while($row1=mysql_fetch_array($result1))
  {
   $Suma=$row1[Total];
   }

 
//************ suma de reembolsos ****************

  while($row2=mysql_fetch_array($result2))
  {
   $Suma1=$row2[sum];
  }

//************** suma de fondos ****************

  while($row3=mysql_fetch_array($result3))
  {
   $Suma3=$row3[sum];
  }

    $Suma2=$Suma-($Suma1 + $Suma3) ;


 //mysql_close($link)
?>

<?
     //***************
   // $link=mysql_connect("127.0.0.1","root");
  // mysql_select_db("Control Gastos",$link);
     $sql="select * from stock";
     $result=mysql_query($sql);
    while ($row=mysql_fetch_array($result))
    {
      if ($row[Estado]=='1')
      {
   $actualizar="Update stock set Estado='0' where Estado='1' ";
    mysql_query($actualizar);

   $inserte="update stock set Stock='$Suma2' where Stock='0'";
    mysql_query($inserte);

    $actualizar1="Update stock set Cerrada='0' where Cerrada='1' ";
    mysql_query($actualizar1);
                }
   }

     echo'<center>';
    echo'<br><font color=red> !CAJA CERRADA¡ </font>';
     echo'</center>';



 ?>


<!--RERESANDO A PAGINA PEDIR FONDO-->
 <center><A href="../fondo.php">ATRAS</A></center>
</body>
</html>
