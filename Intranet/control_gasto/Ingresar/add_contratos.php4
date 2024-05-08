<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    $largo=strlen($Rut_adjudicado);
    $largo1=strlen($Rut_encargado);
    $i=0;$j=0;$ban=0;
    if($Numero_contrato == "")
     {
         $ban=1;
     }
     if($Nombre_contrato == "")
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
      if($Numero_factura == "")
     {
         $ban=1;
     }
     if($Multa == "")
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


     if($ban == 0)
       {        $g='-';
                 $Rut_adjudicado=$Rut_adjudicado.$g.$Dv;
                $Rut_encargado=$Rut_encargado.$g.$D;
                $sql="INSERT INTO contratos(numero_contrato,nombre_contrato,tipo_contrato,numero_solicitud,fecha_ini_contrato,fecha_ter_contrato,rut_adjudicado,valor_trabajo,codigo_moneda,fecha_entrega_contrato,rut_encargado,codigo_estado,numero_factura,multa,item_gastos,evaluacion_anexo,observaciones) VALUES('$Numero_contrato','$Nombre_contrato','$Tipo_contrato','$Numero_solicitud','$Fecha_ini_contrato','$Fecha_ter_contrato','$Rut_adjudicado','$Valor_trabajo','$Codigo_moneda','$Fecha_entrega_contrato','$Rut_encargado','$Codigo_estado','$Numero_factura','$Multa','$Item_gastos','$Evaluacion_anexo','$Observaciones')";
                $result=mysql_query($sql);
                echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</h1>"."</center>";
           }else
     {
        echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
     }




?>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/add_contratos.html">ATRAS</A></H2>
</body>
</html>

