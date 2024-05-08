<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $ban=0;
     if($Ano == "")
     {
         $ban=1;
     }
     
     
    if($ban != 0)
    {
          echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
    }
    else
    {
                $sql="select * from pagos where numero_contrato = '$Numero_contrato' and ano_pago = '$Ano'";
                $result=mysql_query($sql);
                if($row = mysql_fetch_array($result))
                {
                    echo "<center>"."<h1>"."¡REGISTRO REPETIDO!"."</h1>"."</center>";
                }else
                {
                    $sql="INSERT INTO pagos (numero_contrato,ano_pago,enero,febrero,marzo,abril,mayo,junio,julio,agosto,septiembre,octubre,noviembre,diciembre) values('$Numero_contrato','$Ano','$Enero','$Febrero','$Marzo','$Abril','$Mayo','$Junio','$Julio','$Agosto','$Septiembre','$Octubre','$Noviembre','$Diciembre')";
                    $result=mysql_query($sql);
                    echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</h1>"."</center>";

                }
    }

?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/add_pagos.html">ATRAS</A></H2>


</body>
</html>

