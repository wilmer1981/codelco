<?php
include("../principal/conectar_cal_web.php");
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
							$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',a�o=NULL,mes=NULL,nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
							break;
						case "2":
							$Consulta =" select week('$FechaI') as NumSemana   ";
							$Respuesta = mysqli_query($link, $Consulta);
							$Fila=mysqli_fetch_array($Respuesta);
							$NSemana=$Fila[NumSemana]; 
							$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',a�o='$CmbAno',mes='$CmbMes',nro_semana='$NSemana' where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
							break;
						case "3":
							$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',a�o='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
						break;
						case "4":
							$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',a�o='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
						break;
						case "5":
							$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',a�o='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
							mysqli_query($link, $Actualizar);
						break;
					}
				}
			}
	$Muestras = substr($Muestras,$j +2);
	$j=0;	
	}
}
if (isset($Modificar)and($Modificar=='S'))
{			
	echo "<script languaje='JavaScript'>";
	echo " window.opener.document.FrmSolicitud.action='cal_solicitud_frx.php?Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&Modificar=".$Modificar."';";
	echo " window.opener.document.FrmSolicitud.submit();";
	echo "window.close();</script>";
}
else
{
	echo "<script languaje='JavaScript'>";
	echo " window.opener.document.FrmSolicitud.action='cal_solicitud_frx.php';";
	echo " window.opener.document.FrmSolicitud.submit();";
	echo "window.close();</script>";
}	
?>