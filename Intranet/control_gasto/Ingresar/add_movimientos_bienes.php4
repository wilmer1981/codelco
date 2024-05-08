<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);

     $largo=strlen($Rut);
     $i=0;$ban=0;
     while($i<$largo)
     {
          if(!($Rut[$i] <= ':' && $Rut[$i] >= '/'))
          {
              $ban=1;
          }
          $i=$i+1;
     }
     if(!($Dv <= ':' && $Dv >= '/') && (($Dv != 'k') && ($Dv != 'K')))
     {
         $ban=1;
     }
     if($Numero == "")
     {
         $ban=1;
     }
     if($Tipo == "")
     {
         $ban=1;
     }
     if($Fecha_mov == "")
     {
         $ban=1;
     }
     if($Procedencia == "")
     {
         $ban=1;
     }
     if($Destino == "")
     {
         $ban=1;
     }
     if($CC == "")
     {
         $ban=1;
     }
     if($Guia == "")
     {
         $ban=1;
     }
     if($Fecha_guia == "")
     {
         $ban=1;
     }
     if($Observacion == "")
     {
         $ban=1;
     }
     if($Rut == "")
     {
          $ban=1;
     }
    if($ban != 0)
    {
          echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
    }
    else
    {
           $g='-';
           $Rut=$Rut.$g.$Dv;
           $sql="select * from movimientos_bienes where numero_contrato = '$Numero' and tipo_movimiento='$Tipo'";
           $result=mysql_query($sql);
           if($row = mysql_fetch_array($result))
           {
                echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
           }else
           {
                $sql="INSERT INTO movimientos_bienes(numero_contrato,tipo_movimiento,fecha_movimiento,procedencia,destino,rut_autoriza,centro_costo,guia_despacho,fecha_guia,observacion) VALUES('$Numero','$Tipo','$Fecha_mov','$Procedencia','$Destino','$Rut','$CC','$Guia','$Fecha_guia','$Observacion')";
                $result=mysql_query($sql);
                echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</h1>"."</center>";
           }

    }

?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/add_movimientos_bienes.html">ATRAS</A></H2>



</body>
</html>

