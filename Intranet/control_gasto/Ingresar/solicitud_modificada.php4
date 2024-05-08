<html>
<body background="imagenes\amarillo1.jpg">
<?php
$link=mysql_connect("200.1.6.254","root");
mysql_select_db("bd_contrato_maestranza",$link);
$ban=0;
$largo=strlen($Rut);

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
if($Descripcion == "")
{
    $ban=1;
}else
if($Tipo_solicitud == "")
{
    $ban=1;
}else
if($Fecha_entrega == "")
{
    $ban=1;
}else
if($Cc_entrega == "")
{
    $ban=1;
}else
if($Equipo == "")
{
    $ban=1;
}else
if($Tipo_trabajo == "")
{
    $ban=1;
}else
if($Fecha_solicitud == "")
{
    $ban=1;
}else
if($Numero_plano == "")
{
    $ban=1;
}else
if($Rut == "")
{
    $ban=1;
}else
if($Observacion_plano == "")
{
    $ban=1;
}else
if($Muestra == "")
{
    $ban=1;
}else
if($Numero_base_tecnica == "")
{
    $ban=1;
}else
if($Codigo_moneda == "")
{
    $ban=1;
}else
if($Item_gasto == "")
{
    $ban=1;
}else
if($Observaciones == "")
{
    $ban=1;
}
if($ban == 1)
{
    echo "<center>"."<h1>"."¡ERROR DE INGRESO!"."</h1>"."</center>";
}else
{
   $g='-';
   $Rut=$Rut.$g.$Dv;
   $sql="update solicitud set descripcion='$Descripcion',tipo_solicitud='$Tipo_solicitud',fecha_entrega='$Fecha_entrega',cc_entrega='$Cc_entrega',equipo='$Equipo',tipo_trabajo='$Tipo_trabajo',fecha_solicitud='$Fecha_solicitud',numero_plano='$Numero_plano',rut_solicitante='$Rut',observacion_plano='$Observacion_plano',muestra='$Muestra',numero_base_tecnica='$Numero_base_tecnica',codigo_moneda='$Codigo_moneda',item_gasto='$Item_gasto',observaciones='$Observaciones' where numero_solicitud = '$parametro'";
   $result=mysql_query($sql);
   echo "<center>"."<h1>"."¡MODIFICACION EXITOSA!"."</h1>"."</center>";
}
?>

<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_solicitud.html">ATRAS</A></H2>

</body>
</html>

