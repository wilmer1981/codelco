   <html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $largo1=strlen($Rut1);
    $largo2=strlen($Rut2);
    $i=0;$j=0;$ban=0;

    if ($Numero_contrato == "")
       {
           $ban=1;
       }

     if ($fecha_evaluacion == "")
        {
            $ban=1;
        }

    while($i<$largo1)
     {
          if(!($Rut1[$i] <= ':' && $Rut1[$i] >= '/'))
          {
              $ban=1;
          }
          $i=$i+1;
     }
     if(!($D <= ':' && $D >= '/') && (($D != 'k') && ($D != 'K')))
              {$ban=1;}


     while($j<$largo2)
     {
          if(!($Rut2[$j] <= ':' && $Rut2[$j] >= '/'))
          {
              $ban=1;
          }
          $j=$j+1;
     }
     if(!($Dv <= ':' && $Dv >= '/') && (($Dv != 'k') && ($Dv != 'K')))
     {
         $ban=1;
         }

     if ($Concepto1 == "")
        {
            $ban=1;
        }
     if ($Concepto2 == "")
        {
            $ban=1;
        }
     if ($Concepto3 == "")
        {
            $ban=1;
        }
     if ($Concepto4 == "")
        {
            $ban=1;
        }
     if ($Concepto5 == "")
        {
            $ban=1;
        }
     if ($Concepto6 == "")
        {
            $ban=1;
        }
     if ($Concepto7 == "")
        {
            $ban=1;
        }
     if ($Concepto8 == "")
        {
            $ban=1;
        }
     if ($Concepto9 == "")
        {
            $ban=1;
        }
     if ($Concepto10 == "")
        {
            $ban=1;
        }


     if ($ban == 0 )
     {
         echo "<center>"."<h1>"."ERROR DE INGRESO , INTENTELO NUEVAMENTE"."</h1>"."</center>";
     }
     else
     {
            if ($Rut1 == "")
            {
                echo "<center>"."<h1>"."ERROR DE INGRESO , INTENTELO NUEVAMENTE"."</h1>"."</center>";
            }else
            {
                $g.='-';
                $Rut1=$Rut1.$g.$D;

                $sql="select * from evaluacion where rut_jefe_acepta = '$Rut1'";
                $result=mysql_query($sql);
                if($row['rut_jefe_acepta']==$Rut1)
               {
                   echo "<center>"."<h1>"."¡ERROR DE INGRESO, RUT EXISTENTE!"."</h1>"."</center>";
               }else
               {
                   if ($Rut2== "")
                   {
                        echo "<center>"."<h1>"."ERROR DE INGRESO"."</h1>"."</center>";
                   }else
                   {
                       $Rut2=$Rut2.$g.$Dv;
                       $sql="select * from evaluacion where rut_encargado = '$Rut2'";
                       $result=mysql_query($sql);
                       if($row['rut_encargado']==$Rut2)
                       {
                          echo "<center>"."<h1>"."¡ERROR DE INGRESO, RUT EXISTENTE!"."</h1>"."</center>";
                       }else
                       {
                       $sql="Insert into evaluacion(numero_contrato,fecha_evaluacion,rut_encargado,rut_jefe_acepta,concepto1,concepto2,concepto3,concepto4,concepto5,concepto6,concepto7,concepto8,concepto9,concepto10) Values('$Numero_contrato','$Fecha_evaluacion','$Rut2','$Rut1','$Concepto1','$Concepto2','$Concepto3','$Concepto4','$Concepto5','$Concepto6','$Concepto7','$Concepto8','$Concepto9','$Concepto10')";
                       $result=mysql_query($sql);
                       echo "<center>"."<h1>"."¡REGISTRO EXITOSO!"."</h1>"."</center>";
                       }

                   }

               }
            }
     }



?>

<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/add_contratos.html">ATRAS</A></H2>

</body>
</html>

