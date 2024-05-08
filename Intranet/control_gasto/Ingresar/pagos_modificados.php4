<html>
<body background="imagenes\amarillo1.jpg">
<?php
   $link=mysql_connect("200.1.6.254","root");
   mysql_select_db("bd_contrato_maestranza",$link);
   $ban=0;

   if($parametro2 == "" || $parametro1 == "")
     {
         $ban=1;
     }


    if($ban != 0)
    {
          echo "<center>"."<h1>"."¡ERROR DE INGRESO,INTENTELO NUEVAMENTE!"."</h1>"."</center>";
    }
    else
    {
                $sql="update pagos set numero_contrato = '$parametro1',ano_pago = '$parametro2',enero = '$Enero',febrero = '$Febrero',marzo = '$Marzo',abril = '$Abril',mayo = '$Mayo',junio = '$Junio',julio = '$Julio',agosto = '$Agosto',septiembre = '$Septiembre',octubre = '$Octubre',noviembre = '$Noviembre',diciembre = '$Diciembre' where numero_contrato = '$parametro1' and ano_pago = '$parametro2'";
                $result=mysql_query($sql);
                echo "<center>"."<h1>"."¡EL REGISTRO SE HA MODIFICADO!"."</h1>"."</center>";
    }

?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_pagos.html">Atras contratista</A></H2>


</body>
</html>

