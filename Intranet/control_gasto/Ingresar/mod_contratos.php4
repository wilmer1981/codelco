<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $ban=0;
     if($Nombre_contrato == "")
     {
         $ban=1;
     }
      if($Tipo_contrato == "")
     {
         $ban=1;
     }
     if($Numero_solicitud == "")
     {
         $ban=1;
     }
     if($Fecha_ini_contrato == "")
     {
         $ban=1;
     }
     if($Fecha_ter_contrato == "")
     {
         $ban=1;
     }

     while($i<$largo)
     {
          if(!($Rut_adjudicado[$i] <= ':' && $Rut_adjudicado[$i] >= '/'))
          {
              $ban=1;
          }
          $i=$i+1;
     }
     if(!($Dv <= ':' && $Dv >= '/') && (($Dv != 'k') && ($Dv != 'K')))
     {
         $ban=1;
     }

     if($Valor_trabajo == "")
     {
         $ban=1;
     }
       if($Codigo_moneda == "")
     {
         $ban=1;
     }
      if($Fecha_entrega_contrato == "")
     {
         $ban=1;
     }

     while($j<$largo1)
     {
          if(!($Rut_encargado[$j] <= ':' && $Rut_encargado[$j] >= '/'))
          {
              $ban=1;
          }
          $j=$j+1;
     }
     if(!($D <= ':' && $D >= '/') && (($D != 'k') && ($D != 'K')))
     {
         $ban=1;

      }
      if($Codigo_estado == "")
     {
         $ban=1;
     }
      if($Numero_factura == "")
     {
         $ban=1;
     }
     if($Multa == "")
     {
         $ban=1;
     }
     if($Item_gastos == "")
     {
         $ban=1;
     }
     if($Evaluacion_anexo == "")
     {
         $ban=1;
     }
     if($Observaciones == "")
     {
         $ban=1;
     }
    if ($ban == 0)

    {$g='-';
     $Rut_adjudicado=$Rut_adjudicado.$g.$Dv;
     $Rut_Encargado=$Rut_encargado.$g.$D;
     $sql="update contratos  set nombre_contrato='$Nombre_contrato',tipo_contrato='$Tipo_contrato',numero_solicitud='$Numero_solicitud',fecha_ini_contrato='$Fecha_ini_contrato',fecha_ter_contrato='$Fecha_ter_contrato',rut_adjudicado='$Rut_adjudicado',valor_trabajo='$Valor_trabajo',codigo_moneda='$Codigo_moneda',fecha_entrega_contrato='$Fecha_entrega_contrato',rut_encargado='$Rut_encargado',codigo_estado='$Codigo_estado',numero_factura='$Numero_factura',multa='$Multa',item_gastos='$Item_gastos',evaluacion_anexo='$Evaluacion_anexo',observaciones='$Observaciones' where numero_contrato='$Mod'";
     $result=mysql_query($sql);
     echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";

    }
    else
    {
        echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
    }

?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_contratos.html">ATRAS</A></H2>

</UL>
</form>

</body>
</html>
