
<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;
$Fecha_ini=$ano."-".$mes."-01";
$Cod_Tipo="1";
$Acum_T_Soplado="0";
$sql = "SELECT SUM(Campo4) as Acum_T_Soplado FROM fundicion
        WHERE Cod_Tipo = '$Cod_Tipo' and Fecha BETWEEN '$Fecha_ini' and '$Fecha'";

$result = mysql_query($sql, $link);

  
if($row = mysql_fetch_array($result))
{
 $Acum_T_Soplado = $row[Acum_T_Soplado];
} 

		$Total_mes = ($Acum_T_Soplado / ($dia * 24)) * 100;
		$Total_mes = substr($Total_mes,0,4);
		echo "$Total_mes";

    include("cerrar.php");
?>