<?php
include("../principal/conectar_cal_web.php");
$CookieRut = $_COOKIE["CookieRut"];	
$proceso = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:'';
$Muestras = isset($_REQUEST["Muestras"])?$_REQUEST["Muestras"]:'';
$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:'';
$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:'';
$CmbDias = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:'';
$CmbHora = isset($_REQUEST["CmbHora"])?$_REQUEST["CmbHora"]:'';
$CmbMinutos = isset($_REQUEST["CmbMinutos"])?$_REQUEST["CmbMinutos"]:'';
$Periodo = isset($_REQUEST["Periodo"])?$_REQUEST["Periodo"]:'';
$Modificar = isset($_REQUEST["Modificar"])?$_REQUEST["Modificar"]:'';
$CmbProductos = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:'';
$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:'';
$Producto = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:'';
$GenerarVal = isset($_REQUEST["GenerarVal"])?$_REQUEST["GenerarVal"]:'';

$ValCheck = $Muestras;
$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias." ".$CmbHora.":".$CmbMinutos.":00";
$Rut =$CookieRut;
for ($j = 0;$j <= strlen($Muestras); $j++)
{
	if (substr($Muestras,$j,2) == "//")
	{
		$MuestraFecha = substr($Muestras,0,$j);
		for ($x=0;$x<=strlen($MuestraFecha);$x++)
			{
			if (substr($MuestraFecha,$x,2) == "~~")
				{
					$Muestra = substr($MuestraFecha,0,$x);			
					$Fecha = substr($MuestraFecha,$x+2,19);
					switch ($Periodo)
					{
						case "1":
							$Actualizar = "UPDATE cal_web.plantilla_solicitud_analisis set cod_periodo ='".$Periodo."' where  fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
							break;
						case "2":
							$Actualizar = "UPDATE cal_web.plantilla_solicitud_analisis set cod_periodo ='".$Periodo."' where  fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
							break;
						case "3":
							$Actualizar = "UPDATE cal_web.plantilla_solicitud_analisis set cod_periodo ='".$Periodo."' where  fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
						break;
						case "4":
							$Actualizar = "UPDATE cal_web.plantilla_solicitud_analisis set cod_periodo ='".$Periodo."' where  fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
						case "5":
							$Actualizar = "UPDATE cal_web.plantilla_solicitud_analisis set cod_periodo ='".$Periodo."' where  fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
						
						break;
					}
				}
			}
	$Muestras = substr($Muestras,$j +2);
	$j=0;	
	}
}
if ($Modificar!="" and($Modificar=='S'))
{			
	header("location:../cal_web/cal_generacion_plantillas_solicitudes.php?Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&Modificar=".$Modificar."&FechaHora=".$Fecha);
	
}
else
{
	header("location:../cal_web/cal_generacion_plantillas_solicitudes.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&FechaHora=".$Fecha);
}
if ($proceso=="R")
{
	header("location:cal_generacion_plantillas_solicitudes.php?GenerarValidacion=".$GenerarVal."&CmbProductos=".$Producto);
}	
?>