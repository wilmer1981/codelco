
<?php
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;
$Fecha_ini=$ano."-".$mes."-01";
$Cod_Tipo="2";
$Acum_Raf1="0";
$Acum_Raf2="0";

$sql = "SELECT SUM(Campo1) as Acum_Raf1, SUM(Campo2) as Acum_Raf2 FROM informe_diario.fundicion
        WHERE Cod_Tipo = '$Cod_Tipo' and Fecha BETWEEN '$Fecha_ini' and '$Fecha'";

$result = mysqli_query($link,$sql);

  
if($row = mysqli_fetch_array($result))
{
 $Acum_Raf1 = $row["Acum_Raf1"];
 $Acum_Raf2 = $row["Acum_Raf2"];
} 

     echo "$Acum_Raf1";
    include("cerrar.php"); 
?>
