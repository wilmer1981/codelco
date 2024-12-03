
<?php
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;
$Fecha_ini=$ano."-".$mes."-01";
$Cod_Tipo="4";
$Acum_K3="0";
$Acum_K4="0";
$Acum_K5="0";

$sql = "SELECT SUM(Campo9) as Acum_K3, SUM(Campo10) as Acum_K4, SUM(Campo11) as Acum_K5 FROM informe_diario.fundicion
        WHERE Cod_Tipo = '$Cod_Tipo' and Fecha BETWEEN '$Fecha_ini' and '$Fecha'";

$result = mysqli_query($link,$sql);

  
if($row = mysqli_fetch_array($result))
{
 $Acum_K3 = $row["Acum_K3"];
 $Acum_K4 = $row["Acum_K4"];
 $Acum_K5 = $row["Acum_K5"];
} 

    include("cerrar.php"); 
?>
