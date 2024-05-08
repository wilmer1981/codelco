<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $ban=0;
     if ($Fecha_evaluacion == "")
        {$ban=1;}

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
        {$ban=1;}
     if ($Concepto2 == "")
        {$ban=1;}
     if ($Concepto3 == "")
        {$ban=1;}
     if ($Concepto4 == "")
        {$ban=1;}
     if ($Concepto5 == "")
        {$ban=1;}
     if ($Concepto6 == "")
        {$ban=1;}
     if ($Concepto7 == "")
        {$ban=1;}
     if ($Concepto8 == "")
        {$ban=1;}
     if ($Concepto9 == "")
        {$ban=1;}
     if ($Concepto10 == "")
        {$ban=1;}





    if ($ban == 0)
    {
    $g='-';
    $Rut1=$Rut1.$g.$D;
    $Rut2=$Rut2.$g.$Dv;
    $sql="update evaluacion  set fecha_evaluacion='$Fecha_evaluacion',rut_encargado='$Rut2',rut_jefe_acepta='$Rut1',concepto1='$Concepto1',concepto2='$Concepto2',concepto3='$Concepto3',concepto4='$Concepto4',concepto5='$Concepto5',concepto6='$Concepto6',concepto7='$Concepto7',concepto8='$Concepto8',concepto9='$Concepto9',concepto10='$Concepto10' where numero_contrato='$Mod'";
    $result=mysql_query($sql);
    echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";

        }
    else
    {
        echo "<center>"."<h1>"."¡ERROR,INGRESAR TODOS LOS CAMPOS!"."</h1>"."</center>";
    }

?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/op_buscar.html">Atras</A></H2>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/operaciones.html">Atras Operaciones</A></H2>

</UL>
</form>

</body>
</html>
