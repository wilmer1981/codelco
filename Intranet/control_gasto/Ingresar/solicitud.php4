<html>
<body background="imagenes\amarillo1.jpg">
<?php
$link=mysql_connect("200.1.6.254","root");
      mysql_select_db("bd_contrato_maestranza",$link);
      $largo1=strlen($Rut);
      $i=0;$ban=0;
      while($i<$largo1)
      {
          if(!($Rut[$i] <= ':' && $Rut[$i] >= '/'))
          {
              $ban=1;
          }
          $i=$i+1;
      }
      if(!($Dv <= ':' && $Dv >= '/') && (($Dv != 'k') && ($Dv != 'K')))
              {$ban=1;}
              
 if($Numero_solicitud == "")
        {$ban=1;}
        
 if ($Descripcion == "")
        {$ban=1;}
        
 if ($Tipo_solicitud == "")
        {$ban=1;}
        
 if ($Fecha_entrega == "")
        {$ban=1;}
        
 if ($CC_entrega == "")
        {$ban=1;}
        
 if ($Equipo == "")
        {$ban=1;}
        
 if ($Tipo_trabajo == "")
        {$ban=1;}
        
 if ($Fecha_solicitud == "")
        {$ban=1;}
        
 if ($Numero_plano == "")
        {$ban=1;}
        
 if ($Observacion_plano == "")
        {$ban=1;}
        
 if ($Muestra == "")
        {$ban=1;}
        
 if ($Numero_base_tecnica == "")
        {$ban=1;}
        
 if ($Codigo_moneda == "")
        {$ban=1;}
        
 if ($Item_gasto == "")
        {$ban=1;}
        
 if ($Observaciones == "")
        {$ban=1;}
        

 if ($ban != 0)
     {
         echo "<center>"."<h1>"."ERROR DE INGRESO , INTENTELO NUEVAMENTE"."</h1>"."</center>";
     }
     else
    {
      $g='-';
      $Rut=$Rut.$g.$Dv;
      $sql="INSERT INTO solicitud(numero_solicitud,descripcion,tipo_solicitud,fecha_entrega,cc_entrega,equipo,tipo_trabajo,fecha_solicitud,rut_solicitante,numero_plano,observacion_plano,muestra,numero_base_tecnica,codigo_moneda,item_gasto,observaciones) VALUES('$Numero_solicitud','$Descripcion','$Tipo_solicitud','$Fecha_entrega','$CC_entrega','$Equipo','$Tipo_trabajo','$Fecha_solicitud','$Rut_solicitante','$Numero_plano','$Observacion_plano','$Muestra','$Numero_base_tecnica','$Codigo_moneda','$Item_gasto','$Observaciones')";
      $result=mysql_query($sql);
      echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</h1>"."</center>";
      }
?>

<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/add_contratos.html">Atras Contratos</A></H2>
<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/op_ingresos.html">Atras Ingresos</A></H2>

</body>
</html>
