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

    if($ban == 0)
       {
           $sql="select * from contratos where numero_contrato = '$Rut'";
           $result=mysql_query($sql);
           $row = mysql_fetch_array($result);
           echo $parametro;
           $sql="update contratistas set sigla_contratista='$Sigla',nombre_contratista='$Nombre',apellidos_contratista='$Apellido',direccion_contratista='$Direccion',numero_telefonico='$Telefono',numero_fax='$Fax',IMail='$Mail',codigo_esp_contratista='$Cod_especialidad',estado_contratista='$Estado_contratista' where rut_contratista='$parametro'";
           $result=mysql_query($sql);
           echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";
       }else
       {
          echo "<center>"."<h1>"."¡ERROR,INTENTELO NUEVAMENTE!"."</h1>"."</center>";
        }



?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_contratista.html">Atras</A></H2>


</body>
</html>

