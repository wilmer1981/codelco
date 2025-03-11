<?php
include("../principal/conectar_cal_web.php");
$CookieRut = $_COOKIE["CookieRut"];	
$Muestras = isset($_REQUEST["Muestras"])?$_REQUEST["Muestras"]:'';
$Periodo = isset($_REQUEST["Periodo"])?$_REQUEST["Periodo"]:'';
$Modificar = isset($_REQUEST["Modificar"])?$_REQUEST["Modificar"]:'';
$CmbProductos = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:'';
$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:'';
$SolAut = isset($_REQUEST["SolAut"])?$_REQUEST["SolAut"]:'';
$BuscarDetalle = isset($_REQUEST["BuscarDetalle"])?$_REQUEST["BuscarDetalle"]:'';
$BuscarPrv = isset($_REQUEST["BuscarPrv"])?$_REQUEST["BuscarPrv"]:'';
$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:'';
$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:'';
$CmbDias = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:'';
$CmbHora = isset($_REQUEST["CmbHora"])?$_REQUEST["CmbHora"]:'';
$CmbMinutos = isset($_REQUEST["CmbMinutos"])?$_REQUEST["CmbMinutos"]:'';
$CmbTipoAnalisis = isset($_REQUEST["CmbTipoAnalisis"])?$_REQUEST["CmbTipoAnalisis"]:'';


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
					if ($SolAut=="S")
					{
						$Recargo=substr($MuestraFecha,$x+21,strlen($MuestraFecha));
						if ($Recargo!="N")
						{
							switch ($Periodo)
							{
								case "1":
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año=NULL,mes=NULL,nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' and recargo='".$Recargo."'";					
									mysqli_query($link, $Actualizar);
									break;
								case "2":
									$Consulta =" select week('$FechaI') as NumSemana   ";
									$Respuesta = mysqli_query($link, $Consulta);
									$Fila=mysqli_fetch_array($Respuesta);
									$NSemana=$Fila[NumSemana]; 
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana='$NSemana' where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' and recargo='".$Recargo."'";					
									mysqli_query($link, $Actualizar);
									break;
								case "3":
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' and recargo='".$Recargo."'";					
									mysqli_query($link, $Actualizar);
									break;
								case "4":
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' and recargo='".$Recargo."'";					
									mysqli_query($link, $Actualizar);
									break;
								case "5":
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' and recargo='".$Recargo."'";					
									mysqli_query($link, $Actualizar);
									break;
							}
						}
						else//Automatica Sin Recargo 
						{
							switch ($Periodo)
							{
								case "1":
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año=NULL,mes=NULL,nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
									mysqli_query($link, $Actualizar);
									break;
								case "2":
									$Consulta =" select week('$FechaI') as NumSemana   ";
									$Respuesta = mysqli_query($link, $Consulta);
									$Fila=mysqli_fetch_array($Respuesta);
									$NSemana=$Fila[NumSemana]; 
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana='$NSemana' where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
									mysqli_query($link, $Actualizar);
									break;
								case "3":
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
									mysqli_query($link, $Actualizar);
									break;
								case "4":
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
									mysqli_query($link, $Actualizar);
								break;
								case "5":
									$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
									mysqli_query($link, $Actualizar);
								break;
							}
						}		
					}
					else//Si Es Especial
					{	
						switch ($Periodo)
						{
							case "1":
								$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año=NULL,mes=NULL,nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
								mysqli_query($link, $Actualizar);
								break;
							case "2":
								$Consulta =" select week('$FechaI') as NumSemana   ";
								$Respuesta = mysqli_query($link, $Consulta);
								$Fila=mysqli_fetch_array($Respuesta);
								$NSemana=$Fila[NumSemana]; 
								$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana='$NSemana' where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
								mysqli_query($link, $Actualizar);
								break;
							case "3":
								$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
								mysqli_query($link, $Actualizar);
								break;
							case "4":
								$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
								mysqli_query($link, $Actualizar);
								break;	
							case "5":
								$Actualizar = "UPDATE solicitud_analisis set cod_periodo ='".$Periodo."',fecha_muestra='$FechaI',año='$CmbAno',mes='$CmbMes',nro_semana=NULL where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' ";					
								mysqli_query($link, $Actualizar);
								break;	
						}
					}					
				}
			}
	$Muestras = substr($Muestras,$j +2);
	$j=0;	
	}
}
if ($SolAut == 'S')
{
	if ($Modificar!="" and ($Modificar=='S'))
	{			
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmSolicitudAut.action='cal_solicitud_Automatica.php?Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorCheck=".$ValCheck."&Modificar=".$Modificar."';";
		echo "window.opener.document.FrmSolicitudAut.submit();";
		echo "window.close();</script>";
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmSolicitudAut.action='cal_solicitud_Automatica.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorCheck=".$ValCheck."&Buscar=".$BuscarDetalle."&BuscarPrv=".$BuscarPrv."';";
		echo "window.opener.document.FrmSolicitudAut.submit();";
		echo "window.close();</script>";
	}	
}
else
{
	if (isset($Modificar)and($Modificar=='S'))
	{			
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitud.action='cal_solicitud.php?Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&ValorCheck=".$ValCheck."&Modificar=".$Modificar."';";
		echo " window.opener.document.FrmSolicitud.submit();";
		echo "window.close();</script>";
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitud.action='cal_solicitud.php?ValorCheck=".$ValCheck."';";
		echo " window.opener.document.FrmSolicitud.submit();";
		echo "window.close();</script>";
	}	
}
?>