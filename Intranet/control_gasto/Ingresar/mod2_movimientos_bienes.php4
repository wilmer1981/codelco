<html>
<body background="imagenes\amarillo1.jpg">

<?php

    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $esp=0;

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
          echo "<center>"."<h1>"."¡FALTAN PARAMETROS!"."</h1>"."</center>";
    }
    else
    {
           $g='-';
           $Rut=$Rut.$g.$Dv;
           $sql="update movimientos_bienes set fecha_movimiento='$Fecha_mov',procedencia='$Procedencia',destino='$Destino',rut_autoriza='$Rut',centro_costo='$CC',guia_despacho='$Guia',fecha_guia='$Fecha_guia',observacion='$Observacion' where numero_contrato='$Mod' and tipo_movimiento='$Mod1'";
           $result=mysql_query($sql);
           echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";

    }
?>

<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/search_movimientos_bienes.html">ATRAS</A></H2>


</UL>
</form>

</body>
</html>
