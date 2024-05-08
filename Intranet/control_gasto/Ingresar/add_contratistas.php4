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
     }else
     if($Sigla == "")
     {
         $ban=1;
     }else
     if($Nombre == "")
     {
         $ban=1;
     }else
     if($Apellidos == "")
     {
         $ban=1;
     }else
     if($Direccion == "")
     {
         $ban=1;
     }else
     if($Telefono == "")
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
      if($Rut == "")
      {
          echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
      }else
      {
           $Rut=$Rut.$g.$Dv;
           
           $sql="select * from contratistas where rut_contratista = '$Rut'";
           $result=mysql_query($sql);
           $row = mysql_fetch_array($result);
           if($row['rut_contratista']==$Rut)
           {
                echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
           }else
           {
                $sql="INSERT INTO contratistas(rut_contratista,sigla_contratista,nombre_contratista,apellidos_contratista,direccion_contratista,numero_telefonico,numero_fax,imail,codigo_esp_contratista,estado_contratista) VALUES('$Rut','$Sigla','$Nombre','$Apellidos','$Direccion','$Telefono','$Fax','$Email','$cod_especialidad','$estado_contratista')";
                $result=mysql_query($sql);
                echo "<center>"."<h1>"."¡INGRESO EXITOSO!"."</h1>"."</center>";
           }
      }
    }

?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/Ingresar/ing_contratistas.html">ATRAS</A></H2>


</body>
</html>

